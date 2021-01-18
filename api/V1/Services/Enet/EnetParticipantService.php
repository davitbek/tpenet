<?php

namespace Api\V1\Services\Enet;

use Api\V1\Models\Enet\EnetObjectParticipant;
use Api\V1\Models\Enet\EnetParticipant;
use Api\V1\Models\Enet\EnetParticipantSuggestion;
use Api\V1\Models\UserFavoriteEnetParticipant;
use LaraAreaApi\Exceptions\ApiException;

class EnetParticipantService extends BaseService
{
    protected $modelClass = EnetParticipant::class;

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function userTeams($data = [])
    {
        $options = [
            'where_has' => [
                'user_favorite_participants' => [
                    'where' => [
                        'user_id' => $this->getAuthUserId()
                    ]
                ]
            ],
        ];
        unset($options['where']['type']);
        $options = $this->getQueryOptions($data, $options, \ConstParticipantType::Team);
        return $this->model->getByArray($options);
    }


    /**
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|int|mixed|object|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function feedTeams($data = [])
    {
        $userId = $this->getAuthUserId();
        if ($userId) {
            return $this->userTeams($data);
        }
        $countryId = get_country_by_ip()->id ?? null;
        $teamIds = $this->getRandomTeamsByCountry($countryId);
        $options = $this->getQueryOptions($data, ['where_in' => ['id' => $teamIds]], \ConstParticipantType::Team);
        return $this->model->getByArray($options);

    }

    /**
     * @param $countryId
     * @param int $count
     * @return \Illuminate\Support\Collection
     */
    protected function getRandomTeamsByCountry($countryId, $count = 15)
    {
        return EnetParticipantSuggestion::inRandomOrder()->where('country_id', $countryId)->limit($count)->pluck('participant_id');
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function teams($data)
    {
        $options = $this->getQueryOptions($data, [], \ConstParticipantType::Team);
        $items = $this->model->getByArray($options);
        if (! empty($data['search'])) {
            $items = $items->orderBySearch('name_translated', $data['search']);
        }
        return $items;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function athletes($data)
    {
        $options = $this->getQueryOptions($data, [], \ConstParticipantType::Athlete);
        $items = $this->model->getByArray($options);
        if (! empty($data['search'])) {
            $items = $items->orderBySearch('name_translated', $data['search']);
        }
        return $items;
    }

    /**
     * @param $data
     * @param $options
     * @param $type
     * @return mixed
     */
    protected function getQueryOptions($data, $options, $type)
    {
        if ($type == \ConstParticipantType::Team) {
            $options['where_nested'][] = function ($q) {
                $q->where('type', \ConstParticipantType::Team)
                    ->orWhere(function ($q) {
                        $q->where('type', \ConstParticipantType::Athlete)->where('sport_id', \ConsEnetSport::TENNIS);
                    });
            };
        } else {
            $options['where']['type'] = $type;
        }

        $options['columns'] = [
            'id',
            'country_id',
            'sport_id',
            'gender',
            'name',
            'name_da',
            'name_en',
            'name_short_en',
            'name_short_da',
            'type',
            'image_disk',
            'image_path',
        ];
        $options['limit'] = $data['limit'] ?? config('api_config.limit');

        if (! empty($data['search'])) {
            $options['where_nested'][] = function ($q) use ($data) {
                $q->where('name', 'like' , '%' . $data['search'] . '%')
                    ->orWhere('name_da', 'like' , '%' . $data['search'] . '%')
                    ->orWhere('name_en', 'like' , '%' . $data['search'] . '%')
                    ->orWhere('name_short_da', 'like' , '%' . $data['search'] . '%')
                    ->orWhere('name_short_en', 'like' , '%' . $data['search'] . '%');
            };
        }

        if (! empty($data['suggest'])) {
            $options['where'][] = ['is_suggest', '=' , \ConstYesNo::YES];
        }

        if (! empty($data['suggest_country_id'])) {
            if (empty($data['suggest'])) {
                $options['where'][] = ['is_suggest', '=' , \ConstYesNo::YES];
            }
            $options['where_has']['participant_suggestions'] = [
                'where' => [
                    'country_id' => $data['suggest_country_id'],
                ]
            ];
        }

        if (! empty($data['country_id'])) {
            $options['where'][] = ['country_id', '=' , $data['country_id']];
        }

        if (! empty($data['sport_id'])) {
            if (\ConsEnetSport::TENNIS == $data['sport_id']) {
                unset($options['where']['type']);
            }
            $options['where']['sport_id'] = $data['sport_id'];
        }

        return $options;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function team($id)
    {
        $options = [
            'where' => [
                'type' => \ConstParticipantType::Team
            ],
            'columns' => [
                'id',
                'country_id',
                'type',
                'gender',
                'name',
                'name_da',
                'name_en',
                'image_disk',
                'image_path',
            ],
            'with' => [
                'country' => [
                    'columns' => [
                        'id',
                        'image_path',
                        'image_disk',
                        'name',
                    ]
                ],
                'properties' => [
                    'columns' => [
                        'object_id',
                        'name',
                        'value',
                    ],
                    'where' => [
                        'name' => 'HomePage',
                    ]
                ],
                'coach' => [
                    'columns' => [
                        'id',
                        'object_id',
                        'participant_id',
                    ],
                    'with' => [
                        'participant' => [
                            'columns' => [
                                'id',
                                'name',
                                'name_da',
                                'name_en',
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $authId = $this->getAuthUserId();
        if ($authId) {
            $options['select_raw'] = 'exists(select id from `user_favorite_participant` where `user_id` = ' . $authId . ' and `participant_id` = enet_participants.id) as is_favorite';
        } else {
            $options['select_raw'] = '0 as is_favorite';
        }

        $item =  $this->model->findByArray($id, $options);
        return $item;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function athlete($id)
    {
        $options = [
            'where' => [
                'type' => \ConstParticipantType::Athlete
            ],
            'columns' => [
                'id',
                'country_id',
                'gender',
                'name',
                'name_da',
                'name_en',
                'image_disk',
                'image_path',
            ],
            'with' => [
                'country' => [
                    'columns' => [
                        'id',
                        'image_path',
                        'image_disk',
                        'name',
                    ]
                ],
                'properties' => [
                    'columns' => [
                        'object_id',
                        'name',
                        'value',
                    ],
                    'where' => [
                        ['name', '!=', 'atp_id'],
                    ]
                ],
                'coach' => [
                    'columns' => [
                        'id',
                        'object_id',
                        'participant_id',
                    ],
                    'with' => [
                        'participant' => [
                            'columns' => [
                                'id',
                                'name',
                                'name_da',
                                'name_en',
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $authId = $this->getAuthUserId();
        if ($authId) {
            $options['select_raw'] = 'exists(select id from `user_favorite_participant` where `user_id` = ' . $authId . ' and `participant_id` = enet_participants.id) as is_favorite';
        } else {
            $options['select_raw'] = '0 as is_favorite';
        }

        $item =  $this->model->findByArray($id, $options);
        return $item;
    }

    /**
     * @param $teamId
     * @return array
     * @throws \Exception
     */
    public function favoriteUnFavorite($teamId)
    {
        $userId = $this->getAuthUserId();
        $team = EnetParticipant::find($teamId, ['id', 'type']);
        if(! $team) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_team'));
        }

        $favorite = UserFavoriteEnetParticipant::where([
            'user_id' => $userId,
            'participant_id' => $teamId,
        ])->first();


        if ($favorite) {
            $favorite->delete();
            return ['is_favorite' => false];
        }
        UserFavoriteEnetParticipant::create([
            'user_id' => $userId,
            'participant_id' => $teamId,
            'participant_type' => $team->type,
        ]);

        return ['is_favorite' => true];
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
                        return $fails('Not valid team list');
                    }
                    if (count($value) != EnetParticipant::whereIn('id', $value)->count()) {
                        return $fails('Not valid team exist');
                    }
                }
            ],
            'removed' => [
                'array',
                'required_without:new',
                function ($attribute, $value, $fails) {
                    if (! is_numeric_list($value)) {
                        return $fails('Not valid team list');
                    }
                }
            ],
        ]);

        if (! empty($data['new'])) {
            $existing = UserFavoriteEnetParticipant::where('user_id', $this->getAuthUserId())
                ->whereIn('participant_id', $data['new'])
                ->pluck('participant_id');
            foreach ($data['new'] as $participantId) {
                if ($existing->contains($participantId)) {
                    continue;
                }

                $new = UserFavoriteEnetParticipant::create([
                    'user_id' => $this->getAuthUserId(),
                    'participant_id' => $participantId
                ]);
            }
        }

        if (! empty($data['removed'])) {
            $favoriteParticipants = UserFavoriteEnetParticipant::where('user_id', $this->getAuthUserId())
                ->whereIn('participant_id', $data['removed'])->get();
            foreach ($favoriteParticipants as $favoriteParticipant) {
                $favoriteParticipant->delete();
            }
        }

        return $this->userTeams($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function teamParticipants($id)
    {
        $this->model = new EnetObjectParticipant();
        $options = [
            'columns' => [
                'id',
                'is_active',
                'object_id',
                'participant_id',
                'participant_type',
                'date_from',
                'date_to',
            ],
            'where' => [
                'is_active' => 1,
                'object' => \ConstEnetObjectType::PARTICIPANT,
                'object_id' => $id
            ],
            'with' => [
                'participant' => [
                    'columns' => [
                        'id',
                        'country_id',
                        'gender',
                        'name',
                        'name_da',
                        'name_en',
                    ],
                    'with' => [
                        'properties' => [
                            'columns' => [
                                'object_id',
                                'name',
                                'value',
                            ],
                            'where' => [
                                ['name', '!=', 'status']
                            ]
                        ],
                        'country' => [
                            'columns' => [
                                'id',
                                'image_path',
                                'image_disk'
                            ]
                        ]
                    ],
                ]
            ]
        ];
        $items =  $this->model->getByArray($options);
        return $items;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function athleteTeams($id)
    {
        $this->model = new EnetObjectParticipant();
        $options = [
            'columns' => [
                'id',
                'is_active',
                'object_id',
                'participant_id',
                'participant_type',
                'date_from',
                'date_to',
            ],
            'where' => [
                'is_active' => 1,
                'object' => \ConstEnetObjectType::PARTICIPANT,
                'participant_id' => $id,
                'participant_type' => \ConstParticipantType::Athlete,
            ],
            'with' => [
                'team' => [
                    'columns' => [
                        'id',
                        'country_id',
                        'gender',
                        'name',
                        'name_da',
                        'name_en',
                    ],
                    'with' => [
                        'properties' => [
                            'columns' => [
                                'object_id',
                                'name',
                                'value',
                            ],
                            'where' => [
                                ['name', '!=', 'status']
                            ]
                        ],
                        'country' => [
                            'columns' => [
                                'id',
                                'image_path',
                                'image_disk'
                            ]
                        ]
                    ],
                ]
            ]
        ];
        $items =  $this->model->getByArray($options);
        return $items;
    }
}