<?php

namespace Api\V1\Transformers;

use App\Facades\AppCache;
use Illuminate\Http\Request;

class FollowTransformer extends BaseTransformer
{
    /**
     * @param $item
     * @param Request $request
     * @return array|mixed
     */
    public function transformFollowers($item, Request $request)
    {
        return [
            'id' => $item->id,
            'name' => $item->name ?? 'deleted',
            'profile_url' => $item->profile_url ?? get_profile_white_url(),
            'percent' => round($item->tip_win_percent ?? 0),
            'profit' => number_format($item->tip_profit ?? 0),
            'follow_status' => AppCache::isFollow($item),
        ];
    }

    /**
     * @param $item
     * @param Request $request
     * @return array|mixed
     */
    public function transformFollowings($item, Request $request)
    {
        return [
            'id' => $item->id,
            'name' => $item->name ?? 'deleted',
            'profile_url' => $item->profile_url ?? get_profile_white_url(),
            'percent' => round($item->tip_win_percent ?? 0),
            'profit' => number_format($item->tip_profit ?? 0),
            'follow_status' => AppCache::isFollow($item),
        ];
    }
}
