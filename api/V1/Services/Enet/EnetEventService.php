<?php

namespace Api\V1\Services\Enet;

use Api\V1\Models\Archived\ArchivedBettingOffer;
use Api\V1\Models\Enet\EnetEvent;
use Api\V1\Models\Enet\EnetIncident;
use Api\V1\Models\Enet\EnetLineup;
use Api\V1\Models\Enet\EnetOutcome;
use Api\V1\Models\Enet\EnetParticipant;
use Api\V1\Models\Enet\EnetParticipantSuggestion;
use Api\V1\Models\Enet\EnetResult;
use Api\V1\Models\OutcomeVote;
use Api\V1\Models\UserEventOutcomeVote;
use Api\V1\Models\UserFavoriteEnetEvent;
use Api\V1\Models\UserFavoriteEnetParticipant;
use App\Helpers\CachedItems;
use App\Models\Admin\Enet\Event;
use LaraAreaApi\Exceptions\ApiException;

class EnetEventService extends BaseService
{
    /**
     * @var string
     */
    protected $modelClass = EnetEvent::class;

    /**
     * @var array
     */
    protected $outcomeTypes = [];

    /**
     * EnetEventService constructor.
     * @param null $model
     * @param null $validator
     */
    public function __construct($model = null, $validator = null)
    {
        parent::__construct($model, $validator);
        $this->outcomeTypes = CachedItems::activeOutcomeTypeIds();
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function feedEvents()
    {
        $countryId = get_country_by_ip()->id ?? null;
        $userId = $this->getAuthUserId();

        if ($userId) {
            $eventIds = UserFavoriteEnetEvent::where('user_id', $userId)->pluck('event_id');
            $teamIds = UserFavoriteEnetParticipant::where('user_id', $userId)->pluck('participant_id');

            // if no any favorite teams show as guest favorite teams
            if ($teamIds->isEmpty()) {
                $teamIds = $this->getRandomTeamsByCountry($countryId);
            }
        } else {
            $teamIds = $this->getRandomTeamsByCountry($countryId);
            $eventIds = [];
        }

        return [
            $this->getFeedPrevEvents($userId, $eventIds, $teamIds, $countryId),
            $this->getFeedNextEvents($userId, $eventIds, $teamIds, $countryId)
        ];
    }

    /**
     * @param $userId
     * @param $eventIds
     * @param $teamIds
     * @param $countryId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed[]
     */
    protected function getFeedPrevEvents($userId, $eventIds, $teamIds, $countryId)
    {
        $prev = EnetEvent::where('start_date', '<', now())
            ->latest('start_date')
//            ->where('status_type', \ConstEnetStatusType::Finished)
            ->where('status_description_id', '!=', \ConstStatusDescription::Cancelled)
            ->when(
                $userId,
                function ($q) use ($eventIds) {
                    $q->whereIn('id', $eventIds);
                },
                function ($q) use ($teamIds) {
                    $q->where(function ($q) use ($teamIds) {
                        $q->whereIn('first_participant_id', $teamIds)
                            ->orWhereIn('second_participant_id', $teamIds);
                    });
                }
            )
            ->with([
                'event_participants' => function ($q) {
                    $q->select('id', 'number', 'participant_id', 'event_id')
                        ->with([
                            'running_score_result',
                            'participant:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender'
                        ]);
                }
            ])
            ->limit(5)
            ->get();

        if ($userId && $prev->isEmpty() && !UserFavoriteEnetParticipant::where('user_id', $userId)->exists()) {
            $teamIds = $this->getRandomTeamsByCountry($countryId);
            $prev = EnetEvent::where('start_date', '<', now())
                ->latest('start_date')
//                ->where('status_type', \ConstEnetStatusType::Finished)
                ->where(function ($q) use ($teamIds) {
                    $q->whereIn('first_participant_id', $teamIds)
                        ->orWhereIn('second_participant_id', $teamIds);
                })
                ->with([
                    'event_participants' => function ($q) {
                        $q->select('id', 'number', 'participant_id', 'event_id')
                            ->with([
                                'running_score_result',
                                'participant:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender'
                            ]);
                    }
                ])
                ->limit(5)
                ->get();
        }

        return $prev->sortBy('start_date');
    }


    /**
     * @param $userId
     * @param $eventIds
     * @param $teamIds
     * @param $countryId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed[]
     */
    protected function getFeedNextEvents($userId, $eventIds, $teamIds, $countryId)
    {
        $next = EnetEvent::where('start_date', '>', now())
            ->orderBy('start_date')
            ->whereDate('start_date', '<=', now()->addDays(10))
            ->where('status_description_id', '!=', \ConstStatusDescription::Cancelled)
            ->where(function ($q) use ($eventIds, $teamIds) {
                $q->whereIn('id', $eventIds)
                    ->orWhereIn('first_participant_id', $teamIds)
                    ->orWhereIn('second_participant_id', $teamIds);
            })
            ->with([
                'event_participants' => function ($q) {
                    $q->select('id', 'number', 'participant_id', 'event_id')
                        ->with([
                            'running_score_result',
                            'participant:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender'
                        ]);
                }
            ])
            ->limit(10)
            ->get();

        return $next->sortBy('start_date');
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
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function singeEvent($eventId)
    {
        $options = [
            'columns' => [
                'id',
                'status_type',
                'country_id',
                'sport_id',
                'sport_name',
                'elapsed_time',
                'status_description_id',
                'tournament_stage_id',
                'tournament_stage_name',
                'start_date',
                'first_participant_id',
                'second_participant_id',
                'start_date',
                'name',
            ],
            'with' => [
                'properties' => [
                    'select' => ['name', 'object_id', 'value'],
                    'where_in' => [
                        'name' => [
                            'Round',
                            'VenueNeutral',
                            'VenueName',
                            'refereeFK',
                            'assistant1_refereeFK',
                            'assistant2_refereeFK',
                            'LineupConfirmed',
                            'Spectators',
                            'Spectators_Comment',
                            'BestOf',
                            'BestOfNum',
                        ]
                    ]
                ],
                'event_participants' => [
                    'columns' => [
                        'event_id',
                        'participant_id',
                        'number'
                    ],
                    'with' => [
                        'participant' => [
                            'columns' => [
                                'id',
                                'name',
                                'name_da',
                                'name_en',
                                'name_short_da',
                                'name_short_en',
                                'image_disk',
                                'image_path',
                                'country_id',
                                'gender',
                                'type',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        $options['select_raw'] = $this->checkIsFavorite();
        $item = $this->model->findByArray($eventId, $options);
        if (empty($item)) {
            return $item;
        }
        $participantProperties = ['refereeFK', 'assistant1_refereeFK', 'assistant2_refereeFK'];

        $properties = $item->properties->whereIn('name', $participantProperties)->pluck('value');
        if ($properties->isNotEmpty()) {
            $participants = EnetParticipant::whereIn('id', $properties)->pluck('name', 'id');
            foreach ($item->properties as $property) {
                if (in_array($property->name, $participantProperties)) {
                    $property->value = $participants[$property->value] ?? 'Unknown';
                }
            }
        }

        return $item;
    }

    /**
     * @param $eventId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|int|mixed|object|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventOutcomeTypes($eventId)
    {
        $this->model = new EnetOutcome();
        $options = [
            'where' => [
                'object' => \ConstEnetObjectType::EVENT,
                'object_id' => $eventId,
            ],
            'where_in' => [
                'outcome_type_id' => $this->outcomeTypes
            ],
            'where_has' => [
                'betting_offers' => $this->getBettingOfferFilters()
            ],
            'select' => [
                'object_id',
                'object',
                'outcome_type_id',
                'outcome_scope_id',
            ],
            'group_by' => [
                'outcome_type_id',
            ],
        ];
        return $this->model->getByArray($options);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|int|mixed|object|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventOutcomeVotes($eventId)
    {
        $options = [
            'columns' => [
                'name',
                'status_type',
                'sport_id',
                'first_participant_id',
                'second_participant_id',
            ],
            'with' => [
                'home_team:id,name',
                'away_team:id,name'
            ],
        ];
        $event = $this->model->findByArray($eventId, $options);


        if (empty($event)) {
            return $event;
        }

        $lang = get_auth_locale();

        $data['with']['translations'] = [
            'where' => ['lang' => $lang]
        ];
        $data['where']['parent_id'] = null;
        $data['where']['is_active'] = \ConstYesNo::YES;
        $data['with'][] = 'odds_providers:id';
        $data['with'][] = 'sports:id';
        $data['all'] = true;
        $data['order_by']['order'] = 'asc';
        $this->model = new OutcomeVote();
        $outcomeVotes = $this->model->getByArray($data);
        $outcomes = collect();
        $activeOddsProviderIds = get_auth_access_odds_provider_ids();
        $sportOutcomeVotes = collect();

        foreach ($outcomeVotes as $outcomeVote) {
            $sportIds = $outcomeVote->sports->pluck('id');
            if ($sportIds->isNotEmpty() && ! $sportIds->contains($event->sport_id)) {
                continue;
            }
            $sportOutcomeVotes->push($outcomeVote);
            $authId = $this->getAuthUserId();
            $condition = \ConstEnetStatusType::NotStarted != $event->status_type
                || ($authId && UserEventOutcomeVote::where([
                        'user_id' => $this->getAuthUserId(),
                        'event_id' => $eventId,
                        'outcome_vote_id' => $outcomeVote->id,
                    ])->exists());

            if ($condition) {
                $voteOptions = mobile_outcome_type($outcomeVote->outcome_type_id . '.vote_betting_labels');
                $statistics = $this->getVoteStatistics($eventId, $outcomeVote->id, $voteOptions);
                $outcomeVote->setAttribute('statistics', $statistics);
            }

            $conditions = array_filter($outcomeVote->only([
                'outcome_type_id',
                'iparam',
                "iparam2",
                'dparam',
                'dparam2',
                'sparam'
            ]));
            $conditions['outcome_scope_id'] = \ConstEnetOutcomeScope::OrdinaryTime;
            $conditions['object_id'] = $eventId;
            $conditions['object'] = \ConstEnetObjectType::EVENT;
            $oddsProviderIds = $outcomeVote->odds_providers->pluck('id')->all();
            $oddsProviderIds = array_intersect($activeOddsProviderIds, $oddsProviderIds);

            $_outcomes = EnetOutcome::query()
                ->where($conditions)
                ->select(['id',
                    'object',
                    'object_id',
                    'outcome_type_id',
                    'outcome_scope_id',
                    'outcome_subtype_id',
                    'event_participant_number',
                    'iparam',
                    'iparam2',
                    'dparam',
                    'dparam2',
                    'sparam',
                ])->whereHas('betting_offers', function ($q) use ($oddsProviderIds) {
                    $q->where('betting_offer_status_id', \ConstBettingOfferStatus::Active)
                        ->whereIn('odds_provider_id', $oddsProviderIds);
                })
                ->with([
                    'betting_offers' => function ($q) use ($oddsProviderIds) {
                        $q->select('id', 'outcome_id', 'odds', 'odds_provider_id')
                            ->where('betting_offer_status_id', \ConstBettingOfferStatus::Active)
                            ->whereIn('odds_provider_id', $oddsProviderIds)
                            ->groupBy('outcome_id', 'odds_provider_id');
                    }
                ])
                ->get();
            $outcomes = $outcomes->merge($_outcomes);
        }

        $event->setRelation('outcome_votes', $sportOutcomeVotes);
        $event->setRelation('outcomes', $outcomes);

        return $event;
    }

    /**
     * @param $eventId
     * @param $outcomeVoteId
     * @param $option
     * @return mixed
     * @throws ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function storeEventOutcomeVote($eventId, $outcomeVoteId, $option)
    {
        $event = Event::find($eventId, ['id']);
        if (empty($event)) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_event'));
        }

        $outcomeVote = OutcomeVote::find($outcomeVoteId, ['id', 'outcome_type_id']);
        if (empty($outcomeVote)) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_outcome_vote'));
        }

        $voteOptions = mobile_outcome_type($outcomeVote->outcome_type_id . '.vote_betting_labels');
        if (!is_array($voteOptions) || in_array($option, $voteOptions)) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_outcome_vote_option'));
        }

        if (UserEventOutcomeVote::where('user_id', $this->getAuthUserId())->where('event_id', $eventId)->exists()) {
//            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('user_already_voted'));
        }

        UserEventOutcomeVote::create([
            'user_id' => $this->getAuthUserId(),
            'event_id' => $eventId,
            'outcome_vote_id' => $outcomeVoteId,
            'vote_option' => $option,
        ]);

        return $this->getVoteStatistics($eventId, $outcomeVoteId, $voteOptions);
    }

    protected function getVoteStatistics($eventId, $outcomeVoteId, $voteOptions)
    {
        $statistics = UserEventOutcomeVote::where(['event_id' => $eventId, 'outcome_vote_id' => $outcomeVoteId,])->groupBy('vote_option')
            ->selectRaw("count('*') as count, vote_option")->get();

        $response = [];
        foreach ($voteOptions as $voteOption => $_) {
            $statistic = $statistics->where('vote_option', $voteOption)->first();
            if ($statistic) {
                $response[] = $statistic->toArray();
            } else {
                $response[] = [
                    'count' => 0,
                    'vote_option' => $voteOption
                ];
            }
        }

        return collect($response)->pluck('count', 'vote_option');
    }

    /**
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventBookmakers($eventId)
    {
        $options = [
            'with' => [
                'outcomes' => [
                    'where_in' => [
                        'outcome_type_id' => $this->outcomeTypes
                    ],
                    'where_has' => [
                        'betting_offers' => $this->getBettingOfferFilters()
                    ],
                    'select' => [
                        'id',
                        'object',
                        'object_id',
                        'outcome_type_id',
                        'outcome_scope_id',
                        'outcome_subtype_id',
                        'event_participant_number',
                        'iparam',
                        'iparam2',
                        'dparam',
                        'dparam2',
                        'sparam',
                    ],
                    'with' => [
                        'betting_offers' => $this->getBettingOfferFilters([
                            'select' => 'id,outcome_id,odds,odds_old,is_active,odds_provider_id'
                        ])
                    ]
                ],
            ],
            'columns' => [
                'name',
            ],
        ];

        return $this->model->findByArray($eventId, $options);
    }

    /**
     * TODO delete
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventOdds($eventId)
    {
        $options = [
            'with' => [
                'outcomes' => [
                    'select' => [
                        'id',
                        'object',
                        'object_id',
                        'outcome_type_id',
                        'outcome_scope_id',
                        'outcome_subtype_id',
                        'event_participant_number',
                        'iparam',
                        'iparam2',
                        'dparam',
                        'dparam2',
                        'sparam',
                    ],
                    'where_in' => [
                        'outcome_type_id' => $this->outcomeTypes
                    ],
                    'with' => [
                        'betting_offers' => $this->getBettingOfferFilters([
                            'select' => 'id,outcome_id,odds,odds_old,is_active,odds_provider_id',
                        ]),
                    ],
                    'where_has' => [
                        'betting_offers' => $this->getBettingOfferFilters()
                    ]
                ],
            ],
            'columns' => [
                'name',
                'first_participant_id',
                'second_participant_id',
            ],
        ];

        return $this->model->findByArray($eventId, $options);
    }

    /**
     * @param $eventId
     * @param $outcomeTypeId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventOddsByOutcomeType($eventId, $outcomeTypeId)
    {
        return $this->eventBookmakersByOutcomeType($eventId, $outcomeTypeId);
    }

    /**
     * @param $eventId
     * @param $outcomeTypeId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventBookmakersByOutcomeType($eventId, $outcomeTypeId)
    {
        $options = [
            'where_has' => [
                'outcomes' => [
                    'where' => [
                        'outcome_type_id' => $outcomeTypeId,
                    ],
                    'where_has' => [
                        'betting_offers' => $this->getBettingOfferFilters()
                    ]
                ]
            ],
            'with' => [
                'outcomes' => [
                    'where' => [
                        'outcome_type_id' => $outcomeTypeId,
                    ],
                    'where_has' => [
                        'betting_offers' => $this->getBettingOfferFilters()
                    ],
                    'select' => [
                        'id',
                        'object',
                        'object_id',
                        'outcome_type_id',
                        'outcome_scope_id',
                        'outcome_subtype_id',
                        'event_participant_number',
                        'iparam',
                        'iparam2',
                        'dparam',
                        'dparam2',
                        'sparam',
                    ],
                    'with' => [
                        'betting_offers' => $this->getBettingOfferFilters([
                            'select' => 'id,outcome_id,odds,odds_old,is_active,odds_provider_id'
                        ])
                    ],
                ],
            ],
            'columns' => [
                'name',
                'first_participant_id',
                'second_participant_id',
            ],
        ];

        return $this->model->findByArray($eventId, $options);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getBettingOfferFilters($data = [])
    {
        $activeOddsProviderIds = get_auth_access_odds_provider_ids();
        return array_merge([
            'where' => [
                'betting_offer_status_id' => \ConstBettingOfferStatus::Active
            ],
            'where_in' => [
                'odds_provider_id' => $activeOddsProviderIds
            ]
        ], $data);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function eventOverViewsExtended($eventId)
    {
        $options = [
            'columns' => [
                'id',
                'event_first_participants_id',
                'event_second_participants_id',
                'sport_id',
                'status_type',
            ],
            'with' => [
                'home_team_results' => [
                    'select' => ['event_participants_id', 'result_type_id', 'result_code', 'value']
                ],
                'away_team_results' => [
                    'select' => ['event_participants_id', 'result_type_id', 'result_code', 'value']
                ],
            ]
        ];
        $event = $this->model->findByArray($eventId, $options);

        if (empty($event) || empty($event->event_first_participants_id) || empty($event->event_second_participants_id)) {
            return [
                'event' => null,
                'incidents' => null,
            ];
        }
        $this->model = new EnetIncident();
        $options = [
            'with' => [
                'participant:id,name,gender'
            ],
            'where' => [
                ['ref_participant_id', '!=', 0], // TODO correct
                ['incident_type_id', '!=', \ConstIncidentsType::Assist2nd], // TODO correct
            ],
            'where_in' => [
                'event_participants_id' => $event->only(['event_first_participants_id', 'event_second_participants_id'])
            ],
        ];
        $incidents = $this->model->getByArray($options);
        return [
            'event' => $event,
            'incidents' => $incidents,
        ];
    }


    public function eventParticipantStandings($eventId)
    {
        $options = [
            'columns' => [
                'id',
            ],
            'with' => [
                'standing' => [
                    'columns' => [
                        'id', 'object_id',
                    ],
                    'with' => [
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
                                        'id', 'standing_participants_id', 'standing_type_param_id', 'value', 'code', 'sub_param'
                                    ],
                                ]
                            ]
                        ]
                    ]
                ],
                'event_participants' => [
                    'columns' => [
                        'id',
                        'event_id',
                        'participant_id',
                        'number'
                    ],
                    'with' => [
                        'lineups' => [
                            'columns' => [
                                'event_participants_id',
                                'participant_id',
                                'lineup_type_id',
                                'shirt_number',
                                'pos'
                            ],
                            'with' => [
                                'participant' => [
                                    'select' => [
                                        'id',
                                        'country_id',
                                        'name',
                                        'gender',
                                    ],
                                    'with' => [
                                        'country' => [
                                            'columns' => [
                                                'id', 'image_path', 'image_disk'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $item = $this->model->findByArray($eventId, $options);
        return $item;
    }

    public function eventTeamStandings($eventId)
    {
        if ('extended' == request('tag')) {
            $standingDataWhereIn = [
                'standing_type_param_id' => CachedItems::activeStandingTypeParameters()->pluck('id')
            ];
        } else {
            $standingDataWhereIn = [
                'code' => config('api_config.ordered_team_statistic_codes'),
            ];
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
                                        'id', 'standing_participants_id', 'standing_type_param_id', 'value', 'code', 'sub_param'
                                    ],
                                    'where_in' => $standingDataWhereIn
                                ]
                            ]
                        ]
                    ]
                ],
                'event_participants' => [
                    'columns' => [
                        'id',
                        'event_id',
                        'participant_id',
                        'number'
                    ],
                    'with' => [
                        'lineups' => [
                            'columns' => [
                                'event_participants_id',
                                'participant_id',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        $item = $this->model->findByArray($eventId, $options);
        return $item;
    }

    public function getEventResults($eventId)
    {
        $options = [
            'columns' => [
                'id',
                'event_first_participants_id',
                'event_second_participants_id',
            ],
            'with' => [
                'home_team_results' => [
                    'select' => ['event_participants_id', 'result_type_id', 'result_code', 'value']
                ],
                'away_team_results' => [
                    'select' => ['event_participants_id', 'result_type_id', 'result_code', 'value']
                ],
            ]
        ];
        $item = $this->model->findByArray($eventId, $options);
        return $item;
    }

    /**
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function eventLineups($eventId)
    {
        $event = $this->model->where('id', $eventId)
            ->select(['id', 'event_first_participants_id', 'event_second_participants_id', 'first_participant_id', 'second_participant_id'])
            ->with('home_team:id,image_path,image_disk', 'away_team:id,image_path,image_disk')
            ->with([
                'properties' => function ($q) {
                    $q->where('name', 'LineupConfirmed')->select('object_id', 'name', 'value');
                }
            ])
            ->first();
        if (empty($event) || empty($event->event_first_participants_id) || empty($event->event_second_participants_id)) {
            return [
                'event' => null,
                'lineups' => null,
            ];
        }

        $this->model = new EnetLineup();
        $options = [
            'select' => ['event_participants_id', 'participant_id', 'lineup_type_id', 'shirt_number', 'pos'],
            'order_by' => ['lineup_type_id' => 'asc'],
            'with' => [
                'participant' => [
                    'select' => ['id', 'name', 'name_da', 'name_en', 'country_id', 'updated_at', 'gender',],
                    'with' => 'country:id,image_path,image_disk'
                ],
            ],
            'where_in' => [
                'event_participants_id' => $event->only(['event_first_participants_id', 'event_second_participants_id'])
            ],
            'all' => true
        ];
        $lineups = $this->model->getByArray($options);

        return [
            'event' => $event,
            'lineups' => $lineups,
        ];
    }

    /**
     * @param $eventId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function eventOverViews($eventId)
    {
        $event = $this->model->where('id', $eventId)->first(['event_first_participants_id', 'event_second_participants_id', 'sport_id']); // @TODO need or not, 'first_participant_id', 'second_participant_id'
        if (empty($event) || empty($event->event_first_participants_id) || empty($event->event_second_participants_id)) {
            return [
                'event' => null,
                'incidents' => null,
            ];
        }
        $this->model = new EnetIncident();
        $options = [
            // @TODO think for optimization
            'with' => [
                'participant:id,name,gender'
//                'properties'
                /**
                 * incident_minute
                 * player_name
                 * playerFK
                 * in_playerFK
                 * out_playerFK
                 * incident
                 * offence_typeFK
                 * subtype
                 * reason
                 * revised
                 * incident_second
                 * goalkeeper
                 * Must be check this cases
                 *
                 *
                 */
            ],
            'where' => [
                ['ref_participant_id', '!=', 0], // TODO correct
                ['incident_type_id', '!=', \ConstIncidentsType::Assist2nd], // TODO correct
            ],
            'where_in' => [
                'event_participants_id' => $event->only(['event_first_participants_id', 'event_second_participants_id'])
            ],
        ];
        $incidents = $this->model->getByArray($options);
        return [
            'event' => $event,
            'incidents' => $incidents,
        ];
    }


    /**
     * @param $eventId
     * @return array
     * @throws ApiException
     */
    public function favoriteUnFavorite($eventId)
    {
        $userId = $this->getAuthUserId();
        if (!EnetEvent::where('id', $eventId)->exists()) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_event'));
        }
        $favoriteEvent = UserFavoriteEnetEvent::where([
            'user_id' => $userId,
            'event_id' => $eventId,
        ])->first();

        if ($favoriteEvent) {
            $favoriteEvent->delete();
            return ['is_favorite' => false];
        }
        UserFavoriteEnetEvent::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'date' => now()
        ]);

        return ['is_favorite' => true];
    }

    /**
     * @param $eventId
     * @return array
     * @throws ApiException
     */
    public function enableUnenableFavoriteEvent($eventId)
    {
        $userId = $this->getAuthUserId();
        if (!EnetEvent::where('id', $eventId)->exists()) {
            throw new ApiException(\ConstErrorCodes::NOT_FOUND, mobile_general('invalid_event'));
        }

        $favoriteEvent = UserFavoriteEnetEvent::where([
            'user_id' => $userId,
            'event_id' => $eventId,
        ])->first();

        if (empty($favoriteEvent)) {
            throw new ApiException(401, 'Invalid favorite event');
        }

        $favoriteEvent->update(['is_enabled' => !(bool)$favoriteEvent->is_enabled]);
        return ['is_enable' => $favoriteEvent->is_enabled];
    }

    /**
     * @param $sportId
     * @param $limit
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getPopularEvents($sportId, $limit)
    {
        $options = $this->get3WayOptions([
            'where_has' => [
                'outcomes' => [
                    'where' => [
                        'outcome_type_id' => \ConstEnetOutcomeType::_3Way, // @TODO for sport correct
                        'outcome_scope_id' => \ConstEnetOutcomeScope::OrdinaryTime // @TODO for sport correct
                    ],
                    'where_has' => [
                        'betting_offers' => $this->getBettingOfferFilters(),
                    ],
                ],
            ],
            'where' => [
                ['status_description_id', '!=', \ConstStatusDescription::Postponed],
                'sport_id' => $sportId,
                ['start_date', '>', now()->subHours(1)]
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
            'limit' => $limit,
            'all' => true
        ]);

        $items = $this->model->getByArray($options);
        return $this->addOutcomesRelation($items);
    }

    /**
     * @param $time
     * @return mixed
     */
    public function userFavoriteEvents($time)
    {
        if ($time == 'today') {
            $conditions = [
                ['start_date', '>=', today()],
                ['start_date', '<=', today()->addDays(1)],
            ];
        } elseif ($time == 'next') {
            $conditions = [
                ['start_date', '>=', today()->addDays(1)],
            ];
        } else {
            $conditions = [
                ['start_date', '<=', today()],
            ];
        }
        $options = $this->get3WayOptions([
            'where_has' => [
                'user' => [
                    'where' => [
                        'users.id' => $this->getAuthUserId()
                    ]
                ]
            ],
            'where' => $conditions,
            'all' => true
        ]);
        $items = $this->model->getByArray($options);
        return $this->addOutcomesRelation($items);
    }

    /**
     * @param $time
     * @return mixed
     */
    public function userFavoriteEventsCount($time)
    {
        if ($time == 'today') {
            $conditions = [
                ['start_date', '>=', today()],
                ['start_date', '<=', today()->addDays(1)],
            ];
        } elseif ($time == 'next') {
            $conditions = [
                ['start_date', '>=', today()->addDays(1)],
            ];
        } else {
            $conditions = [
                ['start_date', '<=', today()],
            ];
        }
        $options['where_has'] = [
            'user' => [
                'where' => [
                    'users.id' => $this->getAuthUserId()
                ]
            ]
        ];
        $options['where'] = $conditions;
        $options['count'] = true;
        return $this->model->getByArray($options);
    }

    /**
     * @param $sportId
     * @param $date
     * @return array
     * @throws \Exception
     */
    public function getEventsByDate($sportId, $date)
    {
        $options = $this->get3WayOptions([
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
                'start_date' => $date->format('Y-m-d')
            ],
        ]);
        $options['select_raw'] = $this->checkIsFavorite();

        $items = $this->model->getByArray($options);
        return $this->addOutcomesRelation($items);
    }

    /**
     * @param $sportId
     * @param $date
     * @param null $tournamentStageId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|int|mixed|object|null
     */
    public function getEventsByDateForWeb($sportId, $date, $tournamentStageId = null)
    {
        $options = [
            'with' => [
                'event_participants' => [
                    'select' => [
                        'id',
                        'number',
                        'participant_id',
                        'event_id'
                    ],
                    'with' => [
                        'running_score_result',
                        'participant:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                    ]
                ],
                'tournament_stage:id,name,image_disk,image_path',
                'old_sport' => [
                    'columns' => [
                        'id',
                        'name',
                        'image_path',
                        'image_disk',
                    ]
                ]
            ],
            'columns' => [
                'id',
                'status_type',
                'start_date',
                'sport_id',
                'elapsed_time',
                'status_description_id',
                'tournament_stage_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id',
                'country_id',
            ],
            'per_page' => 20,
            'paginate' => true,
            'select_raw' => $this->checkIsFavorite(),
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
                'start_date' => $date->format('Y-m-d')
            ],
            'order_by' => [
                'start_date' => 'desc'
            ],
        ];
        if ($tournamentStageId) {
            $options['where']['tournament_stage_id'] = $tournamentStageId;
        }

        return $this->model->getByArray($options);
    }

    /**
     * @param $items
     * @return mixed
     */
    private function addOutcomesRelation($items)
    {
        list($notLiveEvents, $liveEvents) = $items->partition(function ($item) {
            return $item->is_offer_archived == \ConstYesNo::YES;
        });

        $liveEvents->load([
            'outcomes' => function ($q) {
                $q->where('outcome_type_id', \ConstEnetOutcomeType::_3Way)
                    ->where('outcome_scope_id', \ConstEnetOutcomeScope::OrdinaryTime)
                    ->select('id', 'object', 'object_id', 'iparam', 'outcome_subtype_id', 'outcome_type_id')
                    ->with([
                        'betting_offers' => function ($q) {
                            $q->where('is_active', \ConstYesNo::YES)->select(
                                'id',
                                'outcome_id',
                                'odds_provider_id',
                                'betting_offer_status_id',
                                'odds',
                                'odds_old',
                                'is_active'
                            )->orderByDesc('odds');
                        }
                    ]);
            }
        ]);

        $bettingOffersIds = $notLiveEvents->pluck('first_win_betting_offer_id');
        $bettingOffersIds = $bettingOffersIds->merge($notLiveEvents->pluck('draw_betting_offer_id'));
        $bettingOffersIds = $bettingOffersIds->merge($notLiveEvents->pluck('second_win_betting_offer_id'));
        $bettingOffers = ArchivedBettingOffer::whereIn('id', $bettingOffersIds)->get();

        foreach ($notLiveEvents as $event) {
            $event->setRelation('first_win_betting_offer', $bettingOffers->where('id', $event->draw_betting_offer_id)->first());
            $event->setRelation('draw_betting_offer', $bettingOffers->where('id', $event->draw_betting_offer_id)->first());
            $event->setRelation('second_win_betting_offer', $bettingOffers->where('id', $event->second_win_betting_offer_id)->first());
        }
        return $items;
    }

    /**
     * @param $leagueId
     * @param $limit
     * @return array
     */
    public function getLeagueEvents($leagueId, $limit)
    {
        $options = $this->get3WayOptions([
            'where' => [
                'tournament_stage_id' => $leagueId,
                ['status_description_id', '!=', \ConstStatusDescription::Postponed],
                ['start_date', '>=', today()],
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
            'limit' => $limit,
            'all' => true
        ]);

        $items = $this->model->getByArray($options);
        return $this->addOutcomesRelation($items);
    }

    /**
     * @param $leagueId
     * @param $limit
     * @return array
     */
    public function getLeagueEventsByDate($leagueId, $date)
    {
        $options = $this->get3WayOptions([
            'where' => [
                'tournament_stage_id' => $leagueId,
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
                'start_date' => $date
            ],
            'all' => true
        ]);

        $items = $this->model->getByArray($options);
        return $this->addOutcomesRelation($items);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function get3WayOptions($options = [])
    {
        $requiredOptions = [
            'with' => [
                'country' => 'id,image_disk,image_path,name',
                'event_participants' => [
                    'select' => [
                        'id',
                        'number',
                        'participant_id',
                        'event_id'
                    ],
                    'with' => [
                        'running_score_result',
                        'participant:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender'
                    ]
                ],
                'tournament_stage:id,name,image_disk,image_path',
                'old_sport' => [
                    'columns' => [
                        'id',
                        'name',
                        'image_path',
                        'image_disk',
                    ]
                ]
            ],
            'columns' => [
                'name',
                'id',
                'start_date',
                'status_type',
                'status_description_id',
                'tournament_stage_name',
                'updated_at',
                'elapsed_time',
                'tournament_stage_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id',
                'first_win_betting_offer_id',
                'draw_betting_offer_id',
                'second_win_betting_offer_id',
                'country_id',
                'sport_id',
                'old_sport_id',
                'sport_name',
            ],
            'all' => true,
        ];
        $options['select_raw'] = $this->checkIsFavorite();
        return array_merge($options, $requiredOptions);
    }

    public function eventHeadToHead($eventId)
    {
        $model = $this->model->find($eventId, ['first_participant_id', 'second_participant_id']);
        if (empty($model)) {
            return collect();
        }
        $events = $this->model->where($model->toArray())->orWhere([
            'first_participant_id' => $model->second_participant_id,
            'second_participant_id' => $model->first_participant_id,
        ])->select('name',
            'id',
            'first_participant_id',
            'second_participant_id',
            'id',
            'start_date',
            'status_type',
            'status_description_id',
            'tournament_stage_name',
            'updated_at',
            'elapsed_time',
            'tournament_stage_id'
        )->with([
            'properties',
            'event_participants' => function ($q) {
                $q->select('id', 'number', 'participant_id', 'event_id')->with('running_score_result');
            },
        ])->get();

        return $events;
    }

    /**
     * @param $eventId
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function eventHeadToHeadExtended($eventId)
    {
        $model = $this->model->find($eventId, ['first_participant_id', 'second_participant_id']);
        if (empty($model) || empty($model->first_participant_id) || empty($model->second_participant_id)) {
            return [];
        }
        $participantIds = $model->only('first_participant_id', 'second_participant_id');
        $type = EnetParticipant::whereIn('id', $participantIds)->value('type');

        $this->model = $this->model->newQuery()
            ->where(function ($q) use ($participantIds) {
                $q->where($participantIds)
                    ->orWhere(function ($q) use ($participantIds) {
                        $q->where('first_participant_id', $participantIds['second_participant_id'])
                            ->where('second_participant_id', $participantIds['first_participant_id']);
                    });
            })
            ->where('id', '!=', $eventId);
        return $this->getTeamEvents($type);
    }

    /**
     * @param $teamId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function teamLastEvents($teamId)
    {
        $events = $this->model->newQuery()
            ->where(function ($q) use ($teamId) {
                $q->where('first_participant_id', $teamId)
                    ->orWhere('second_participant_id', $teamId);
            })
            ->whereNotIn('status_type', [\ConstEnetStatusType::Cancelled])
            ->whereNotIn('status_description_id', [\ConstStatusDescription::Postponed])
            ->where('start_date', '<', now())
            ->latest('start_date')
            ->limit(5)
            ->latest('id')
            ->select('name',
                'id',
                'start_date',
                'sport_id',
                'sport_name',
                'status_type',
                'status_description_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id'
            )->with([
                'home_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'away_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'home_team_final_result:value,event_participants_id',
                'away_team_final_result:value,event_participants_id',
            ])->get();
        $eventParticipantIds = $events->where('home_team_final_result', null)->pluck('event_first_participants_id');
        $eventParticipantIds = $eventParticipantIds->merge($events->where('away_team_final_result', null)->pluck('event_second_participants_id'));
        if ($eventParticipantIds->isNotEmpty()) {
            $results = EnetResult::whereIn('event_participants_id', $eventParticipantIds)
                ->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->get(['event_participants_id', 'value']);
            foreach ($events as $event) {
                if (is_null($event->home_team_final_result)) {
                    $result = $results->where('event_participants_id', $event->event_first_participants_id)->first();
                    $event->setRelation('home_team_final_result', $result);
                }
                if (is_null($event->away_team_final_result)) {
                    $result = $results->where('event_participants_id', $event->event_second_participants_id)->first();
                    $event->setRelation('away_team_final_result', $result);
                }
            }
        }

        return $events;
    }

    /**
     * @param $teamId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function teamNextEvents($teamId)
    {
        $events = $this->model->newQuery()
            ->where(function ($q) use ($teamId) {
                $q->where('first_participant_id', $teamId)
                    ->orWhere('second_participant_id', $teamId);
            })
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->limit(5)
            ->orderBy('id')
            ->select('name',
                'id',
                'start_date',
                'sport_id',
                'sport_name',
                'status_type',
                'status_description_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id'
            )->with([
                'home_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'away_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'home_team_final_result:value,event_participants_id',
                'away_team_final_result:value,event_participants_id',
            ])->get();
        $eventParticipantIds = $events->where('home_team_final_result', null)->pluck('event_first_participants_id');
        $eventParticipantIds = $eventParticipantIds->merge($events->where('away_team_final_result', null)->pluck('event_second_participants_id'));
        if ($eventParticipantIds->isNotEmpty()) {
            $results = EnetResult::whereIn('event_participants_id', $eventParticipantIds)
                ->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->get(['event_participants_id', 'value']);
            foreach ($events as $event) {
                if (is_null($event->home_team_final_result)) {
                    $result = $results->where('event_participants_id', $event->event_first_participants_id)->first();
                    $event->setRelation('home_team_final_result', $result);
                }
                if (is_null($event->away_team_final_result)) {
                    $result = $results->where('event_participants_id', $event->event_second_participants_id)->first();
                    $event->setRelation('away_team_final_result', $result);
                }
            }
        }

        return $events;
    }

    /**
     * @param $participantId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function athleteLastEvents($participantId)
    {
        $events = $this->model->newQuery()
            ->where(function ($q) use ($participantId) {
                $q->where('first_participant_id', $participantId)
                    ->orWhere('second_participant_id', $participantId);
            })
            ->whereNotIn('status_type', [\ConstEnetStatusType::Cancelled])
            ->whereNotIn('status_description_id', [\ConstStatusDescription::Postponed])
            ->where('start_date', '<', now())
            ->latest('start_date')
            ->limit(5)
            ->latest('id')
            ->select('name',
                'id',
                'start_date',
                'sport_id',
                'sport_name',
                'status_type',
                'status_description_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id'
            )->with([
                'home_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'away_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'home_team_running_score:value,event_participants_id',
                'away_team_running_score:value,event_participants_id',
            ])->get();
        $eventParticipantIds = $events->where('home_team_running_score', null)->pluck('event_first_participants_id');
        $eventParticipantIds = $eventParticipantIds->merge($events->where('away_team_running_score', null)->pluck('event_second_participants_id'));
        if ($eventParticipantIds->isNotEmpty()) {
            $results = EnetResult::whereIn('event_participants_id', $eventParticipantIds)
                ->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->get(['event_participants_id', 'value']);
            foreach ($events as $event) {
                if (is_null($event->home_team_running_score)) {
                    $result = $results->where('event_participants_id', $event->event_first_participants_id)->first();
                    $event->setRelation('home_team_running_score', $result);
                }
                if (is_null($event->away_team_running_score)) {
                    $result = $results->where('event_participants_id', $event->event_second_participants_id)->first();
                    $event->setRelation('away_team_running_score', $result);
                }
            }
        }

        return $events;
    }

    /**
     * @param $participantId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function athleteNextEvents($participantId)
    {
        $events = $this->model->newQuery()
            ->where(function ($q) use ($participantId) {
                $q->where('first_participant_id', $participantId)
                    ->orWhere('second_participant_id', $participantId);
            })
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->limit(5)
            ->orderBy('id')
            ->select('name',
                'id',
                'start_date',
                'sport_id',
                'sport_name',
                'status_type',
                'status_description_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id'
            )->with([
                'home_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'away_team:id,name,name_da,name_en,name_short_da,name_short_en,image_disk,image_path,type,country_id,gender',
                'home_team_running_score:value,event_participants_id',
                'away_team_running_score:value,event_participants_id',
            ])->get();
        $eventParticipantIds = $events->where('home_team_running_score', null)->pluck('event_first_participants_id');
        $eventParticipantIds = $eventParticipantIds->merge($events->where('away_team_running_score', null)->pluck('event_second_participants_id'));
        if ($eventParticipantIds->isNotEmpty()) {
            $results = EnetResult::whereIn('event_participants_id', $eventParticipantIds)
                ->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->get(['event_participants_id', 'value']);
            foreach ($events as $event) {
                if (is_null($event->home_team_running_score)) {
                    $result = $results->where('event_participants_id', $event->event_first_participants_id)->first();
                    $event->setRelation('home_team_running_score', $result);
                }
                if (is_null($event->away_team_running_score)) {
                    $result = $results->where('event_participants_id', $event->event_second_participants_id)->first();
                    $event->setRelation('away_team_running_score', $result);
                }
            }
        }

        return $events;
    }

    /**
     * @param $eventId
     * @return array
     */
    public function eventHomeTeamEvents($eventId)
    {
        $model = $this->model->find($eventId, ['first_participant_id']);
        if (empty($model) || empty($model->first_participant_id)) {
            return ['items' => [], 'team' => ''];
        }
        $participantId = $model->first_participant_id;
        $participant = EnetParticipant::where('id', $participantId)->first(['name', 'name_da', 'name_en', 'type']);

        $name = $participant ? $participant->name_translated : '';
        $this->model = $this->model->newQuery()
            ->where(function ($q) use ($participantId) {
                // @TODO correct
                $q->where('first_participant_id', $participantId)->orWhere('second_participant_id', $participantId);
            })->where('id', '!=', $eventId);
        return ['items' => $this->getTeamEvents($participant->type), 'team' => $name];
    }

    /**
     * @param $eventId
     * @return array
     */
    public function eventAwayTeamEvents($eventId)
    {
        $model = $this->model->find($eventId, ['second_participant_id']);
        if (empty($model) || empty($model->second_participant_id)) {
            return ['items' => [], 'team' => ''];
        }
        $participantId = $model->second_participant_id;
        $participant = EnetParticipant::where('id', $participantId)->first(['name', 'name_da', 'name_en', 'type']);
        $name = $participant ? $participant->name_translated : '';
        $this->model = $this->model->newQuery()
            ->where(function ($q) use ($participantId) {
                // @TODO correct
                $q->where('first_participant_id', $participantId)->orWhere('second_participant_id', $participantId);
            })->where('id', '!=', $eventId);
        return ['items' => $this->getTeamEvents($participant->type), 'team' => $name];
    }

    /**
     * @param $participantType
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getTeamEvents($participantType)
    {
        if ('athlete' == $participantType) {
            $homeScore = 'home_team_running_score';
            $awayScore = 'away_team_running_score';
        } else {
            $homeScore = 'home_team_final_result';
            $awayScore = 'away_team_final_result';
        }

        $events = $this->model
            ->where('start_date', '<', now())
            ->latest('start_date')
            ->latest('id')
            ->whereNotIn('status_type', [\ConstEnetStatusType::Cancelled])
            ->whereNotIn('status_description_id', [\ConstStatusDescription::Postponed])
            ->select('name',
                'id',
                'start_date',
                'status_type',
                'sport_id',
                'sport_name',
                'status_description_id',
                'first_participant_id',
                'second_participant_id',
                'event_first_participants_id',
                'event_second_participants_id'
            )->with([
                'home_team' => function ($q) {
                    $q->select('id', 'name', 'name_da', 'name_en', 'name_short_da', 'name_short_en', 'image_disk', 'image_path', 'type', 'country_id', 'gender');

                },
                'away_team' => function ($q) {
                    $q->select('id', 'name', 'name_da', 'name_en', 'name_short_da', 'name_short_en', 'image_disk', 'image_path', 'type', 'country_id', 'gender');

                },
                $homeScore . ':value,event_participants_id',
                $awayScore . ':value,event_participants_id',
            ])->paginate();

        $eventParticipantIds = $events->where($homeScore, null)->pluck('event_first_participants_id');
        $eventParticipantIds = $eventParticipantIds->merge($events->where($awayScore, null)->pluck('event_second_participants_id'));

        if ($eventParticipantIds->isNotEmpty()) {
            $resultType = ('athlete' == $participantType) ? \ConstEnetResultType::RUNNING_SCORE : \ConstEnetResultType::ORDINARY_TIME;

            $results = EnetResult::whereIn('event_participants_id', $eventParticipantIds)
                ->where('result_type_id', $resultType)->get(['event_participants_id', 'value']);
            foreach ($events as $event) {
                if (is_null($event->{$homeScore})) {
                    $result = $results->where('event_participants_id', $event->event_first_participants_id)->first();
                    $event->setRelation($homeScore, $result);
                }
                if (is_null($event->{$awayScore})) {
                    $result = $results->where('event_participants_id', $event->event_second_participants_id)->first();
                    $event->setRelation($awayScore, $result);
                }
            }
        }

        return $events;
    }

    /**
     * @return string
     */
    protected function checkIsFavorite()
    {
        $authId = $this->getAuthUserId();
        return $authId
            ? 'exists(select id from `user_favorite_enet_event` where `user_id` = ' . $authId . ' and `event_id` = enet_events.id) as is_favorite'
            : '0 as is_favorite';
    }
}
