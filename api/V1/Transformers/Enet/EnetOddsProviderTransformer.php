<?php

namespace Api\V1\Transformers\Enet;

use Api\V1\Models\Enet\EnetOddsProvider;
use Api\V1\Transformers\AffiliateMediaTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnetOddsProviderTransformer extends BaseTransformer
{
    protected $language;

    /**
     *
     */
    public function initialize()
    {
        $user = Auth::guard('api')->user();
        $this->language = $user->lang ?? \App::getLocale();
        parent::initialize();
    }

    /**
     * @param $model EnetOddsProvider
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $model->translate(true, $this->language);
        $response =  [
            'id' => $model->id,
            'rating' => $model->rating,
            'brand' => $model->brand,
            'slug' => $model->slug,
            'promo_code' => $model->promo_code,
            'related_url_mobile' => $model->related_url_mobile,
            'image_url' => $model->image_url,
            'related_url' => $model->related_url_translated,
            'short_description' => $model->short_description_translated,
            'text' => $model->text_translated,
            'created_at' => $model->created_at->toDateTimeString(),
        ];

        if ($model->relationLoaded('affiliates_media')) {
            $response['bookmaker_offers'] = (new AffiliateMediaTransformer())->transform($model->affiliates_media);
        }

        return $response;
    }
}
