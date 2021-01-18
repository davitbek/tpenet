<?php

namespace Api\V1\Transformers\Enet;

use Illuminate\Http\Request;

class EnetEventStatisticTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        return [
            'id' => (integer) $model->id,
            'enet_id' => (integer) $model->enet_id,
            'standing_id' => (integer) $model->standing_id,
            'rank' => (integer) $model->rank,
            'points' => (integer) $model->points,
            'name' => (string) $model->name,
            'first_name' => (string) $model->first_name,
            'last_name' => (string) $model->last_name,
        ];
    }
}
