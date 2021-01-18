<?php

namespace Api\V1\Transformers\Enet;

use Api\V1\Models\Enet\EnetCountry;
use Api\V1\Models\Enet\EnetTournamentStage;
use App\Helpers\CachedItems;
use App\Models\Admin\Enet\RoundType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnetTournamentStageTransformer extends BaseTransformer
{
    /**
     * @param $model EnetTournamentStage
     * @param Request|null $request
     * @return mixed
     */
    public function transformId($model, ? Request $request = null)
    {
        return $model->id;
    }

    public function transformTableStandings($model)
    {
        if (empty($model)) {
            return [];
        }
        $configs = $model->standings->pluck('standing_configs')->collapse()->sortByValues(\ConstEnetTableStandingTypeParam::constants(), 'standing_type_param_id')->pluck('value', 'standing_type_param_id')->filter();
        $standingParticipants = $model->standings->pluck('standing_participants')->collapse();
        $isWeb = request('web');
        $counts = $standingParticipants->count();
        $data =  $standingParticipants->sortBy('rank')->map(function ($item) use ($isWeb, $configs, $counts) {
            $participant = $item->participant;
            if ($participant) {
                if ($participant->image_path) {
                    $imageUrl = $participant->image_url;
                }
                if (empty($imageUrl)) {
                    $country = get_cached_countries()->where('id', $participant->country_id)->first();
                    $imageUrl = $country->image_url ?? EnetCountry::defaultUploadUrl('image_path');
                }
            } else {
                $imageUrl = EnetCountry::defaultUploadUrl('image_path');
            }

            $color = '';
            foreach ($configs as $paramId => $value) {
                if ($paramId != \ConstEnetTableStandingTypeParam::RELEGATION && in_array($item->rank, explode(',', $value))) {
                    $color = __('statistics.table.championships.' . $paramId . '.color');
                } elseif ($paramId == \ConstEnetTableStandingTypeParam::RELEGATION && $counts - $item->rank < $value) {
                    $color = __('statistics.table.championships.' . $paramId . '.color');
                }
            }

            return [
                'rank' => $item->rank,
                'color' => $color,
                'participant_id' => $participant->id ?? '',
                'participant_type' => $participant->type ?? '',
                'participant' => $participant->name ?? '',
                'image_url' => $imageUrl,
                'played' => $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::GAMES_PLAYED),
                'won' => $this->when($isWeb, $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::WON)),
                'draw' => $this->when($isWeb, $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::DRAW)),
                'lost' => $this->when($isWeb, $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::LOST)),
                'goals_for' => $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::GOALS_FOR),
                'goals_against' => $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::GOALS_AGAINST),
                'points' => $this->getStandingData($item->standing_data, \ConstEnetStandingTypeParam::POINTS),
            ];
        })->values()->all();

        return [
            'data' => $data,
            'championships' => $configs->keys()->map(function($paramId) {
                return [
                    'color' => __('statistics.table.championships.' . $paramId . '.color'),
                    'name' => __('statistics.table.championships.' . $paramId . '.name'),
                ];
            })
        ];
    }

    protected function getStandingData($standingDatas, $standingTypeParamId)
    {
        return $standingDatas->where('standing_type_param_id', $standingTypeParamId)->first()->value ?? '-';
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return array|mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $columns = [
            'id',
            'sport_id',
            'name',
            'events_count',
            'live_events_count',
            'readable_id',
            'icon_url',
        ];

        $attributes = $model->toArray();
        $response = [];
        foreach ($columns as $column => $data) {
            if (is_numeric($column)) {
                $column = $data;
            }
            if (key_exists($column, $attributes)) {
                $response[$column] = $attributes[$column];
            }
        }

        $country = get_cached_countries()->where('id', $model->country_id)->first();
        $response['country'] = [
            'id' => $model->country_id,
            'name' => $model->country_id ? mobile_country($model->country_id) : 'International',
            'icon_url' => $country->image_url ?? EnetCountry::defaultUploadUrl('image_path'),
            'readable_id' => $country->readable_id ?? 'international',
        ];

//        if (key_exists('icon_url', $response) && empty($response['icon_url'])) {
//            $response['icon_url'] = $response['country']['icon_url'];
//        }
        $response['icon_url'] = $response['country']['icon_url'];

        return $response;
    }

    /**
     * @param $items
     * @param Request|null $request
     * @return array
     */
    public function transformLeaguesBySportCountry($items, ? Request $request = null)
    {
        $grouped = $items->sortBy('country_name')->groupBy('country_id');
        $response = [];
        foreach ($grouped as $countryId => $_items) {
            $country = get_cached_countries()->where('id', $countryId)->first();

            $response[] = [
                'country' => [
                    'name' => mobile_country($countryId),
                    'icon_url' => $country->image_url ?? get_country_image_url('international'),
                    'readable_id' => $country->readable_id ?? 'international',
                ],
                'leagues' => $_items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'readable_id' => $item->readable_id,
                    ];
                })
            ];
        }
        return $response;
    }

    /**
     * @param $items
     * @param Request|null $request
     * @return array
     */
    public function transformLeaguesBySportCountryForWeb($items, ? Request $request = null)
    {
        $grouped = $items->groupBy('country_id');
        $response = [];
        foreach ($grouped as $countryId => $_items) {
            $country = get_cached_countries()->where('id', $countryId)->first();
            $response[] = [
                'country' => [
                    'name' => mobile_country($countryId),
                    'icon_url' => $country->image_url ?? get_country_image_url('international'),
                    'readable_id' => $country->readable_id ?? 'international',
                ],
                'leagues' => $_items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->league_name,
                        'readable_id' => $item->readable_id,
                        'is_draw' => (bool) $item->is_draw,
                    ];
                })
            ];
        }
        return collect($response)->sortBy('country.name')->values();
    }

    public function transformDraw($model)
    {
        if (empty($model)) {
            return null;
        }

        return [
            'config' => $this->getDawConfig($model),
            'details' => $this->processDrawDetails($model->draw_events)
        ];
    }

    protected function getDawConfig($model)
    {
        $roundTypes = $model->draw_events->pluck('round_type')->pluck('name', 'id');
        $response = [];
        foreach ($model->draw_configs as $config) {
            if ('startRoundFK' == $config->name) {
                $response['start_round'] = $roundTypes[$config->value] ?? RoundType::where('id', $config->value)->value('id');
            } elseif ('endRoundFK' == $config->name) {
                $response['end_round'] = $roundTypes[$config->value] ?? RoundType::where('id', $config->value)->value('name');
            } else {
                $response[Str::snake($config->name)] = $config->value;
            }
        }
        return $response;
    }

    protected function processDrawDetails($drawEvents)
    {
        $response = [];

        foreach($drawEvents->groupBy('round_type.name')->sortKeysByArray(CachedItems::orderedRoundTypeName()->all()) as $typeName => $events) {
            $events = $events->sortBy('draw_order');
            $eventsData = [];
            foreach ($events->chunk(2) as $twoEvents) {
                $eventsData[] = $twoEvents->map(function ($event) {
                    return $event->draw_participants->map(function ($item) use ($event){
                        if (empty($item->participant)) {
                            return null;
                        }
                        return [
                            'id' => $item->participant->id,
                            'number' => $item->number,
                            'name' => $item->participant->name_translated,
                            'type' => $item->participant->type,
                            'image_url' => $item->participant->image_url,
                            'score' => $item->participant->id % 4 ? $item->participant->id % 7 : ''
                        ];
                    })->all();
                })->all();
            }
            $response[] = [
                'round' => $typeName,
                'data' => $eventsData,
            ];
        }

        return $response;
    }
}
