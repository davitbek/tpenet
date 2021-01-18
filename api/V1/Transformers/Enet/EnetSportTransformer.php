<?php

namespace Api\V1\Transformers\Enet;

use Illuminate\Http\Request;

class EnetSportTransformer extends BaseTransformer
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
            'icon_url' => $model->icon_url,
            'discover_url' => $model->discover_url,
            'sport_key' => $model->readable_id,
            'description' => $model->is_mobile ? 'active' : 'Coming soon'
        ];

        return $response;
    }
}
