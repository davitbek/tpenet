<?php

namespace Api\V1\Transformers;

use Api\V1\Transformers\Enet\EnetOddsProviderTransformer;
use Illuminate\Http\Request;

class AffiliateMediaTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $response =  [
            'id' => (int) $model->id,
            'is_mobile' => (bool) $model->is_mobile,
            'category' => (string) $model->category,
            'product' => (string) $model->product,
            'title' => (string) $model->title,
            'description' => (string) $model->description,
            'link' => (string) $model->link,
            'image_url' => (string) $model->image_url,
            'terms_and_conditions' => (string) $model->terms_and_conditions,
        ];

        if ($model->relationLoaded('odds_provider')) {
            $response['bookmaker'] = (string) $model->odds_provider_name;
            $response['affiliate'] = $model->odds_provider->toArray();
        }

        return $response;
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function transformAds($model, ? Request $request = null)
    {
        return  [
            'image_url' => (string) $model->image_url,
        ];
    }
}
