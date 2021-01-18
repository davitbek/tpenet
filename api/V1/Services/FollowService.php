<?php

namespace Api\V1\Services;

use Api\V1\Models\User;
use App\Notifications\SendFollow;
use LaraAreaApi\Exceptions\ApiException;

class FollowService extends BaseService
{
    /**
     * @param $followingId
     * @return array|\Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function followUnFollow($followingId)
    {
        $followerId = $this->getAuthUserId();
        if ($followerId == $followingId) {
            throw new ApiException(\ConstErrorCodes::INCORRECT_FOLLOWER, mobile_validation('not_follow_yourself'));
        }

        $follow = $this->model->where([
            'follower_user_id' => $followerId,
            'following_user_id' => $followingId,
        ])->first();

        if ($follow) {
            $follow->delete();
            return ['is_follow' => false];
        }
        $follow = $this->model->create([
            'following_user_id' => $followingId,
            'follower_user_id' => $followerId,
            'date' => now()
        ]);
        $followingUser = User::with('notification_settings:user_id,ios_one_token,android_one_token,follow')->find($followingId, ['name', 'email', 'id', 'lang']);
        $user = \Auth::guard('api')->user();
        $followingUser->notify(new SendFollow($user));

        return ['is_follow' => true];
    }
}
