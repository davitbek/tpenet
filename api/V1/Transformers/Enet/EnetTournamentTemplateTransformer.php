<?php

namespace Api\V1\Transformers\Enet;

use Illuminate\Http\Request;

class EnetTournamentTemplateTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $response = [
            'id' => (integer) $model->id,
            'name' => (string) $model->name,
            'gender' => (string) $model->gender,
            'readable_id' => (string) $model->readable_id,
            'sport' => $this->when($model->relationLoaded('sport'), (array) (new EnetSportTransformer())->transform($model->sport)),
        ];

        return $response;
    }
}
