<?php

namespace  Api\V1\Http\Controllers;

use Api\V1\Services\AuthUserService;
use Api\V1\Transformers\AuthUserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use LaraAreaApi\Http\Controllers\BaseAuthController;

/**
 * Class AuthController
 * @package App\Http\Controllers\API
 */
class AuthUserController extends BaseAuthController
{
    /**
     * @var AuthUserService
     */
    protected $service;

    /**
     * @var AuthUserTransformer
     */
    protected $transformer;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function activate(Request $request)
    {
        $user = $this->service->activate($request->all());
        $userData = $this->transformer->transform($user, $request);
        return $this->response->success($userData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthNotificationToken(Request $request)
    {
        $this->service->validate($request->all(), [
            'one_token' => 'required_without_all:ios_one_token,android_one_token',
            'ios_one_token' => 'required_without_all:one_token,android_one_token',
            'android_one_token' => 'required_without_all:one_token,ios_one_token'
        ]);
        return $this->updateAuth($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function appleLogin(Request $request)
    {
        [$user, $tokens] = $this->service->appleLogin($request->all());
        $userData = $this->transformer->transform($user, $request);

        return $this->response->success(['user' => $userData, 'tokens' => $tokens]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthPassword(Request $request)
    {
        $this->service->validate($request->all(), [
            'current_password' => 'required:password|string|min:8',
            'password' => ['required:current_password', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required_with:password', 'string', 'min:8'],
        ]);
        return parent::updateAuthPassword($request);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthFeedbackRating(Request $request)
    {
        $this->service->validate($request->all(), ['feedback_rating' => ['required', 'numeric', 'between:0,5']]);
        return $this->updateAuth($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthNotificationSettings(Request $request)
    {
        $this->service->validate($request->all(), [
            'noti_sys' => 'required',
            'noti_user_tip' => 'required',
            'noti_tip_ended' => 'required',
            'noti_live' => 'required',
//            'follow' => 'required',
        ]);
        return $this->updateAuth($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthEmailSettings(Request $request)
    {
        $this->service->validate($request->all(), [
            'email_news_product_update' => 'required',
            'email_news_tipya_partner' => 'required',
            'email_suggestions_recommended_accounts' => 'required',
            'email_research_surveys' => 'required',
            'email_missed_since_login' => 'required',
            'email_top_tips_matches' => 'required',
            'email_offers' => 'required',
            'email_new_follower' => 'required',
            'email_new_notification' => 'required',
            'email_tip_ended' => 'required',
        ]);
        return $this->updateAuth($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthProfileSettings(Request $request)
    {
        return $this->updateAuth($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAuthProfilePicture(Request $request)
    {
        $this->service->validate($request->all(), [
            'avatar' => [
                'required',
                'mimes:' . implode(',', app_config('profile_extensions')),
                'max:' . app_config('profile_max_size')
            ]
        ]);
        
        return $this->updateAuth($request);
    }

    /**
     * @param $settingId
     * @return array
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function updateSetting($settingId)
    {
        return $this->service->updateSetting($settingId);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateManySettings(Request $request)
    {
        $this->service->validate($request->all(), [
            'ids' => [
                'required',
                'bail',
                'array',
                function ($attribute, $value, $fails) {
                    $ids = array_keys(Arr::wrap($value));
                    $allNotificationSettings = \Cache::remember('notification_settings', 24 * 60 * 60, function () {
                        return \Api\V1\Models\NotificationSetting::whereNull('parent_id')
                            ->where('is_active', \ConstYesNo::YES)
                            ->with('translations')
                            ->get();
                    });
                    if (count($ids) != $allNotificationSettings->whereIn('id', $ids)->count()) {
//                        return $fails('Latest one notification setting is not correct'); // TODO
                    }

                    return true;
                }
            ]
        ]);
        $this->service->updateManySettings($request->ids);
        $response = $this->transformer->transform($this->getAuth());
        return $this->response->success($response);
    }


//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function logout(Request $request)
//    {
////        $request->user()->token()->revoke();
////        return response()->json([
////            'message' => 'Successfully logged out'
////        ]);
//    }
//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function autologin(Request $request)
//    {
////        $request->validate([
////            'token' => 'required|string',
////        ]);
////
////        $a = Autologin::where('token', $request->token)->firstOrFail();
////        $a->used++;
////        $a->save();
////
////        $tokenResult = $a->user->createToken('Personal Access Token');
////        $token = $tokenResult->token;
////        $token->expires_at = Carbon::now()->addDays(30);
////        $token->save();
////
////        return response()->json([
////            'access_token' => $tokenResult->accessToken,
////            'token_type' => 'Bearer',
////            'expires_at' => Carbon::parse(
////                $tokenResult->token->expires_at
////            )->toDateTimeString(),
////            'redirect' => $a->redirect,
////        ]);
//    }

}
