<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Models\User;
use Api\V1\Services\FollowService;
use Illuminate\Http\Request;

class FollowController extends BaseController
{
    /**
     * @var FollowService
     */
    public $service;

    /**
     * @param Request $request
     * @param $followingId
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function followUnFollow(Request $request, $followingId)
    {
        $result = $this->service->followUnFollow($followingId);
        $response = $this->transformer->transform($result, $request);
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function followers(Request $request, $userId)
    {
        $search = $request->search;
        $authId = $this->getAuthId();
        $users = User::orderBy('tip_win_percent', 'desc')
            ->select(['id', 'name', 'profile_disk', 'profile_path', 'tip_win_percent', 'tip_profit'])
            ->when(
                $authId,
                function ($q) use ($authId) {
                    $q->selectRaw('exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $authId .') as is_follow');
                },
                function ($q) {
                    $q->selectRaw('0 as is_follow');
                }
            )
            ->whereHas('followings', function ($q) use ($userId) {
                $q->where('following_user_id', $userId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search. '%');
            })
            ->withCount([
                'followers' => function ($q) use ($userId) {
                    $q->where('follower_user_id', $this->getAuthId());
                },
            ])->paginate();

        $response = $this->transformer->transform($users, $request, 'transformFollowers');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function followings(Request $request, $userId)
    {
        $search = $request->search;
        $authId = $this->getAuthId();
        $users = User::orderBy('tip_win_percent')
            ->select(['id', 'name', 'profile_disk', 'profile_path', 'tip_win_percent', 'tip_profit'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search. '%');
            })
            ->when(
                $authId,
                function ($q) use ($authId) {
                    $q->selectRaw('exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $authId .') as is_follow');
                },
                function ($q) {
                    $q->selectRaw('0 as is_follow');
                }
            )
            ->whereHas('followers', function ($q) use ($userId) {
                $q->where('follower_user_id', $userId);
            })
            ->when($userId != $this->getAuthId(), function ($q) use ($userId) {
                $q->withCount([
                    'followers' => function ($q) use ($userId) {
                        $q->where('follower_user_id', $this->getAuthId());
                    },
                ]);
            })
            ->paginate();

        $response = $this->transformer->transform($users, $request, 'transformFollowings');
        return $this->response->success($response);
    }
}
