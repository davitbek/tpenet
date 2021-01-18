<?php

namespace Api\V1\Services;

use Api\V1\Models\Information;

class InformationService extends BaseService
{
    /**
     * @param $uri
     * @param $url
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($uri)
    {
        if (empty($uri) && empty($url)) {
            return [];
        }

        //  $url = app('request')->path();
        $lang = get_auth_locale();
        $authId = \Auth::guard('api')->id();
        $information = Information::when($authId, function ($q) use ($authId) {
                $q->whereDoesntHave('users',  function ($query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->where(function ($q) use ($uri){
                $q->where('uri', $uri);
            })
            ->whereNull('parent_id')
            ->with([
                'translations' => function ($query) use ($lang) {
                    $query->select(['id', 'parent_id',  'headline', 'content'])
                        ->where(['lang' => $lang]);
                }
            ])->get();

        return $information;
    }
}
