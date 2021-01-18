<?php

namespace Api\V1\Transformers\Enet;

use Api\V1\Models\Enet\EnetCountry;
use Api\V1\Models\Enet\EnetEvent;
use Api\V1\Models\Enet\EnetParticipant;
use Api\V1\Models\Enet\EnetSport;
use Api\V1\Models\UserFavoriteEnetEvent;
use App\Helpers\CachedItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EnetEventTransformer extends BaseTransformer
{
    protected $homeParticipantId;
    protected $awayParticipantId;
    protected $eventHomeParticipantsId;
    protected $eventAwayParticipantsId;
    protected $bettingOffers;

    protected $config = [
        'odds' => [
            '3_way' => [
                \ConstEnetOutcomeType::_3Way => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::_3Way_Handicap => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::MostCorners => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::LastCorner => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::CornerHandicap => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::DoubleChance => [
                    \ConstEnetOutcomeSubType::WinDraw,
                    \ConstEnetOutcomeSubType::Win
                ],
                \ConstEnetOutcomeType::FirstTeamToScore => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ],
                \ConstEnetOutcomeType::MostBooking => [
                    \ConstEnetOutcomeSubType::Win,
                    \ConstEnetOutcomeSubType::Draw
                ]
            ],
            'team_2_way' => [
                \ConstEnetOutcomeType::DrawNoBet,
                \ConstEnetOutcomeType::TeamTotalScore,
                \ConstEnetOutcomeType::PointsHandicap,
                \ConstEnetOutcomeType::TeamOddEvenGoals,
                \ConstEnetOutcomeType::TeamScoreOverUnder,
                \ConstEnetOutcomeType::SetHandicap,
                \ConstEnetOutcomeType::GameHandicap,
                \ConstEnetOutcomeType::CornerAsianHandicap,
                \ConstEnetOutcomeType::AsianHandicap,
                \ConstEnetOutcomeType::WinToNil,
                \ConstEnetOutcomeType::_2Way,
            ],
            '2_way' => [
                \ConstEnetOutcomeType::OverUnder => [
                    \ConstEnetOutcomeSubType::Over,
                    \ConstEnetOutcomeSubType::Under,
                ],
                \ConstEnetOutcomeType::PointsOverUnder => [
                    \ConstEnetOutcomeSubType::Over,
                    \ConstEnetOutcomeSubType::Under,
                ],
                \ConstEnetOutcomeType::YellowCardsOverUnder => [
                    \ConstEnetOutcomeSubType::Over,
                    \ConstEnetOutcomeSubType::Under,
                ],
                \ConstEnetOutcomeType::SetsOverUnder => [
                    \ConstEnetOutcomeSubType::Over,
                    \ConstEnetOutcomeSubType::Under,
                ],
                \ConstEnetOutcomeType::CornersOverUnder => [
                    \ConstEnetOutcomeSubType::Over,
                    \ConstEnetOutcomeSubType::Under,
                ],
                \ConstEnetOutcomeType::OddEven => [
                    \ConstEnetOutcomeSubType::Odd,
                    \ConstEnetOutcomeSubType::Even
                ],
                \ConstEnetOutcomeType::CornersOddEven => [
                    \ConstEnetOutcomeSubType::Odd,
                    \ConstEnetOutcomeSubType::Even
                ],
                \ConstEnetOutcomeType::BothToScore => [
                    \ConstEnetOutcomeSubType::Yes,
                    \ConstEnetOutcomeSubType::No
                ],
                \ConstEnetOutcomeType::Tiebreak => [
                    \ConstEnetOutcomeSubType::Yes,
                    \ConstEnetOutcomeSubType::No
                ]
            ],
            '1_way' => [
                \ConstEnetOutcomeType::CorrectScore,
                \ConstEnetOutcomeType::HalfTimeFullTime,
                \ConstEnetOutcomeType::TimeOfNextGoal,
                \ConstEnetOutcomeType::NumberOfCorners,
                \ConstEnetOutcomeType::FirstTeamBooking,
                \ConstEnetOutcomeType::HalfWithMostGoals,
                \ConstEnetOutcomeType::Goalscorer,
            ],
        ]
    ];

    /**
     * EnetEventTransformer constructor.
     */
    public function __construct()
    {
        $this->bettingOffers = CachedItems::oddsProviders();
    }

    /**
     * @param EnetEvent $model
     * @param Request|null $request
     * @return mixed
     * @throws \Exception
     */
    public function transformSingeEvent($model, ? Request $request = null)
    {
        $response = $this->transformEvent($model, true);

        if ($model->is_favorite) {
            $userId = Auth::guard('api')->id();
            if ($userId) {
                $response['is_enabled'] = (bool)UserFavoriteEnetEvent::where('user_id', $userId)
                    ->where('event_id', $model->id)->value('is_enabled');
            }
        }

        if ($model->relationLoaded('properties')) {
            $response['properties'] = [];
            foreach ($model->properties as $property) {
                $response['properties'][$property->name] = $property->value;
            }

            $roundProperty = $model->properties->where('name', 'Round')->first();
            if ($roundProperty) {
                $value = $roundProperty->value;
                if (!in_array($value, ['1/8', '1/16', '1/32', '1/64', '1/128'])) {
                    $response['properties']['Round'] = __('sports.round') . ' ' . $value;
                } elseif (in_array($value, ['1/8', '1/16', '1/32', '1/64', '1/128'])) {
                    $response['properties']['Round'] = $value . ' ' . __('sports.finals');
                }
            }

            $details = [];
            if (key_exists('VenueNeutral', $response['properties']) && $response['properties']['VenueNeutral'] == 'yes') {
                $details[] = 'Neutral location';
            }

            if (key_exists('VenueName', $response['properties'])) {
                $details[] = $details ? ' - ' . $response['properties']['VenueName'] . '.' : "";
            }

            if (key_exists('Spectators', $response['properties'])) {
                if ($response['properties']['Spectators'] == 0) {
                    $details[] = ' No Spectators';
                } else {
                    $details[] = $response['properties']['Spectators'] . ' Spectators';
                }
                if (key_exists('Spectators_Comment', $response['properties'])) {
                    $details[] = ' ' . $response['properties']['Spectators_Comment'];
                }
                $details[] = '. ';
            } else {
                if (key_exists('Spectators_Comment', $response['properties'])) {
                    $details[] = ' ' . $response['properties']['Spectators_Comment'] . '.';
                }
            }

            if (1 == count($details) && key_exists('VenueName', $response['properties'])) {
                $details = [];
            }
            $response['details'] = implode($details);
        }


        $country = get_cached_countries()->where('id', $model->country_id)->first();

        $response['league_url'] = $country->image_url ?? EnetCountry::defaultUploadUrl('image_path');
        $response['league_id'] = $model->tournament_stage_id;
        return $response;
    }

    /**
     * @param EnetEvent $model
     * @param bool $includeOffer
     * @return mixed
     */
    public function transformEventWith3WayOffers(EnetEvent $model, $includeOffer = true)
    {
        $this->homeParticipantId = $model->home_participant_id;
        $this->awayParticipantId = $model->away_participant_id;

        $authId = Auth::guard('api')->id();
        $response = $this->transformEvent($model);

        if ($model->hasAttribute('is_favorite')) {
            $response['is_favorite'] = (bool)$model->is_favorite;
        } else {
            $response['is_favorite'] = $authId
                ? \DB::table('user_favorite_enet_event')->where('user_id', $authId)->where('event_id', $model->id)->exists()
                : false;
        }
        if ($includeOffer) {
            if ($model->relationLoaded('outcomes')) {
                $response['offers'] = $this->ge3WayMaxOffers($model->outcomes);
            } else {
                $cols = ['id', 'outcome_id', 'odds', 'odds_old', 'is_active'];
                $response['offers'] = [
                    $this->formatBettingOffer($model->first_win_betting_offer, $cols),
                    $this->formatBettingOffer($model->draw_betting_offer, $cols),
                    $this->formatBettingOffer($model->second_win_betting_offer, $cols),
                ];
            }
        }

        return $response;
    }

    /**
     * @param $model
     * @param bool $gameTimeLong
     * @return array
     */
    public function transformEvent($model, $gameTimeLong = false)
    {
        $response = [
            'league' => $model->tournament_stage_name ?? 'Unknown',
            'game_time' => $gameTimeLong ? $model->elapsed_time_short_extended : $model->elapsed_time_short,
            'time_label' => $model->elapsed_time_short,
            'start_date_human' => $model->start_date_timezone->diffForHumans(),
            'is_favorite' => $model->is_favorite,
            'is_favorite_bool' => (bool)$model->is_favorite, // TODO delete on of is_favorite_bool, is_favorite_int
            'is_favorite_int' => (int)$model->is_favorite,
            'sport_id' => $model->sport_id
        ];

        return array_merge($this->transformCoreEvent($model), $response);
    }

    /**
     * @param EnetEvent $item
     * @return array
     * @throws \Exception
     */
    protected function transformHeadToHead(EnetEvent $item)
    {
        $response = [
            'id' => $item->id,
            'start_date' => $item->start_date_timezone->toDateTimeString(),
            'home_team' => $item->home_name,
            'away_team' => $item->away_name,
            'home_team_short' => $item->home_short_name,
            'away_team_short' => $item->away_short_name,
            'sport_key' => Str::slug($item->sport_name),
            'home_id' => $item->first_participant_id,
            'away_id' => $item->second_participant_id,
            'home_team_url' => $item->home_team->image_url ?? EnetParticipant::defaultUploadUrl('image_path'),
            'away_team_url' => $item->away_team->image_url ?? EnetParticipant::defaultUploadUrl('image_path'),
            'home_team_score' => $this->getScoreByResult($item, ['home_team_final_result', 'home_team_running_score']),
            'away_team_score' => $this->getScoreByResult($item, ['away_team_final_result', 'away_team_running_score']),
        ];

        return array_merge($this->transformCoreEvent($item), $response);
    }

    /**
     * @param $event
     * @param $scores
     * @return string
     */
    protected function getScoreByResult(EnetEvent $event, $scores)
    {
        foreach ($scores as $score) {
            if ($event->relationLoaded($score)) {
                return $event->{$score}->value ?? '-';
            }
        }

        return '-';
    }

    /**
     * @param EnetEvent $model
     * @return array
     */
    protected function transformCoreEvent(EnetEvent $model)
    {
        return [
            'id' => $model->id,
            'sport_id' => $model->sport_id,
            'sport_key' => Str::slug($model->sport_name),
            'start_date' => $model->start_date_timezone->toDateTimeString(),
            'status_type' => $model->status_type,
            'status_type_label' => mobile_status_type($model->status_type),
            'status_description' => mobile_status_description($model->status_description_id),
            'status_description_id' => $model->status_description_id,
            'home_type' => $model->home_type,
            'away_type' => $model->away_type,
            'home_id' => $model->first_participant_id,
            'away_id' => $model->second_participant_id,
            'home_name' => $model->home_name,
            'away_name' => $model->away_name,
            'home_name_short' => $model->home_short_name,
            'away_name_short' => $model->away_short_name,
            'home_image_url' => $model->home_image_url,
            'away_image_url' => $model->away_image_url,
            'home_score' => $this->getScore($model, $model->event_home_participant),
            'away_score' => $this->getScore($model, $model->event_away_participant),
        ];
    }


    /**
     * @param $item
     * @return mixed
     */
    public function transformEventOdds($item)
    {
        $this->homeParticipantId = $item->first_participant_id;
        $this->awayParticipantId = $item->second_participant_id;
        return $item->outcomes->groupBy(function ($item) {
            return mobile_outcome_type($item->outcome_type_id . '.label');
        })->map(function ($items, $groupKey) {
            $outcomeTypeId = $items->first()->outcome_type_id;
            $outcomeTypeBettingLabels = mobile_outcome_type($outcomeTypeId . '.betting_labels');
            return [
                'description' => mobile_outcome_type($outcomeTypeId . '.description'),
                'betting_labels' => $outcomeTypeBettingLabels,
                'data' => $this->groupByOutcomeScope($items, $outcomeTypeId, 'getMaxOfferByOutcomeType')
            ];
        });
    }

    /**
     * @param $item
     * @param $outcomeTypeId
     * @return mixed
     */
    public function transformEventOddsByOutcomeType($item, $outcomeTypeId)
    {
        if (empty($item) || $item->outcomes->isEmpty()) {
            return [];
        }
        $this->homeParticipantId = $item->first_participant_id;
        $this->awayParticipantId = $item->second_participant_id;
        return $this->groupByOutcomeScope($item->outcomes, $outcomeTypeId, 'getMaxOfferByOutcomeType');
    }

    /**
     * @param Collection $items
     * @param $outcomeTypeId
     * @param null $method
     * @return Collection
     */
    public function groupByOutcomeScope(Collection $items, $outcomeTypeId, $method = 'getEventBookmakersByOutcomeType')
    {
        return $items->groupBy(function ($item) {
            return mobile_outcome_scope($item->outcome_scope_id);
        })->map(function ($items) use ($outcomeTypeId, $method) {
            return $this->scopeOddsData($items, $outcomeTypeId, $method);
        });
    }

    /**
     * @param $items
     * @param $outcomeTypeId
     * @param $method
     * @return mixed
     */
    protected function scopeOddsData($items, $outcomeTypeId, $method = 'getEventBookmakersByOutcomeType')
    {
        if ($outcomeTypeId == \ConstEnetOutcomeType::HalfWithMostGoals) {
            return $items
                ->sortBy(function ($item) {
                    if (\ConstEnetOutcomeSubType::Win == $item->outcome_subtype_id) {
                        return $item->sparam;
                    }

                    return 2;
                })
                ->groupBy(function ($item) use ($outcomeTypeId) {
                    if (\ConstEnetOutcomeSubType::Win == $item->outcome_subtype_id) {
                        return mobile_outcome_type($outcomeTypeId . '.betting_win', [
                            'sparam' => $item->sparam,
                        ]);
                    }

                    return mobile_outcome_type($outcomeTypeId . '.betting_draw');
                })
                ->map(function ($items) use ($outcomeTypeId, $method) {
                    return $this->{$method}($items, $outcomeTypeId);
                });
        }

        if ($outcomeTypeId == \ConstEnetOutcomeType::Goalscorer) {
            $players = EnetParticipant::whereIn('id', $items->pluck('iparam'))->pluck('name', 'id');
            return $items
                ->sortBy(function ($item) {
                    if (\ConstEnetOutcomeSubType::Next == $item->outcome_subtype_id) {
                        return 1;
                    }

                    if (\ConstEnetOutcomeSubType::Last == $item->outcome_subtype_id) {
                        return 2;
                    }

                    if (\ConstEnetOutcomeSubType::Anytime == $item->outcome_subtype_id) {
                        return 3;
                    }
                    return 4;
                })
                ->groupBy(function ($item) use ($outcomeTypeId, $players) {
                    $player = $players[$item->iparam] ?? '';
                    if (\ConstEnetOutcomeSubType::Next == $item->outcome_subtype_id) {
                        return mobile_outcome_type($outcomeTypeId . '.betting_next', [
                            'player' => $player,
                        ]);
                    }

                    if (\ConstEnetOutcomeSubType::Last == $item->outcome_subtype_id) {
                        return mobile_outcome_type($outcomeTypeId . '.betting_last', [
                            'player' => $player,
                        ]);
                    }
                    if (\ConstEnetOutcomeSubType::Anytime == $item->outcome_subtype_id) {
                        return mobile_outcome_type($outcomeTypeId . '.betting_anytime', [
                            'player' => $player,
                        ]);
                    }

                    return mobile_outcome_type($outcomeTypeId . '.betting_none');
                })
                ->map(function ($items) use ($outcomeTypeId, $method) {
                    return $this->{$method}($items, $outcomeTypeId);
                });
        }

        if ($outcomeTypeId == \ConstEnetOutcomeType::TimeOfNextGoal) {
            return $items->sortBy(function ($item) {
                if (\ConstEnetOutcomeSubType::None == $item->outcome_subtype_id) {
                    $order = 1000000;
                } elseif (\ConstEnetOutcomeSubType::From == $item->outcome_subtype_id) {
                    $order = 100000 + $item->dparam;
                } elseif (\ConstEnetOutcomeSubType::FromTo == $item->outcome_subtype_id) {
                    $order = 10000 + $item->dparam;
                } else {
                    $order = 10000 * (1 + $item->dparam);
                }
                $order += $item->dparam2;
                return $order; // @TODO
            })->groupBy(function ($item) use ($outcomeTypeId) {
                if (\ConstEnetOutcomeSubType::FromTo == $item->outcome_subtype_id) {
                    return mobile_outcome_type($outcomeTypeId . '.betting_from_to', [
                        'start' => $item->dparam,
                        'end' => $item->dparam2,
                    ]);
                }
                if (\ConstEnetOutcomeSubType::From == $item->outcome_subtype_id) {
                    return mobile_outcome_type($outcomeTypeId . '.betting_from', [
                        'start' => $item->dparam,
                    ]);
                }

                if (\ConstEnetOutcomeSubType::None == $item->outcome_subtype_id) {
                    return mobile_outcome_type($outcomeTypeId . '.betting_no_goal');
                }

                return mobile_outcome_type($outcomeTypeId . '.betting_before', [
                    'end' => $item->dparams,
                ]);
            })->map(function ($items) use ($outcomeTypeId, $method) {
                return $this->{$method}($items, $outcomeTypeId);
            });
        }

        if ($outcomeTypeId == \ConstEnetOutcomeType::FirstTeamBooking) {
            return $items->sortBy(function ($item) {
                if (\ConstEnetOutcomeSubType::Win == $item->outcome_subtype_id) {
                    return 1;
                }

                if (\ConstEnetOutcomeSubType::None == $item->outcome_subtype_id) {
                    return 2;
                }

                return 3;
            })->groupBy(function ($item) use ($outcomeTypeId) {
                if (\ConstEnetOutcomeSubType::Win == $item->outcome_subtype_id) {
                    return mobile_outcome_type($outcomeTypeId . '.betting_label_win', [
                        'team' => ($item->iparam == $this->homeParticipantId) ? 1 : 0
                    ]);
                }

                if (\ConstEnetOutcomeSubType::None == $item->outcome_subtype_id) {
                    return mobile_outcome_type($outcomeTypeId . '.betting_label_none');
                }

                return mobile_outcome_type($outcomeTypeId . '.betting_label_draw');
            })->map(function ($items) use ($outcomeTypeId, $method) {
                return $this->{$method}($items, $outcomeTypeId);
            });
        }

        if (in_array($outcomeTypeId, [
            \ConstEnetOutcomeType::NumberOfCorners,
            \ConstEnetOutcomeType::TeamTotalScore,
            \ConstEnetOutcomeType::NumberOfCards,
            \ConstEnetOutcomeType::NumberOfGoals
        ])) {
            return $items->sortBy(function ($item) {
                return $item->dparam * 1000 + ($item->dparam2 ? $item->dparam2 : 100);
            })->groupBy(function ($item) use ($outcomeTypeId) {
                if (\ConstEnetOutcomeSubType::FromTo == $item->outcome_subtype_id) {
                    if ($item->dparam2 == $item->dparam) {
                        return mobile_outcome_type($outcomeTypeId . '.betting_label_exact', [
                            'exact' => $item->dparam,
                        ]);
                    }

                    return mobile_outcome_type($outcomeTypeId . '.betting_label_from_to', [
                        'from' => $item->dparam,
                        'to' => $item->dparam2,
                    ]);
                }

                return mobile_outcome_type($outcomeTypeId . '.betting_label_from', [
                    'from' => $item->dparam,
                ]);

            })->map(function ($items) use ($outcomeTypeId, $method) {
                return $this->{$method}($items, $outcomeTypeId);
            });
        }

        if ($outcomeTypeId == \ConstEnetOutcomeType::HalfTimeFullTime) {
            return $items->sortBy(function ($item) {
                if ($item->iparam == $this->homeParticipantId) {
                    $order = 10;
                } elseif ($item->iparam == 0) {
                    $order = 20;
                } else {
                    $order = 30;
                }

                if ($item->iparam2 == $this->homeParticipantId) {
                    $order += 1;
                } elseif ($item->iparam2 == 0) {
                    $order += 2;
                } else {
                    $order += 3;
                }
                return $order;
            })->groupBy(function ($item) use ($outcomeTypeId) {
                return mobile_outcome_type($outcomeTypeId . '.betting_label', [
                    'iparam' => ($item->iparam == $this->homeParticipantId) ? 1 : (($item->iparam == 0) ? 'x' : 2),
                    'iparam2' => ($item->iparam2 == $this->homeParticipantId) ? 1 : (($item->iparam2 == 0) ? 'x' : 2),
                ]);
            })->map(function ($items) use ($outcomeTypeId, $method) {
                return $this->{$method}($items, $outcomeTypeId);
            });
        }

        if ($outcomeTypeId == \ConstEnetOutcomeType::CorrectScore) {
            $sortedItems = $items->sortBy(function ($item) {
                return ($item->dparam + 1) * 1000 + $item->dparam2;
            });
        } else {
            $sortedItems = $items->sortBy('dparam');
        }

        return $sortedItems->groupBy(function ($item) use ($outcomeTypeId) {
            return mobile_outcome_type($outcomeTypeId . '.betting_label', ['dparam' => $item->dparam, 'dparam2' => $item->dparam2]);
        })->map(function ($items) use ($outcomeTypeId, $method) {
            return $this->{$method}($items, $outcomeTypeId);
        });
    }

    /**
     * @param $event
     * @param $incidents
     * @return mixed
     */
    public function transformEventOverViewsExtended($event, $incidents)
    {
        if ($incidents->isEmpty()) {
            return [];
        }

        $this->eventHomeParticipantsId = $event->event_first_participants_id;
        $this->eventAwayParticipantsId = $event->event_second_participants_id;
        if (in_array($event->sport_id, [\ConsEnetSport::ICE_HOCKEY, \ConsEnetSport::AM_FOOTBALL])) {
            foreach ($incidents as $incident) {
                $incident->elapsed = (int)floor($incident->elapsed / 60);
            }
        }

        $data = $this->processEventOverViews($incidents, $event->sport_id);
        $config = [
            \ConsEnetSport::FOOTBALL => [
                45 => \ConstEnetResultType::HALFTIME,
                90 => \ConstEnetResultType::ORDINARY_TIME,
                120 => \ConstEnetResultType::EXTRA_TIME,
                150 => \ConstEnetResultType::PENALTY_SHOOTOUT,
            ],
            \ConsEnetSport::HANDBALL => [
                30 => \ConstEnetResultType::HALFTIME,
                60 => \ConstEnetResultType::FINAL_RESULT,
            ],
            \ConsEnetSport::AM_FOOTBALL => [
                30 => \ConstEnetResultType::HALFTIME,
                60 => \ConstEnetResultType::FINAL_RESULT,
            ],
        ];

        $sportConfig = $config[$event->sport_id] ?? [];
        $grouped = collect($data)->groupBy(function ($item) use ($sportConfig) {
            if (\ConstIncidentsType::PenaltyShootoutScored == $item['incident_type_id']) {
                return \ConstEnetResultType::PENALTY_SHOOTOUT;
            }
            if (\ConstIncidentsType::PenaltyShootoutMissed == $item['incident_type_id']) {
                return \ConstEnetResultType::PENALTY_SHOOTOUT;
            }

            $result = null;
            foreach ($sportConfig as $minute => $resultId) {
                $result = $resultId;
                if ($item['minutes'] <= $minute) {
                    return $result;
                }
            }

            return $result;
        });
        $response = [];

        foreach ($sportConfig as $resultId) {
            $label = __mobile('result_name.' . $resultId);

            if (!$grouped->has($resultId)) {
                if ($resultId == \ConstEnetResultType::HALFTIME) {
                    $resultId = $data ? \ConstEnetResultType::HALFTIME : \ConstEnetResultType::RUNNING_SCORE;
                } else {
                    continue;
                }
            }

            $data = $grouped->has($resultId) ? $grouped[$resultId] : collect();

            if (\ConstEnetResultType::ORDINARY_TIME == $resultId) {
                $results = [
                    'home_score' => (string)$this->getSecondHalfResult($event->home_team_results, $resultId),
                    'away_score' => (string)$this->getSecondHalfResult($event->away_team_results, $resultId),
                ];
            } else {
                $homeResult = $event->home_team_results->where('result_type_id', $resultId)->first();
                $awayResult = $event->away_team_results->where('result_type_id', $resultId)->first();
                $results = [
                    'home_score' => $homeResult->value ?? '-',
                    'away_score' => $awayResult->value ?? '-'
                ];
            }
            $response[] = [
                'label' => $label,
                'results' => $results,
                'overviews' => $data->toArray()
            ];
        }

        return $response;
    }

    /**
     * @param $results
     * @param $resultId
     * @return int|string
     */
    protected function getSecondHalfResult($results, $resultId)
    {
        $result = $results->where('result_type_id', $resultId)->first();
        if ($result) {
            return $result->value - ($results->where('result_type_id', \ConstEnetResultType::HALFTIME)->first()->value ?? 0);
        }

        return '-';
    }

    /**
     * @param $results
     * @param $resultId
     * @return int|string
     */
    protected function getExtraTimeResult($results, $resultId)
    {
        $result = $results->where('result_type_id', $resultId)->first();
        if ($result) {
            return $result->value - ($results->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->first()->value ?? 0);
        }

        return '-';
    }

    /**
     * @param $event
     * @param $incidents
     * @return mixed
     */
    public function transformEventOverViews($event, $incidents)
    {
        $this->eventHomeParticipantsId = $event->event_first_participants_id;
        $this->eventAwayParticipantsId = $event->event_second_participants_id;
        if (in_array($event->sport_id, [\ConsEnetSport::ICE_HOCKEY, \ConsEnetSport::AM_FOOTBALL])) {
            foreach ($incidents as $incident) {
                $incident->elapsed = (int)floor($incident->elapsed / 60);
            }
        }
        return $this->processEventOverViews($incidents, $event->sport_id);
    }

    /**
     * @param $incidents
     * @param $sportId
     * @return array
     */
    protected function processEventOverViews($incidents, $sportId)
    {
        $groupedIncidents = $incidents->sortBy(function ($item) {
            return $item->elapsed * 1000 + $item->sort_order;
        })->groupBy('elapsed');

        $response = [];

        foreach ($groupedIncidents as $minutes => $incidents) {
            $secondGroup = $incidents->groupBy(function ($item) {
                if (in_array($item->incident_type_id, [\ConstIncidentsType::SubstitutionOut, \ConstIncidentsType::SubstitutionIn])) {
                    return 'subst';
                }

                return $item->sort_order;
            });

            foreach ($secondGroup as $group => $values) {

                if ($group === 'subst') {
                    $substInCount = 1;
                    $substOutCount = 1;
                    $_values = $values->groupBy(function ($item) use (&$substInCount, &$substOutCount) {
                        if ($item->incident_type_id == \ConstIncidentsType::SubstitutionOut) {
                            return $substOutCount++;
                        } else {
                            return $substInCount++;
                        }
                    });

                    foreach ($_values as $items) {
                        $response[] = $this->processSubstOverViews($items, $sportId);
                    }
                    continue;
                }

                $assistants = $values->whereIn('incident_type_id', [\ConstIncidentsType::Assist, \ConstIncidentsType::Assist2nd]);


                if ($assistants->count() == $values->count()) {
                    continue;
                }

                if ($assistants->count() && $assistants->count() == $values->count() - 1) {
                    $response[] = $this->processAssistOverViews($values, $sportId);
                    continue;
                }

                foreach ($values as $value) {
                    $response[] = $this->processSingleOverView($value, $sportId);
                }
            }
        }

        return $response;
    }

    /**
     * @param $items
     * @param $sportId
     * @return array
     */
    protected function processAssistOverViews($items, $sportId)
    {
        $itemAssist = $items->where('incident_type_id', \ConstIncidentsType::Assist)->first();
        $item = $items->where('incident_type_id', '!=', \ConstIncidentsType::Assist)->first();
        $playerAssist = $itemAssist->participant->name_translated ?? __mobile('unknown-player');
        $player = $item->participant->name_translated ?? __mobile('unknown-player');

        return [
            'team' => $item->event_participants_id == $this->eventHomeParticipantsId ? 1 : 2,
            'minutes' => $itemSubstIn->elapsed ?? $item->elapsed,
            'player_name' => sprintf('%s (%s)', $player, $playerAssist),
            'player_1' => $player,
            'player_2' => $playerAssist,
            'image' => \ConstIncidentsType::image($item->incident_type_id, $sportId),
            'incident_type_id' => $item->incident_type_id,
        ];
    }

    /**
     * @param $items
     * @param $sportId
     * @return array
     */
    protected function processSubstOverViews($items, $sportId)
    {
        $itemSubstIn = $items->where('incident_type_id', \ConstIncidentsType::SubstitutionIn)->first();
        $itemSubstOut = $items->where('incident_type_id', \ConstIncidentsType::SubstitutionOut)->first();
        $playerSubstIn = $itemSubstIn->participant->name_translated ?? __mobile('unknown-player');
        $playerSubstOut = $itemSubstOut->participant->name_translated ?? __mobile('unknown-player');

        if (empty($itemSubstIn)) {
            // @TODO optimize queries later
            $playerSubstIn = $this->getCachedSubstParticipant($itemSubstOut, 'in_playerFK');
            $team = $itemSubstOut->event_participants_id == $this->eventHomeParticipantsId ? 1 : 2;
        } else {
            $team = $itemSubstIn->event_participants_id == $this->eventHomeParticipantsId ? 1 : 2;
        }
        if (empty($itemSubstOut)) {
            $playerSubstOut = $this->getCachedSubstParticipant($itemSubstIn, 'out_playerFK');
            $team = $itemSubstIn->event_participants_id == $this->eventHomeParticipantsId ? 1 : 2;
        }

        return [
            'team' => $team,
            'minutes' => $itemSubstIn->elapsed ?? $itemSubstOut->elapsed,
            'player_name' => sprintf('%s (%s)', $playerSubstIn, $playerSubstOut),
            'player_1' => $playerSubstIn,
            'player_2' => $playerSubstOut,
            'image' => \ConstIncidentsType::image(\ConstIncidentsType::SubstitutionIn, $sportId),
            'incident_type_id' => \ConstIncidentsType::SubstitutionIn,
        ];
    }

    /**
     * @param $item
     * @param $sportId
     * @return array
     */
    protected function processSingleOverView($item, $sportId)
    {
        $playerName = $item->participant->name_translated ?? __mobile('unknown-player');

        if (\ConsEnetSport::AM_FOOTBALL == $sportId) {
            if (\ConstIncidentsType::TwoPointConversion == $item->incident_type_id) {
                $playerName = __mobile('incident_preview.2_point_conversion') . ' ' . $playerName;
            } elseif (\ConstIncidentsType::FieldGoal == $item->incident_type_id) {
                $playerName = __mobile('incident_preview.field_goal') . ' ' . $playerName;
            } elseif (\ConstIncidentsType::Safety == $item->incident_type_id) {
                $playerName = __mobile('incident_preview.safety') . ' ' . $playerName;
            } elseif (\ConstIncidentsType::Touchdown == $item->incident_type_id) {
                $playerName = __mobile('incident_preview.touchdown') . ' ' . $playerName;
            } elseif (\ConstIncidentsType::ExtraPoint == $item->incident_type_id) {
                $playerName = __mobile('incident_preview.extra_point') . ' ' . $playerName;
            }
        }

        if (\ConstIncidentsType::CancelledGoal == $item->incident_type_id) {
            $playerName = __mobile('incident_preview.cancelled_goal') . ' ' . $playerName;
        }

        return [
            'team' => $this->eventHomeParticipantsId == $item->event_participants_id ? 1 : 2,
            'minutes' => $item->elapsed,
            'incident_type_id' => $item->incident_type_id,
            'player_name' => $playerName,
            'image' => \ConstIncidentsType::image($item->incident_type_id, $sportId)
        ];
    }

    private function getCachedSubstParticipant($item, $name)
    {
        return Cache::remember('itemSubstOut' . $item->id, 60 * 60 * 24 * 30, function () use ($item, $name) {
            $item->load([
                'properties' => function ($q) use ($name) {
                    $q->where('name', $name)->select('object_id', 'value');
                }
            ]);
            $property = $item->properties->first();
            if ($property) {
                return EnetParticipant::where('id', $property->value)->value('name') ?? __mobile('unknown-player');
            }
            return __mobile('unknown-player');
        });
    }

    public function transformEventLineups($event, $lineups)
    {
        $homeShirtUrl = $event->home_team->home_shirt_image_url;
        $awayShirtUrl = $event->away_team->away_shirt_image_url;

        return [
            'home' => $this->transformLineups($lineups, $event->event_first_participants_id),
            'away' => $this->transformLineups($lineups, $event->event_second_participants_id),
            'home_shirt_url' => $homeShirtUrl,
            'away_shirt_url' => $awayShirtUrl,
            'lineup_confirmed' => $event->properties->where('name', 'LineupConfirmed')->first()->value ?? 'no'
        ];
    }

    /**
     * @param $_lineups
     * @param $eventParticipantId
     * @return array
     */
    protected function transformLineups($_lineups, $eventParticipantId)
    {
        $lineups = $_lineups->where('event_participants_id', $eventParticipantId);

        if ($lineups->isEmpty()) {
            return [];
        }

        return $lineups->groupBy(function ($item) {
            return $item->lineup_type_id;
        })->map(function ($items) {
            return [
                'lineup' => mobile_lineup_type($items->first()->lineup_type_id),
                'lineup_type_id' => $items->first()->lineup_type_id,
                'participants' => $items->map(function ($item) {
                    return [
                        'id' => $item->participant->id ?? null,
                        'shirt_number' => $item->shirt_number,
                        'pos' => $item->pos,
                        'name' => $item->participant->name_translated ?? __mobile('unknown-player'),
                        'flag_url' => $item->participant->country->image_url ?? (new EnetCountry())->getDefaultUploadUrl('image_disk')
                    ];
                })
            ];
        })->values();
    }

    /**
     * @param $items
     * @param $sportId
     * @return array
     */
    public function transformEventsGroupByLeague($items, $sportId)
    {
        $items = $items->sortBy(function ($item) {
            return $item->country_league_name . $item->start_date;
        })->groupBy(function ($item) {
            return ($item->old_sport_id ? $item->old_sport_id . '-' : '') . $item->country_league_name;
        });
        $grouped = [];
        foreach ($items as $leagueName => $groupedItems) {
            $first = $groupedItems->first();
            if ($first->sport_id == \ConsEnetSport::E_SPORTS) {
                if ($first->old_sport_id && $first->old_sport && $first->old_sport->icon_url) {
                    $imageUrl = $first->old_sport->icon_url;
                    $leagueName = Str::replaceFirst($first->old_sport_id . '-', '', $leagueName);
                } else {
                    $imageUrl = Cache::remember('e-sport-image_url', 24 * 60 * 60, function () {
                        return EnetSport::where('id', \ConsEnetSport::E_SPORTS)->first(['image_path', 'image_disk'])->icon_url
                            ?? EnetCountry::defaultUploadUrl('image_path');
                    });
                }
            } else {
                $imageUrl = $first->country->image_url ?? EnetCountry::defaultUploadUrl('image_path');
            }

            $grouped[] = [
                'league' => [
                    'id' => $first->tournament_stage_id,
                    'name' => $leagueName,
                    'league_name' => $first->tournament_stage_name,
                    'country_name' => mobile_country($first->country_id),
                    'sport_name' => ($first->old_sport_id && $first->old_sport) ? $first->old_sport->name : $first->sport_name,
                    'image_url' => $imageUrl,
                ],
                'events' => $groupedItems->map(function ($model) {
                    return $this->transformEventWith3WayOffers($model);
                })->toArray()
            ];
        }
        return $grouped;
    }

    /**
     * @param $items
     * @param $sportId
     * @return array
     */
    public function transformEventsGroupByLeagueWeb($items, $sportId)
    {
        $data = $this->_transformEventsGroupByLeagueWeb($items);
        $request = $request ?? app('request');
        parse_str($request->getQueryString(), $appends);
        $paginated = $items->appends($appends)->toArray();
        $response = [
            'items' => $data,
            'links' => $this->paginationLinks($paginated),
            'meta' => $this->meta($paginated),
        ];
        return $response;
    }

    /**
     * @param $items
     * @return mixed
     */
    public function _transformEventsGroupByLeagueWeb($items)
    {
        return $items->map(function ($model) {
            return [
                'id' => $model->id,
                'league_id' => $model->tournament_stage_id,
                'game_time' => $model->elapsed_time_short,
                'status_type' => $model->status_type,
                'status_description' => mobile_status_description($model->status_description_id),
                'status_description_id' => $model->status_description_id,
                'is_favorite' => $model->is_favorite,
                'home_name' => $model->home_name,
                'away_name' => $model->away_name,
                'home_image_url' => $model->home_image_url,
                'away_image_url' => $model->away_image_url,
                'home_score' => $this->getScore($model, $model->event_home_participant),
                'away_score' => $this->getScore($model, $model->event_away_participant),
            ];
        });
    }

    public function transformFeedEvent(EnetEvent $item)
    {
        return [
            'id' => $item->id,
            'sport' => $item->sport,
            'sport_key' => $item->sport_key,
            'sport_id' => $item->sport_id,
            'status_type' => $item->status_type,
            'start_date_human' => $this->checkDay($item->start_date_timezone),
            'game_time' => $item->elapsed_time_short,
            'home_id' => $item->first_participant_id,
            'away_id' => $item->second_participant_id,
            'home_name_short' => $item->home_short_name,
            'away_name_short' => $item->away_short_name,
            'home_image_url' => $item->home_image_url,
            'away_image_url' => $item->away_image_url,
            'home_score' => $this->getScore($item, $item->event_home_participant),
            'away_score' => $this->getScore($item, $item->event_away_participant),
        ];
    }

    protected function checkDay($startDate)
    {
        if ($startDate->isToday()) {
            return __mobile('today');
        } else if ($startDate->isYesterday()) {
            return __mobile('yesterday');
        } else if (now()->diffInDays($startDate, false) < -1) {
            return $startDate->day . ' ' . $startDate->shortEnglishMonth;
        } else if (now()->diffInDays($startDate, false) < 7) {
            return $startDate->localeDayOfWeek;
        } else {
            return __mobile('feed_datetime', ['date' => now()->diffInDays($startDate)]);
        }
    }


    /**
     * @param EnetEvent $resource
     * @param Request|null $request
     * @param null $method
     * @return array|mixed
     */
    public function transform($resource, ?Request $request = null, $method = null)
    {
        if (empty($resource)) {
            return [];
        }
        return parent::transform($resource, $request, $method);
    }


    /**
     * @param $items
     * @param $request
     * @return array
     */
    public function transformEventsGroupByDate($items)
    {
        $items = $items->sortBy('start_date')->groupBy(function ($item) {
            return Carbon::parse($item->start_date)->format('Y-m-d');
        });
        $grouped = [];
        foreach ($items as $date => $dateItems) {
            $grouped[] = [
                'date' => $date,
                'events' => $dateItems->map(function ($model) {
                    return $this->transformEventWith3WayOffers($model);
                })->toArray()
            ];
        }
        return $grouped;
    }


    /**
     * @param $model
     * @param bool $includeOffer
     * @return mixed
     */
    public function transformUserFavoriteEvents($model, $includeOffer = true)
    {
        $this->homeParticipantId = $model->home_participant_id;
        $this->awayParticipantId = $model->away_participant_id;
        $startDate = $model->start_date_timezone;

        $sportName = $model->sport_name ?? 'Football';
        $sportName = 'Soccer' == $sportName ? 'Football' : $sportName;
        $authId = Auth::guard('api')->id();
        $response['id'] = $model->id;
        $response['is_favorite'] = $authId
            ? \DB::table('user_favorite_enet_event')->where('user_id', $authId)->where('event_id', $model->id)->exists()
            : false;

        $response['status_type'] = $model->status_type;
        $response['status_type_label'] = mobile_status_type($model->status_type);
        $response['status_description'] = mobile_status_description($model->status_description_id);
        $response['status_description_id'] = $model->status_description_id;
        $response['league'] = $model->tournament_stage_name;

        $response['country'] = $model->country_id ? mobile_country($model->country_id) : 'International';
        $response['country_url'] = $model->country->image_url ?? (new EnetCountry())->getDefaultUploadUrl('image_disk');
        $response['game_time'] = $model->elapsed_time_short;
        $response['time_label'] = $model->elapsed_time_short;
        $response['start_date'] = $model->start_date_timezone->toDateTimeString();

        $response['start_date_human'] = $startDate->diffForHumans();
        $response['sport_name'] = $sportName;
        $response['sport_id'] = $model->sport_id;
        $response['sport_key'] = Str::slug($sportName);
        $response['home_name'] = $model->home_name;
        $response['away_name'] = $model->away_name;

        $response['home_id'] = $model->first_participant_id;
        $response['away_id'] = $model->second_participant_id;
        $response['home_image_url'] = $model->home_image_url;
        $response['away_image_url'] = $model->away_image_url;
        $response['home_score'] = $this->getScore($model, $model->event_home_participant);
        $response['away_score'] = $this->getScore($model, $model->event_away_participant);

        if ($includeOffer) {
            $response['offers'] = $this->ge3WayMaxOffers($model->outcomes);
        }

        return $response;
    }

    public function transformEventBookmakers($item)
    {
        $this->homeParticipantId = $item->home_participant_id;
        $this->awayParticipantId = $item->away_participant_id;
        return $item->outcomes->groupBy(function ($item) {
            return mobile_outcome_type($item->outcome_type_id . '.label');
        })->map(function ($items) {
            $outcomeTypeId = $items->first()->outcome_type_id;
            $outcomeTypeBettingLabels = mobile_outcome_type($outcomeTypeId . '.betting_labels');
            return [
                'description' => mobile_outcome_type($outcomeTypeId . '.description'),
                'betting_labels' => $outcomeTypeBettingLabels,
                'data' => $this->groupByOutcomeScope($items, $outcomeTypeId)
            ];
        });
    }

    public function transformEventBookmakersByOutcomeType($item, $outcomeTypeId)
    {
        if (empty($item) || $item->outcomes->isEmpty()) {
            return [];
        }
        $this->homeParticipantId = $item->home_participant_id;
        $this->awayParticipantId = $item->away_participant_id;
        return $this->groupByOutcomeScope($item->outcomes, $outcomeTypeId);
    }


    /**
     * @param $item
     * @return array
     */
    public function transformEventOutcomeTypes($item)
    {
        $outcomeTypeId = $item->outcome_type_id;
        return [
            'id' => $outcomeTypeId,
            'label' => mobile_outcome_type($outcomeTypeId . '.label'),
            'description' => mobile_outcome_type($outcomeTypeId . '.description'),
            'betting_labels' => mobile_outcome_type($outcomeTypeId . '.betting_labels'),
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function transformEventOutcomeVotes($item)
    {
        $this->homeParticipantId = $item->first_participant_id;
        $this->awayParticipantId = $item->second_participant_id;
        $bettingOffers = $this->getBettingOffers();

        return $item->outcome_votes->map(function ($vote) use ($item, $bettingOffers) {
            $vote->translate(true, get_auth_locale());
            $outcomes = $item->outcomes
                ->where('outcome_type_id', $vote->outcome_type_id)
                ->groupBy('betting_offers.*.odds_provider_id');
            $oddProviderId = $outcomes->keys()->first();

            if ($oddProviderId) {
                $outcomes = $outcomes[$oddProviderId];
            }

            $response = [
                'betting_offer' => $oddProviderId ? get_betting_offer($oddProviderId, $bettingOffers) : null,
                'id' => (int)$vote->id,
                'statistics' => $vote->statistics,
                'question' => (string)$vote->question_translated,
                'label' => mobile_outcome_type($vote->outcome_type_id . '.label'),
                'betting_labels' => $this->getBettingLabelsExtended($item, $vote->outcome_type_id),
                'betting_labels_extended' => \ConstEnetOutcomeType::_3Way == $vote->outcome_type_id
                    ? mobile_outcome_type($vote->outcome_type_id . '.vote_betting_labels')
                    : null,
                'odds' => $this->getOdds($outcomes, $vote->outcome_type_id, $oddProviderId)
            ];

            return $response;
        })->toArray();
    }

    protected function getBettingLabelsExtended($event, $outcomeTypeId)
    {
        if ($outcomeTypeId == \ConstEnetOutcomeType::_3Way) {
            $keys = array_keys(mobile_outcome_type($outcomeTypeId . '.vote_betting_labels'));

            return array_combine(
                $keys,
                [
                    $event->home_team->name ?? mobile_outcome_type($outcomeTypeId . '.vote_betting_labels.win_1'),
                    mobile_outcome_sub_type(\ConstEnetOutcomeSubType::Draw . '.short'),
                    $event->away_team->name ?? mobile_outcome_type($outcomeTypeId . '.vote_betting_labels.draw'),
                ]
            );
        }


        return mobile_outcome_type($outcomeTypeId . '.vote_betting_labels');
    }

    /**
     * @param $items
     * @param $outcomeTypeId
     * @return array
     */
    public function getOdds($items, $outcomeTypeId, $oddProviderId)
    {
        if (!empty($this->config['odds']['3_way'][$outcomeTypeId])) {
            list($singleOutcomeSubType, $bothOutcomeSubType) = $this->config['odds']['3_way'][$outcomeTypeId];

            $winPreOdds = $items->where('outcome_subtype_id', $singleOutcomeSubType);
            $homePreOdd = $winPreOdds->where('iparam', $this->homeParticipantId)->first();
            $awayPreOdd = $winPreOdds->where('iparam', $this->awayParticipantId)->first();
            $bothPreOdd = $items->where('outcome_subtype_id', $bothOutcomeSubType)->first();

            return [
                $this->getBettingOfferByProvider($homePreOdd, $oddProviderId),
                $this->getBettingOfferByProvider($bothPreOdd, $oddProviderId),
                $this->getBettingOfferByProvider($awayPreOdd, $oddProviderId),
            ];
        }

        if (in_array($outcomeTypeId, $this->config['odds']['team_2_way'])) {
            $homePreOdd = $items->where('iparam', $this->homeParticipantId)->first();
            $awayPreOdd = $items->where('iparam', $this->awayParticipantId)->first();
            return [
                $this->getBettingOfferByProvider($homePreOdd, $oddProviderId),
                $this->getBettingOfferByProvider($awayPreOdd, $oddProviderId)
            ];
        }

        $twoWaysOutcomes = $this->config['odds']['2_way'];
        if (!empty($twoWaysOutcomes[$outcomeTypeId])) {
            list($firstOutcomeSubType, $secondOutcomeSubType) = $twoWaysOutcomes[$outcomeTypeId];
            $firstPreOdds = $items->where('outcome_subtype_id', $firstOutcomeSubType)->first();
            $secondPreOdds = $items->where('outcome_subtype_id', $secondOutcomeSubType)->first();

            return [
                $this->getBettingOfferByProvider($firstPreOdds, $oddProviderId),
                $this->getBettingOfferByProvider($secondPreOdds, $oddProviderId),
            ];
        }

        if (in_array($outcomeTypeId, $this->config['odds']['1_way'])) {
            return [$this->getBettingOfferByProvider($items->first()),];
        }
        return [];
    }

    /**
     * @param $items
     * @return mixed
     */
    public function transformEventHeadToHead($items)
    {
        return $items->map(function ($model) {
            return $this->transformEventWith3WayOffers($model, false);
        })->toArray();
    }


    protected function getScore($event, $eventParticipant)
    {
        if (\ConstEnetStatusType::NotStarted == $event->status_type) {
            return '-';
        }

        if (\ConstEnetStatusType::Inprogress == $event->status_type) {
            return $eventParticipant->running_score_result->value ?? 0;
        }

        if (\ConstEnetStatusType::Finished == $event->status_type) {
            return $eventParticipant->running_score_result->value ?? 0;
        }

        return '-';
    }


    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     * @throws \Exception
     */
    public function toArray($model, ? Request $request = null)
    {
        $authId = Auth::guard('api')->id();
        $response['id'] = $model->id;
        $response['status_type'] = $model->status_type;
        $response['status_type_label'] = mobile_status_type($model->status_type);
        $response['status_description'] = mobile_status_description($model->status_description_id);

        $response['status_description_id'] = $model->status_description_id;
        $response['league'] = $model->tournament_stage_name;
        $response['game_time'] = $model->elapsed_time_short;
        $response['is_favorite'] = $authId
            ? \DB::table('user_favorite_enet_event')->where('user_id', $authId)->where('event_id', $model->id)->exists()
            : false;

        $response['start_date'] = $model->start_date_timezone->toDateTimeString();
        $response['home_name'] = $model->home_name;
        $response['away_name'] = $model->away_name;
        $response['home_id'] = $model->first_participant_id;
        $response['away_id'] = $model->second_participant_id;

        $response['home_score'] = $this->getScore($model, $model->event_home_participant);
        $response['away_score'] = $this->getScore($model, $model->event_away_participant);
        $response['home_image_url'] = $model->home_image_url;
        $response['away_image_url'] = $model->away_image_url;

        return $response;
    }


    /**
     * @param EnetEvent $event
     * @return array
     * @throws \ReflectionException
     */
    protected function transformGetEventResults(EnetEvent $event)
    {
        $resultTypes = get_class_constants(\ConstEnetResultType::class);
        $results = [];
        foreach ($resultTypes as $id => $value) {
            $value = Str::slug($value, '_');
            $homeResult = $event->home_team_results->where('result_type_id', $id)->first();
            $awayResult = $event->away_team_results->where('result_type_id', $id)->first();
            if ($homeResult || $awayResult) {
                $results[$value] = [
                    'home' => $homeResult->value ?? '-',
                    'away' => $awayResult->value ?? '-',
                ];
            }
        }
        return $results;
    }

    protected function ge3WayMaxOffers($items)
    {
        [$singleOutcomeSubType, $bothOutcomeSubType] = $this->config['odds']['3_way'][\ConstEnetOutcomeType::_3Way];
        $winPreOdds = $items->where('outcome_subtype_id', $singleOutcomeSubType);
        $homePreOdd = $winPreOdds->where('iparam', $this->homeParticipantId)->first();
        $awayPreOdd = $winPreOdds->where('iparam', $this->awayParticipantId)->first();
        $bothPreOdd = $items->where('outcome_subtype_id', $bothOutcomeSubType)->first();
        $labels = mobile_outcome_type(\ConstEnetOutcomeType::_3Way . '.betting_labels');
        $cols = ['id', 'odds', 'outcome_id'];
        $home = $this->getMaxBettingOffer($homePreOdd, $cols);
        $away = $this->getMaxBettingOffer($awayPreOdd, $cols);
        $both = $this->getMaxBettingOffer($bothPreOdd, $cols);

        return [
            ($home ? array_merge(['label' => $labels[0]], $home) : null),
            ($both ? array_merge(['label' => $labels[1]], $both) : null),
            ($away ? array_merge(['label' => $labels[2]], $away) : null),
        ];
    }

    /**
     * @param $preoddsOffer
     * @param array $cols
     * @param bool $detailed
     * @return |null
     */
    protected function formatBettingOffer($preoddsOffer, $cols = ['id', 'outcome_id', 'odds', 'odds_old', 'is_active'], $detailed = true)
    {
        if (empty($preoddsOffer)) {
            return null;
        }

        $bettingOffers = $this->getBettingOffers();
        $response = $preoddsOffer->only($cols);

        if ($detailed) {
            if (in_array('odds', $cols) && isset($response['odds'])) {
                $response['odds_fraction'] = float2fraction($response['odds']);
            }
            if (in_array('odds_old', $cols) && isset($response['odds_old'])) {
                $response['odds_old_fraction'] = float2fraction($response['odds_old']);
            }

            $response['betting_offer'] = get_betting_offer($preoddsOffer->odds_provider_id, $bettingOffers);
        }

        return $response;
    }

    /**
     * @param $items
     * @param $outcomeTypeId
     * @return array
     */
    public function getEventBookmakersByOutcomeType($items, $outcomeTypeId)
    {
        $groupedItems = $items->groupBy('betting_offers.*.odds_provider_id');
        $response = [];

        foreach ($groupedItems as $bettingOfferId => $items) {
            $response[] = [
                'betting_offer' => get_betting_offer($bettingOfferId),
                'odds' => $this->transformOdds($items, $outcomeTypeId, $bettingOfferId)
            ];
        }

        $maxOdds = [];
        foreach ($response as $data) {
            foreach ($data['odds'] as $index => $values) {
                $maxOdds[$index] = $maxOdds[$index] ?? 0;
                if ($values['odds'] > $maxOdds[$index]) {
                    $maxOdds[$index] = $values['odds'];
                }
            }
        }

        return [
            'max_odds' => $maxOdds,
            'data' => $response
        ];
    }

    /**
     * @param $items
     * @param $outcomeTypeId
     * @return array
     */
    public function getMaxOfferByOutcomeType($items, $outcomeTypeId)
    {
        $treeWaysOutcomes = $this->config['odds']['3_way'];
        if (!empty($this->config['odds']['3_way'][$outcomeTypeId])) {
            return $this->get3WaysMaxData($items, ...$treeWaysOutcomes[$outcomeTypeId]);
        }

        if (in_array($outcomeTypeId, $this->config['odds']['team_2_way'])) {
            return $this->getTeam2WaysMaxData($items);
        }

        $twoWaysOutcomes = $this->config['odds']['2_way'];
        if (!empty($twoWaysOutcomes[$outcomeTypeId])) {
            return $this->get2WaysMaxData($items, ...$twoWaysOutcomes[$outcomeTypeId]);
        }

        if (in_array($outcomeTypeId, $this->config['odds']['1_way'])) {
            return [$this->getMaxBettingOffer($items->first()),];
        }
        return [];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $singleOutcomeSubType
     * @param $bothOutcomeSubType
     * @return array
     */
    protected function get3WaysMaxData($items, $singleOutcomeSubType, $bothOutcomeSubType)
    {
        $winPreOdds = $items->where('outcome_subtype_id', $singleOutcomeSubType);
        $homePreOdd = $winPreOdds->where('iparam', $this->homeParticipantId)->first();
        $awayPreOdd = $winPreOdds->where('iparam', $this->awayParticipantId)->first();
        $bothPreOdd = $items->where('outcome_subtype_id', $bothOutcomeSubType)->first();

        return [
            $this->getMaxBettingOffer($homePreOdd),
            $this->getMaxBettingOffer($bothPreOdd),
            $this->getMaxBettingOffer($awayPreOdd),
        ];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $singleOutcomeSubType
     * @param $bothOutcomeSubType
     * @return array
     */
    protected function getTeam2WaysMaxData($items)
    {
        $homePreOdd = $items->where('iparam', $this->homeParticipantId)->first();
        $awayPreOdd = $items->where('iparam', $this->awayParticipantId)->first();
        return [
            $this->getMaxBettingOffer($homePreOdd),
            $this->getMaxBettingOffer($awayPreOdd)
        ];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $firstOutcomeSubType
     * @param $secondOutcomeSubType
     * @return array
     */
    protected function get2WaysMaxData($items, $firstOutcomeSubType, $secondOutcomeSubType)
    {
        $firstPreOdds = $items->where('outcome_subtype_id', $firstOutcomeSubType)->first();
        $secondPreOdds = $items->where('outcome_subtype_id', $secondOutcomeSubType)->first();

        return [
            $this->getMaxBettingOffer($firstPreOdds),
            $this->getMaxBettingOffer($secondPreOdds),
        ];
    }

    protected function getMaxBettingOffer($item, $cols = ['id', 'outcome_id', 'odds', 'odds_old', 'is_active'])
    {
        return $item
            ? $this->formatBettingOffer($item->betting_offers->sortByDesc('odds')->first(), $cols)
            : null;
    }

    protected function getBettingOfferByProvider($item, $oddProviderId, $cols = ['id', 'outcome_id', 'odds',])
    {
        return $item
            ? $this->formatBettingOffer($item->betting_offers->where('odds_provider_id', $oddProviderId)->first(), $cols, false)
            : null;
    }

    protected function transformOdds($items, $outcomeTypeId, $bettingOfferId)
    {
        $treeWaysOutcomes = $this->config['odds']['3_way'];
        if (!empty($this->config['odds']['3_way'][$outcomeTypeId])) {
            return $this->get3WaysData($items, $bettingOfferId, ...$treeWaysOutcomes[$outcomeTypeId]);
        }

        if (in_array($outcomeTypeId, $this->config['odds']['team_2_way'])) {
            return $this->getTeam2WaysData($items, $bettingOfferId);
        }

        $twoWaysOutcomes = $this->config['odds']['2_way'];
        if (!empty($twoWaysOutcomes[$outcomeTypeId])) {
            return $this->get2WaysData($items, $bettingOfferId, ...$twoWaysOutcomes[$outcomeTypeId]);
        }

        if (in_array($outcomeTypeId, $this->config['odds']['1_way'])) {
            return [$this->transformOffers($items->first(), $bettingOfferId),];
        }

        return [];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $singleOutcomeSubType
     * @param $bothOutcomeSubType
     * @return array
     */
    protected function get3WaysData($items, $bettingOfferId, $singleOutcomeSubType, $bothOutcomeSubType)
    {
        $winPreOdds = $items->where('outcome_subtype_id', $singleOutcomeSubType);
        $homePreOdd = $winPreOdds->where('iparam', $this->homeParticipantId)->first();
        $awayPreOdd = $winPreOdds->where('iparam', $this->awayParticipantId)->first();
        $bothPreOdd = $items->where('outcome_subtype_id', $bothOutcomeSubType)->first();

        return [
            $this->transformOffers($homePreOdd, $bettingOfferId),
            $this->transformOffers($bothPreOdd, $bettingOfferId),
            $this->transformOffers($awayPreOdd, $bettingOfferId),
        ];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $singleOutcomeSubType
     * @param $bothOutcomeSubType
     * @return array
     */
    protected function getTeam2WaysData($items, $bettingOfferId)
    {
        $homePreOdd = $items->where('iparam', $this->homeParticipantId)->first();
        $awayPreOdd = $items->where('iparam', $this->awayParticipantId)->first();
        return [
            $this->transformOffers($homePreOdd, $bettingOfferId),
            $this->transformOffers($awayPreOdd, $bettingOfferId),
        ];
    }

    /**
     * @param $items
     * @param $bettingOfferId
     * @param $firstOutcomeSubType
     * @param $secondOutcomeSubType
     * @return array
     */
    protected function get2WaysData($items, $bettingOfferId, $firstOutcomeSubType, $secondOutcomeSubType)
    {
        $firstPreOdds = $items->where('outcome_subtype_id', $firstOutcomeSubType)->first();
        $secondPreOdds = $items->where('outcome_subtype_id', $secondOutcomeSubType)->first();

        return [
            $this->transformOffers($firstPreOdds, $bettingOfferId),
            $this->transformOffers($secondPreOdds, $bettingOfferId),
        ];
    }

    protected function transformOffers($item, $bettingOfferId)
    {
        if ($item) {
            $offer = $item->betting_offers->where('odds_provider_id', $bettingOfferId)->first();
            $data = $offer->only('id', 'object_id', 'odds', 'odds_old', 'is_active');
            if (isset($data['odds'])) {
                $data['odds_fraction'] = float2fraction($data['odds']);
            }
            if (isset($data['odds_old'])) {
                $data['odds_old_fraction'] = float2fraction($data['odds_old']);
            }
            $data['outcome_id'] = $offer->object_id;
            return $data;
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    protected function getBettingOffers()
    {
        if ($this->bettingOffers) {
            return $this->bettingOffers;
        }

        return $this->bettingOffers = CachedItems::oddsProviders();
    }

    public function transformEventTeamStandings(EnetEvent $event)
    {
        return [
            'home_team' => $this->getEventParticipantStatistics($event->event_home_participant, $event),
            'away_team' => $this->getEventParticipantStatistics($event->event_away_participant, $event),
        ];
    }

    protected function getEventParticipantStatistics($eventParticipant, $event)
    {
        if (empty($eventParticipant)) {
            return [];
        }

        $standings = $event->standings;
        if ($standings->isEmpty()) {
            return [];
        }

        $standingParticipants = $event->standings->pluck('standing_participants')->flatten();
        if ($standingParticipants->isEmpty()) {
            return [];
        }

        return $this->getTeamStatistics($eventParticipant, $standingParticipants);
    }

    protected function transformEventParticipantStandings(EnetEvent $event)
    {
        return [
            'home_team' => $this->getTeamWithStatistics($event->event_home_participant, $event),
            'away_team' => $this->getTeamWithStatistics($event->event_away_participant, $event),
        ];
    }

    protected function getTeamWithStatistics($eventParticipant, $event)
    {
        if (empty($eventParticipant)) {
            return [];
        }

        return $this->getPlayers($eventParticipant->lineups, $event);
    }

    /**
     * @param $eventParticipant
     * @param $standingParticipants
     * @return array
     */
    protected function getTeamStatistics($eventParticipant, $standingParticipants)
    {
        $teamStatistics = $standingParticipants->whereIn('participant_id', $eventParticipant->participant_id);
        $teamResponse = $this->processStatistics($teamStatistics);
        $participantResponse = $this->getParticipantStatistics($eventParticipant, $standingParticipants);
        $response = array_merge($teamResponse, $participantResponse);

        if ('extended' == request('tag')) {
            $codes = CachedItems::activeStandingTypeParameters()->pluck('code')->all();
            return collect($response)->sortKeysByArray($codes)->all();
        }

        return collect($response)->sortKeysByArray(config('api_config.ordered_team_statistic_codes'))->all();
    }

    /**
     * @param $eventParticipant
     * @param $standingParticipants
     * @return array
     */
    protected function getParticipantStatistics($eventParticipant, $standingParticipants)
    {
        $lineups = $eventParticipant->lineups;

        if (empty($lineups)) {
            return [];
        }
        $participantIds = $lineups->pluck('participant_id');
        $participantStatistics = $standingParticipants->whereIn('participant_id', $participantIds);
        return $this->processStatistics($participantStatistics);
    }

    /**
     * @param $statistics
     * @return array
     */
    protected function processStatistics($statistics)
    {
        if ($statistics->isEmpty()) {
            return [];
        }

        $standingData = $statistics->pluck('standing_data')->collapse();
        if (empty($standingData) || $standingData->isEmpty()) {
            return [];
        }

        if ('extended' == request('tag')) {
            $codes = CachedItems::activeStandingTypeParameters()->pluck('code');
        } else {
            $codes = config('api_config.ordered_team_statistic_codes');
        }
        $response = [];
        foreach ($codes as $code) {
            if ($standingData->where('code', $code)->count()) {
                $response[$code] = $standingData->where('code', $code)->sum('value');
            }
        }

        return $response;
    }

    /**
     * @param $lineups
     * @param $event
     * @return mixed
     */
    protected function getPlayers($lineups, $event)
    {
        if (empty($lineups)) {
            return [];
        }
        return $lineups->sortBy('lineup_type_id')->groupBy(function ($item) {
            return $item->lineup_type_id;
        })->map(function ($items) use ($event) {
            return [
                'lineup_type_id' => $items->first()->lineup_type_id,
                'lineup' => mobile_lineup_type($items->first()->lineup_type_id),
                'participants' => $items->map(function ($item) use ($event) {
                    return [
                        'shirt_number' => $item->shirt_number,
                        'pos' => $item->pos,
                        'name' => $item->participant->name_translated ?? __mobile('unknown-player'),
                        'flag_url' => $item->participant->country->image_url ?? (new EnetCountry())->getDefaultUploadUrl('image_disk'),
                        'statistics' => $this->getPlayerStatistics($item->participant_id, $event),
                    ];
                })
            ];
        })->values();
    }

    /**
     * @param $participantId
     * @param $event
     * @return array
     */
    protected function getPlayerStatistics($participantId, $event)
    {
        $standing = $event->standing;
        if (empty($standing)) {
            return [];
        }

        $standingParticipants = $standing->standing_participants;
        if (empty($standingParticipants) || $standingParticipants->isEmpty()) {
            return [];
        }

        $participantStatistic = $standingParticipants->where('participant_id', $participantId)->first();
        if (empty($participantStatistic)) {
            return [];
        }

        $standingData = $participantStatistic->standing_data;
        if (empty($standingData) || $standingData->isEmpty()) {
            return [];
        }
        return $standingData->map(function ($item) {
            return $item->only('value', 'code');
        });
    }
}
