<?php

namespace Api\V1\Transformers\Enet;

use Illuminate\Http\Request;

class EnetCountryTransformer extends BaseTransformer
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
            'readable_id' => (string) $model->readable_id,
        ];

        return $response;
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return array
     */
    public function transformDetailed($model, ? Request $request = null)
    {
        $languages = $model->languages ?? [];
        $languages = array_intersect(array_keys(languages_list()), $languages);
        $languages = array_values($languages);

        return [
            'id' => $model->id,
            'iso2' => (string) $model->iso2,
            'country' => (string) $model->country,
            'image_url' => (string) $model->image_url,
            'odds_type' => (integer) $model->odds_type,
            'timezone' => (string) $model->timezone,
            'timezones' => (array) $model->timezones,
            'language' => (string) $model->language,
            'href_language' => (string) $model->href_language,
            'languages' => $languages,
            'currency' => (string) $model->currency,
            'currencies' => (array) $model->currencies,
        ];
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return array
     */
    public function transformSimple($model, ? Request $request = null)
    {
        return [
            'id' => $model->id,
            'iso2' => (string) $model->iso2,
            'country' => (string) $model->country,
            'image_url' => (string) $model->image_url,
            'odds_type' => (integer) $model->odds_type,
            'timezone' => (string) $model->timezone,
            'language' => (string) $model->language,
            'href_language' => (string) $model->href_language,
            'currency' => (string) $model->currency,
        ];
    }
}
