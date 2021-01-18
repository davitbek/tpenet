<?php

namespace Api\V1\Services\Enet;

use Api\V1\Models\Enet\EnetDraw;
use Api\V1\Models\Enet\EnetTournamentStage;
use Api\V1\Models\UserFavoriteEnetTournamentTemplate;
use App\Models\Admin\Enet\EnetFavoriteTournamentTemplate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use LaraAreaApi\Exceptions\ApiException;

class EnetTournamentStageService extends BaseService
{
    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function userLeagues($data = [])
    {
        $options = [
            'where_has' => [
                'user_favorite_tournament_templates' => [
                    'where' => [
                        'user_id' => $this->getAuthUserId()
                    ]
                ]
            ],
            'where' => [
                ['is_active', '=', \ConstYesNo::YES]
            ]
        ];

        $options = $this->getQueryOptions($data, $options);
        $item =  $this->model->getByArray($options);
        return $item;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allLeagues($data)
    {
        $options = [];
        if (empty($data['include_in_active'])) {
            $options['where'][] = ['is_active', '=', \ConstYesNo::YES];
        }
        $options = $this->getQueryOptions($data, $options);
        $item =  $this->model->getByArray($options);
        return $item;
    }

    /**
     * @param $data
     * @param $options
     * @return mixed
     */
    protected function getQueryOptions($data, $options)
    {
        $options['columns'] = ['id', 'name', 'league_name', 'readable_id', 'image_disk', 'image_path', 'country_id', 'sport_id'];
        $options['limit'] = $data['limit'] ?? config('api_config.limit');


        if (! empty($data['search'])) {
            $options['where'][] = ['name', 'like' , '%' . $data['search'] . '%'];
        }

        if (! empty($data['date'])) {
            $options['where_has']['events']['where_date']['start_date'] = $data['date'];
            $options['with_count']['events'] = function ($q) use ($data){
                $q->whereDate('start_date', $data['date']);
            };
        }

        if (! empty($data['country_id'])) {
//            $options['where']['country_id'] = $data['country_id'];
        }

        if (! empty($data['sport_id'])) {
            $options['where']['sport_id'] = $data['sport_id'];
        }
        if (! empty($data['year'])) {
            $options['where'][] = ['years', 'like', '%' . $data['year'] .'%'];
        }
        return $options;
    }

    /**
     * @param $leaguedId
     * @return array
     * @throws ApiException
     */
    public function favoriteUnFavorite($leaguedId)
    {
        $authUser = $this->getAuth();
        $userId = $this->getAuthUserId();
        $league = EnetTournamentStage::where('id', $leaguedId)->select(['id', 'tournament_template_id', 'sport_id'])->with('tournament_template:id,sport_id')->first();
        if(! $league) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_tournament_stage'));
        }

        $templateId = $league->tournament_template_id;
        if (! $templateId) {
            return ['is_favorite' => true];
        }
        $sportId = $league->tournament_template->sport_id ?? $league->sport_id;

        if ($sportId) {
            $config = get_auth_favorite_sport_template_config($authUser);
            if (in_array($sportId, $config['general'])) {
                $language = \App::getLocale();
                $templateIds = EnetFavoriteTournamentTemplate::where('lang', $language)
                    ->where('sport_id', $sportId)
                    ->pluck('tournament_template_id')->all();

                if (in_array($templateId, $templateIds)) {
                    $templateIds = array_diff($templateIds, [$templateId]);
                    $response =  ['is_favorite' => false];
                } else {
                    $templateIds[] = $templateId;
                    $response =  ['is_favorite' => true];
                }

                \DB::beginTransaction();
                $userId = $this->getAuthUserId();
                foreach ($templateIds as $id) {
                    UserFavoriteEnetTournamentTemplate::create([
                        'user_id' => $userId,
                        'tournament_template_id' => $templateId,
                        'created_at' => now()
                    ])->first();
                }

                $config['own'][] = $sportId;
                $config['general'] = array_diff($config['general'], [$sportId]);
                $authUser->update(['edited_sport_templates' => json_encode($config)]);
                \DB::commit();
                return $response;
            }
        }

        $favoriteTemplate = UserFavoriteEnetTournamentTemplate::where([
            'user_id' => $userId,
            'tournament_template_id' => $templateId,
        ])->first();

        if ($favoriteTemplate) {
            $favoriteTemplate->delete();
            return ['is_favorite' => false];
        }

        UserFavoriteEnetTournamentTemplate::create([
            'user_id' => $userId,
            'tournament_template_id' => $templateId,
            'created_at' => now()
        ]);

        return ['is_favorite' => true];
    }

    /**
     * @param $data
     * @return array
     * @throws ApiException
     */
    public function makeInitialFavorite($data)
    {
        $authUser = $this->getAuth();
        $config = get_auth_favorite_sport_template_config($authUser);
        if (in_array($data['sport_id'], $config['own'])) {
            throw new ApiException(\ConstErrorCodes::AlreadySelectedFavoriteLeagues, 'This user already selected own favorite leagues for this sport.  Use second endpoint');
        }

        $language = \App::getLocale();

        $templateIds = EnetFavoriteTournamentTemplate::where('lang', $language)
            ->where('sport_id', $data['sport_id'])
            ->pluck('tournament_template_id')->all();

        if (! empty($data['favorite'])) {
            if(! EnetTournamentStage::where('id', $data['favorite'])->where('sport_id', $data['sport_id'])->exists()) {
                throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_tournament_stage'));
            }
            $templateIds[] = EnetTournamentStage::where('id', $data['favorite'])->value('tournament_template_id');
            $response =  ['is_favorite' => true];
        } else {
            if(! EnetTournamentStage::where('id', $data['unfavorite'])->where('sport_id', $data['sport_id'])->exists()) {
                throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_tournament_stage'));
            }
            $templateId = EnetTournamentStage::where('id', $data['unfavorite'])->value('tournament_template_id');
            $templateIds = array_diff($templateIds, [$templateId]);
            $response =  ['is_favorite' => false];
        }
        $templateIds = array_filter($templateIds);
        \DB::beginTransaction();
        $userId = $this->getAuthUserId();
        foreach ($templateIds as $id) {
            UserFavoriteEnetTournamentTemplate::create([
                'user_id' => $userId,
                'tournament_template_id' => $id,
                'created_at' => now()
            ]);
        }

        $config['own'][] = $data['sport_id'];
        $config['general'] = array_diff($config['general'], [$data['sport_id']]);
        $authUser->update(['edited_sport_templates' => json_encode($config)]);
        \DB::commit();
        return $response;
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|int|mixed|object|null
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function massFavoriteUnFavorite($data)
    {
        $this->validate($data, [
            'new' => [
                'array',
                'required_without:removed',
                function ($attribute, $value, $fails) {
                    if (! is_numeric_list($value)) {
                        return $fails('Not valid league list');
                    }
                    if (count($value) != EnetTournamentStage::whereIn('id', $value)->count()) {
                        return $fails('Not valid league exist');
                    }
                }
            ],
            'removed' => [
                'array',
                'required_without:new',
                function ($attribute, $value, $fails) {
                    if (! is_numeric_list($value)) {
                        return $fails('Not valid league list');
                    }
                }
            ],
        ]);

        if (! empty($data['new'])) {
            $tournamentTemplateIds = EnetTournamentStage::whereIn('id', $data['new'])->pluck('tournament_template_id');

            $existing = UserFavoriteEnetTournamentTemplate::where('user_id', $this->getAuthUserId())
                ->whereIn('tournament_template_id', $tournamentTemplateIds)
                ->pluck('tournament_template_id');
            $tournamentTemplateIds = $tournamentTemplateIds->filter();

            foreach ($tournamentTemplateIds as $tournamentTemplateId) {
                if ($existing->contains($tournamentTemplateId)) {
                    continue;
                }
                UserFavoriteEnetTournamentTemplate::create([
                    'user_id' => $this->getAuthUserId(),
                    'tournament_template_id' => $tournamentTemplateId,
                    'created_at' => now()
                ]);
            }
        }

        if (! empty($data['removed'])) {
            $tournamentTemplateIds = EnetTournamentStage::whereIn('id', $data['removed'])->pluck('tournament_template_id');
            UserFavoriteEnetTournamentTemplate::where('user_id', $this->getAuthUserId())
                ->whereIn('tournament_template_id', $tournamentTemplateIds)->delete();
        }

        return $this->userLeagues($data);
    }

    /**
     * @param $sportId
     * @param array $conditions
     * @param null $date
     * @return Collection
     */
    public function getLeagues($sportId, $conditions = [], $date = null)
    {
        // @TODO fix by auth user or global
        $options = [
            'where_has' => [
                'events' => [
                    'where' => [
                        'sport_id' => $sportId,
                        ['status_description_id', '!=', \ConstStatusDescription::Postponed],
                    ],
                    'where_in' => [
                        'status_type' => [
                            \ConstEnetStatusType::NotStarted,
                            \ConstEnetStatusType::Inprogress,
                            \ConstEnetStatusType::Finished,
                            \ConstEnetStatusType::Interrupted,
                            \ConstEnetStatusType::Deleted,
                        ]
                    ],
                    'where_date' => [
                        'start_date' => Carbon::parse($date)->format('Y-m-d'),
                    ]
                ]
            ],
            'with_count' => [
                'events' => function ($q) use ($date, $sportId) {
                    $q->whereDate('start_date', Carbon::parse($date)->format('Y-m-d'))
                        ->where([
                            'sport_id' => $sportId,
                            ['status_description_id', '!=', \ConstStatusDescription::Postponed],
                        ])->whereIn('status_type', [
                            \ConstEnetStatusType::NotStarted,
                            \ConstEnetStatusType::Inprogress,
                            \ConstEnetStatusType::Finished,
                            \ConstEnetStatusType::Interrupted,
                            \ConstEnetStatusType::Deleted,
                        ]);
                },
                'events as live_events_count' => function ($q) use ($date, $sportId) {
                    $q->whereDate('start_date', Carbon::parse($date)->format('Y-m-d'))
                        ->where([
                            'sport_id' => $sportId,
                        ])->where('status_type', \ConstEnetStatusType::Inprogress);
                }
            ],
            'columns' => [
                'league_name',
                'name',
                'id',
                'country_id',
                'country_name',
                'readable_id',
                'image_path',
                'image_disk',
            ],
            'all' => true,
        ];

        if ($conditions) {
            $options['where'] = $conditions;
        }
        /**
         * @var $items Collection
         */
        $items = $this->model->getByArray($options);
        return $items;
    }

    public function getLeaguesForWeb($sportId, Carbon $date, $conditions = [])
    {
        // @TODO fix by auth user or global
        $options = [
            'where_has' => [
                'events' => [
                    'where' => [
                        'sport_id' => $sportId,
                        ['status_description_id', '!=', \ConstStatusDescription::Postponed],
                    ],
                    'where_in' => [
                        'status_type' => [
                            \ConstEnetStatusType::NotStarted,
                            \ConstEnetStatusType::Inprogress,
                            \ConstEnetStatusType::Finished,
                            \ConstEnetStatusType::Interrupted,
                            \ConstEnetStatusType::Deleted,
                        ]
                    ],
                    'where_date' => [
                        'start_date' => $date->format('Y-m-d'),
                    ]
                ]
            ],
            'select_raw' => 'exists(select * from `enet_draws` where `enet_draws`.`object_id` = `enet_tournament_stages`.`id` and `enet_draws`.`object_id` is not null and `object_type_id` = 4) as is_draw',
            'columns' => [
                'league_name',
                'id',
                'country_id',
                'readable_id',
            ],
            'all' => true,
        ];

        if ($conditions) {
            $options['where'] = $conditions;
        }
        /**
         * @var $items Collection
         */
        $items = $this->model->getByArray($options);
        return $items;
    }

    public function tableStandings($tournamentStageId)
    {
        $standingTypes = [
            \ConstEnetStandingTypeParam::POINTS,
            \ConstEnetStandingTypeParam::GOALS_FOR,
            \ConstEnetStandingTypeParam::GOALS_AGAINST,
            \ConstEnetStandingTypeParam::GAMES_PLAYED,
        ];
        if (request('web')) {
            $standingTypes[] = \ConstEnetStandingTypeParam::WON;
            $standingTypes[] = \ConstEnetStandingTypeParam::LOST;
            $standingTypes[] = \ConstEnetStandingTypeParam::DRAW;
        }

        $options = [
            'columns' => [
                'id',
            ],
            'with' => [
                'standings' => [
                    'columns' => [
                        'id', 'object_id',
                    ],
                    'with' => [
                        'standing_configs' => [
                            'where_in' => [
                                'standing_type_param_id' => \ConstEnetTableStandingTypeParam::constants()
                            ],
                        ],
                        'standing_participants' => [
                            'order_by' => [
                                'rank' => 'asc'
                            ],
                            'columns' => [
                                'id', 'participant_id', 'rank', 'standing_id'
                            ],
                            'with' => [
                                'standing_data' => [
                                    'columns' => [
                                        'id', 'standing_participants_id', 'standing_type_param_id', 'value',
                                    ],
                                    'where_in' => [
                                        'standing_type_param_id' => $standingTypes
                                    ],
                                ],
                                'participant' => [
                                    'select' => ['id', 'name', 'image_disk', 'image_path', 'country_id', 'type'],
                                ]
                            ]
                        ]
                    ],
                    'where' => [
                        'standing_type_id' => \ConstEnetStandingType::LIVE_LEAGUE_TABLE
                    ]
                ],
            ]
        ];
        return $this->model->findByArray($tournamentStageId, $options);
    }

    public function draw($id)
    {
        $this->model = \App::make(EnetDraw::class);
        $options = [
            'select' => ['id', 'name', 'draw_type_id'],
            'where' => [
                'draw_type_id' => 10,
                'object_type_id' => 4,
                'object_id' => $id
            ],
            'with' => [
                'draw_configs:id,name,draw_id,value',
                'draw_details',
                'draw_events' => [
                    'select' => [
                        'id',
                        'draw_id',
                        'round_type_id',
                        'draw_event_id',
                        'draw_order',
                    ],
                    'with' => [
                        'round_type:id,name,value',
                        'draw_participants' => [
                            'select' => [
                                'participant_id',
                                'number',
                                'draw_event_id',
                            ],
                            'with' => [
                                'participant' => [
                                    'select' => [
                                        'id',
                                        'name',
                                        'name_da',
                                        'name_en',
                                        'image_disk',
                                        'image_path',
                                        'type',
                                        'gender',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'first' => true
        ];
        return $this->model->getByArray($options);
    }
}
