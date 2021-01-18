<?php

namespace Api\V1\Transformers;

use App\Facades\AppCache;
use Illuminate\Http\Request;

class UserTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $userStatistic = $model->user_tip_statistics->first();
        $response = [
            'id' => (integer) $model->id,
            'name' => (string) $model->name,
            'email' => (string) $model->email,
            'profile_url' => $model->profile_url,
            'profit' => number_format($userStatistic->profit ?? 0),
            'percent' => round($userStatistic->win_percent ?? 0),
            'bio' => (string) $model->bio,
            'followers_count' => (int) $model->followers_count,
            'following_count' => (int) $model->followings_count,
            'follow_status' => AppCache::isFollow($model),
        ];

        return $response;
    }

    /**
     * @param $model
     * @return array
     */
    public function toCollection($request, Model $model)
    {
        $statistic =  $model->user_tip_statistics->first();
        return [
            'id' => $model->id,
            'name' => $model->name,
            'profile_url' => $model->profile_url,
            'profit' => number_format($statistic->profit ?? 0),
            'percent' => round($statistic->win_percent  ?? 0),
            'placed_tip_count' => $statistic->win_count + $statistic->lost_count,
            'loses_count' => $statistic->lost_count ?? 0,
        ];
    }

    /**
     * @param $statistic
     * @param Request $request
     * @return array
     */
    public function transformRank($statistic, Request $request)
    {
        $model = $statistic->user;
        return [
            'id' => $model->id,
            'name' => $model->name,
            'profile_url' => $model->profile_url,
            'profit' => number_format($statistic->profit ?? 0),
            'percent' => round($statistic->win_percent  ?? 0),
            'placed_tip_count' => $statistic->win_count + $statistic->lost_count,
            'loses_count' => $statistic->lost_count ?? 0,
            'position' => $statistic->user_profit_position,
            'follow_status' => AppCache::isFollow($model),
            'user_tips_count' => $this->when($model->hasAttribute('user_tips_count'), $model->user_tips_count)
        ];
    }


    /**
     * @param $model
     * @param Request $request
     * @return array
     */
    public function transformSuggest($model, Request $request)
    {
        return [
            'id' => (int) $model->id,
            'name' => (string) $model->name,
            'profile_url' =>(string) $model->profile_url,
            'follow_status' => AppCache::isFollow($model),
        ];
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return array
     */
    public function transformReactedUser($model, ? Request $request = null)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'follow_status' => AppCache::isFollow($model),
        ];
    }
}
