<?php

namespace Api\V1\Services;

use Api\V1\Models\AuthUser;
use Api\V1\Models\SocialUser;
use Api\V1\Validators\AuthValidator;
use App\Jobs\User\ResizeProfile;
use App\Notifications\SendPasswordResetToken;
use App\Notifications\PasswordReseted;
use App\Notifications\Welcome;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LaraAreaApi\Events\AuthRegistered;
use LaraAreaApi\Events\SocialAuthLogin;
use LaraAreaApi\Exceptions\ApiException;
use LaraAreaApi\Services\ApiBaseAuthService;
use Illuminate\Http\UploadedFile;
use LaraAreaSupport\Arr;
use LaraAreaUpload\Traits\UploadProcessTrait;
use LaraAreaValidator\Exceptions\ValidationException;
use \Laravel\Socialite\Two\User as SocialiteTwoUser;

class AuthUserService extends ApiBaseAuthService
{
    use DispatchesJobs, UploadProcessTrait;

    /**
     * AuthUserService constructor.
     * @param null $model
     * @param AuthValidator|null $validator
     */
    public function __construct($model = null, AuthValidator $validator = null)
    {
        parent::__construct($model, $validator);
        $this->messages = __('mobile.validation');
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|\LaraAreaApi\Models\ApiAuth|\LaraAreaApi\Models\ApiModel
     * @throws ValidationException
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     */
    public function register($data)
    {
        if ( ! $this->validateRegister($data, false)) {
            $validationErrors = $this->getValidationErrorsErrors();
            if ($validationErrors->has('email') && $validationErrors->get('email') == ['The email has already been taken.']) {
                return $this->reRegisterUser($data);
            }

            throw new ValidationException(\ConstErrorCodes::VALIDATION, mobile_validation('error'), $this->validator, 422);
        }

        \DB::beginTransaction();
        $user = $this->_register($data);

        if (! empty($data[$this->queryParams['get_access_tokens']])) {
            $accessTokens = $this->getLoginTokens($data);
            $user->setAttribute('access_tokens', $accessTokens);
        }

        // TODO make user favorite teams or some logic
        $user->email_settings()->create();
        $user->notification_settings()->create();
        event(new AuthRegistered($user));
        \DB::commit();

        return $user;
    }

    /**
     * @param $data
     * @return mixed
     * @throws ValidationException
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     */
    protected function reRegisterUser($data)
    {
        $user = $this->model->where('email', $data[$this->queryParams['username']])->first();
        if (\ConstUserActivationStatus::ACTIVATED == $user->is_active) {
            throw new ValidationException(\ConstErrorCodes::EMAIL_ALREADY_USED, mobile_validation('email_already_used'), $this->validator, 422);
        }
        $permitted = [
            'feedback_rating',
            'odds_type',
            'timezone',
            'lang',
            'country',
            'country_id',
            'name',
            'email',
            'password',
            'remember_token',
            'password_reset_expires_at',
            'activation_token',
            'profile_disk',
            'profile_path',
            'phone',
            'bio',
            'Newsletter',
            'Promotions',
            'birthday',
        ];

        $updatedData = collect($data)->only($permitted)->all();
        if (key_exists('password', $updatedData)) {
            $updatedData['password'] = bcrypt($updatedData['password']);
        }
        $user->update($updatedData);

        event(new AuthRegistered($user));
        if (! empty($data[$this->queryParams['get_access_tokens']])) {
            $accessTokens = $this->getLoginTokens($data);
            $user->setAttribute('access_tokens', $accessTokens);
        }

        return $user;
    }

    /**
     * @param $data
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException | \Exception
     */
    protected function fixDataForRegister($data)
    {
        $country = $this->getCountryByData($data);

        $userData = [
            'name' => $data['name'],
            'activation_token' => random_int(1000, 9999),
            'is_active' => \ConstYesNo::NO,
            'is_flag' => \ConstYesNo::NO,
            'is_subscriber' => \ConstYesNo::NO,
            'country_id' => $country->id,
            'country' => $country->iso2,
            'lang' => get_language_by_country($country, $data),
            'timezone' => get_timezone_by_country($country, $data),
        ];

        return $userData;
    }

    /**
     * @param $data
     * @param array $columns
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     */
    public function login($data, $columns = ['*'])
    {
        $columns = [
            'id',
            'name',
            'is_subscriber',
            'password',
            'is_active',
            'profile_path',
            'profile_disk',
            'email',
            'odds_type',
            'timezone',
            'bio',
            'is_active',
            'is_flag',
            'is_subscriber',
            'phone',
            'newsletter',
            'promotions',
            'lang',
            'country',
            'country_id',
            'birthday',
            'role',
        ];
        return parent::login($data, $columns); // TODO: Change the autogenerated stub
    }

    /**
     * @param $data
     * @param array $columns
     * @return array
     * @throws ApiAuthTokenException
     * @throws \LaraAreaValidator\Exceptions\ValidationException | \Exception
     */
    public function appleLogin($data, $columns = ['*'])
    {
        $this->validateAppleLogin($data);
        $id = $this->getAppleUserData($data);
        $authUser = $this->model->newQuery()->find($id, $columns);

        $qpUserName = $this->queryParams['username'];
        $qpPassword = $this->queryParams['password'];
        $data[$qpPassword] = $authUser->{$qpUserName} . $authUser->{$qpPassword};
        $data[$qpUserName] = $authUser->{$qpUserName};

        $tokens = $this->getLoginTokens($data);
        event(new SocialAuthLogin($authUser, $tokens));

        return [
            $authUser,
            $tokens
        ];
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    protected function validateAppleLogin($data)
    {
        $rules = [
            'id' => 'required',
        ];

        $rules = $this->fixLoginRememberRules($rules);
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @param $data
     * @return mixed
     * @throws ValidationException
     */
    protected function getAppleUserData($data)
    {
        $provider = \ConstSocialProviders::APPLE;
        $userId = SocialUser::where(['social_user_id' => $data['id'], 'provider' => \ConstSocialProviders::APPLE])->value('user_id');
        if (! empty($userId)) {
            return $userId;
        }

        $rules = [
            'email' => 'required|email',
            'name' => 'required|string',
        ];

        $this->validate($data, $rules, $this->validator);
        $user = $this->model->whereEmail($data['email'])->first();
        // checked with fb email has user
        if (is_null($user)) {
            // if no user create it
            $user = $this->model->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'is_active' => \ConstUserStatus::ACTIVE // @TODO discuss
            ]);

            $user->email_settings()->create();
            $user->notification_settings()->create();
            $user->notify(new Welcome());
        } else {
            if (\ConstYesNo::YES != $user->is_active) {
                $user->update(['is_active' => \ConstYesNo::YES]);
            }
        }

        // when alredy has user with fb email that case create new record in social_users table
        SocialUser::create([
            'provider' =>  $provider,
            'social_user_id' => $data['id'],
            'user_id' => $user->getKey(),
        ]);
        return $user->getKey();
    }


        /**
     * @return array
     */
    public function loginRules()
    {
        return [
            $this->queryParams['username'] => ['required', 'string', 'email',],
            $this->queryParams['password'] => ['required', 'string'],
        ];
    }

    /**
     * @param $user
     * @param $data
     * @throws ApiException
     */
    protected function additionalCheck($user, $data)
    {
        if (empty($data['force_login']) && \ConstUserStatus::IN_ACTIVE == $user->is_active ) {
            throw new ApiException(401, mobile_validation('not_active_user'));
        }
        $qpPassword = config('laraarea_api.query_params.auth.password');
        if ($user->{$qpPassword} == md5($data[$qpPassword])) {
            $user->update([$qpPassword => bcrypt($data[$qpPassword])]);
        }
    }

    /**
     * @param $data
     * @return mixed
     * @throws ApiException
     * @throws ValidationException
     */
    public function activate($data)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'code' => 'required|string|max:128',
        ];
        $this->validate($data, $rules, $this->validator);

        $user = $this->model->where('id', $data['user_id'])->where('activation_token', $data['code'])->first();
        if (empty($user)) {
            throw new ApiException(\ConstErrorCodes::IT_OR_TOKEN_INVALID, mobile_validation('id_or_code_invalid'));
        }

        if (\ConstYesNo::YES == $user->is_active) {
            throw new ApiException(\ConstErrorCodes::ALREADY_ACTIVATED, mobile_validation('already_activated'));
        }

        $user->update(['is_active' => \ConstYesNo::YES]);
        return $user;
    }

    /**
     * @param $data
     * @param AuthUser $item
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function fixDataForUpdate($data, $item)
    {
        if (isset($data['avatar']) && is_a($data['avatar'], UploadedFile::class)) {
            $data['profile_path']['file'] = \Illuminate\Support\Arr::pull($data, 'avatar');
            $data['profile_path']['name'] = $item->profile_path ?? $data['name'] ?? Str::slug($item->name);
            $this->model = $item;
            $data = $this->upload($data, 'profile_path');
            dispatch_now(new ResizeProfile($this->model, $data['profile_path']));
        }

        if (isset($data['birthday'])) {
            $data['birthday'] = Carbon::parse($data['birthday'])->format('Y-m-d');
        }

        return $data;
    }

    /**
     * @param $model
     * @param $data
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function _updateExisting($model, $data)
    {
        $with = Arr::pull($data, 'with', []);
        $data = $this->fixDataForUpdate($data, $model);
        $permitted = [
            'feedback_rating',
            'odds_type',
            'timezone',
            'lang',
            'country',
            'country_id',
            'timezone',
            'odds_type',
            'name',
            'email',
            'password',
            'remember_token',
            'password_reset_expires_at',
            'activation_token',
            'profile_disk',
            'profile_image',
            'phone',
            'bio',
            'Newsletter',
            'Promotions',
            'birthday',
        ];
        $updatedData = collect($data)->only($permitted)->all();

        $country = $this->getCountryByData($data, false);
        if ($country) {
            $updatedData['country_id'] = $country->id;
            $updatedData['country'] = $country->iso2;
        }

        if ($model->update($updatedData)) {
            $this->updateRelations($model, $with);
        }

        $notificationCols = config('api_config.notifications');

        $notificationData = [];
        if (! empty($data['notification_settings'])) {
            $notificationData = $data['notification_settings'];
        }
        foreach ($notificationCols as $new => $old) {
            if (isset($data['notification_settings'][$new])) {
                $notificationData[$new] = $data['notification_settings'][$new];
            } elseif(isset($data[$old])) {
                $notificationData[$new] = $data[$old];
            }
        }

        if (! empty($data['one_token'])) {
            $notificationData['ios_one_token'] = $data['one_token'];
            $notificationData['android_one_token'] = $data['one_token'];
        }

        if (! empty($data['ios_one_token'])) {
            $notificationData['ios_one_token'] = $data['ios_one_token'];
        }

        if (! empty($data['android_one_token'])) {
            $notificationData['android_one_token'] = $data['android_one_token'];
        }

        if (! empty($notificationData)) {
            $model->notification_settings->update($notificationData);
            $notificationChanges = $model->notification_settings->getChanges();
            // @TODO tmp
            foreach ($notificationCols as $key => $val) {
                if(isset($notificationChanges[$key])) {
                    $notificationChanges[$val] = $notificationChanges[$key];
                    $model->setAttribute($val, $notificationChanges[$key]);
                    if ($key != $val) {
                        unset($notificationChanges[$key]);
                    }
                }
            }

            $model->mergeChanges($notificationChanges);
        }

        $emailCols = config('api_config.emails');
        $emailData = [];
        if (! empty($data['email_settings'])) {
            $emailData = $data['email_settings'];
        }

        foreach ($emailCols as $new => $old) {
            if (isset($data['email_settings'][$new])) {
                $emailData[$new] = $data['email_settings'][$new];
            } elseif(isset($data[$old])) {
                $emailData[$new] = $data[$old];
            }
        }

        if (! empty($emailData)) {
            $model->email_settings->update($emailData);
            $emailChanges = $model->email_settings->getChanges();
            // @TODO tmp
            foreach ($emailCols as $key => $val) {
                if(isset($emailChanges[$key])) {
                    $emailChanges[$val] = $emailChanges[$key];
                    $model->setAttribute($val, $emailChanges[$key]);
                    unset($emailChanges[$key]);
                }
            }

            $model->mergeChanges($emailChanges);
        }
        return $model;
    }


//    /**
//     * @param $authUser
//     */
//    protected function manuallyLogin($authUser)
//    {
//        $tokenResult = $authUser->createToken('Personal Access Token');
//        $token = $tokenResult->token;
//        $token->expires_at = Carbon::now()->addDays(1);
//
//        if (! empty($data['remember_me'])) {
//            $token->expires_at = Carbon::now()->addDays(30);
//        }
//        $token->save();
//    }

    /**
     * @param $data
     * @param null $provider
     * @return mixed
     * @throws \Exception
     */
    public function getUserIdBySocialData($data, $provider = null)
    {
        $provider = $provider ?? \ConstSocialProviders::FACEBOOK;
        $socialUser = $this->getSocialUser($data);
        // this code written for facebook
        $socialUserId = $socialUser->getId();
        $webSocialUser = SocialUser::where([
            'provider' =>  $provider,
            'social_user_id' =>  $socialUserId
        ])->first(['user_id']);

        // here do all logic
        // checked if fb account has connected local account send local user_id
        if (is_null($webSocialUser)) {
            // if no connected that case must be connect him
            // create new record in social_users table
            DB::beginTransaction();
            $webSocialUser = $this->createLocalSocialUser($socialUser, $provider);
            DB::commit();
        }

        // @TODO check case when social user update email
        return $webSocialUser->user_id;
    }

    /**
     * @param $data
     * @return SocialiteTwoUser
     */
    protected function getSocialUser($data)
    {
        $socialUser =  new SocialiteTwoUser();
        $socialUser->id = $data['id'];
        $socialUser->avatar = $data['url'];
        $socialUser->email= $data['email'];
        $socialUser->name = $data['first_name'] . ' ' . $data['last_name'];
        return $socialUser;
    }

    /**
     * @param SocialiteTwoUser $socialUser
     * @param $provider
     * @return SocialUser|Model
     */
    protected function createLocalSocialUser(SocialiteTwoUser $socialUser, $provider)
    {
        $email = $socialUser->getEmail();
        $user = $this->model->whereEmail($email)->first();
        // checked with fb email has user
        if (is_null($user)) {
            // if no user create it
            $user = $this->createUserBySocial($socialUser, $provider);
        } else {
            if (\ConstYesNo::YES != $user->is_active) {
                $user->update(['is_active' => \ConstYesNo::YES]);
            }
        }

        // when alredy has user with fb email that case create new record in social_users table
        $webSocialUser = SocialUser::create([
            'provider' =>  $provider,
            'social_user_id' => $socialUser->getId(),
            'user_id' =>  $user->getKey(),
        ]);
        return $webSocialUser;
    }


    /**
     * @param $socialUser
     * @param string $provider
     * @return mixed
     */
    public function createUserBySocial($socialUser, $provider)
    {
        if (\ConstSocialProviders::FACEBOOK != $provider) {
            dd('@TODO');
        }

        /**
         * @var $user AuthUser
         */
        $user = $this->model->create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'is_active' => \ConstUserStatus::ACTIVE // @TODO discuss
        ]);

        $avatar = $socialUser->getAvatar();
        $fileName = Str::slug($user->name) . '.jpg';

        $path = $user->getUploadFolderPath('profile_path');
        $disk = 'public';

        $folderPath = config('filesystems.disks.' . $disk . '.root') . '/' . $path . '/';
        if (! file_exists($folderPath)) {
            Storage::disk($disk)->makeDirectory($path);
        }
        $fullPath = $folderPath . '/' . $fileName;
        try {
//            @TODO fix for api social login
            copy($avatar, $fullPath);
            $user->update([
                'profile_path' => $fileName,
                'profile_disk' => $disk,
            ]);
        } catch (\Exception $e) {
        }

        /**
         * @var  $user AuthUser
         */
        $user->email_settings()->create();
        $user->notification_settings()->create();
        $user->notify(new Welcome());

        return $user;
    }

    /**
     * @return array
     */
    public function socialLoginRules()
    {
        if (method_exists($this->validator, 'socialLogin')) {
            return $this->validator->socialLogin();
        }
        // @TODO improve
        return [
            'id' => 'required',
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'url' => 'required|string',
        ];
    }

    /**
     * @param $user
     * @param $token
     */
    protected function notifyResetPassword($user, $token)
    {
        $user->notify(new SendPasswordResetToken($token));
    }

    /**
     * @param $user
     */
    protected function notifyPasswordReset($user)
    {
        $user->notify(new PasswordReseted());
    }

    /**
     * @return array
     */
    public function passwordResetPasswordRules()
    {
        if (method_exists($this->validator, 'resetPassword')) {
            return $this->validator->resetPassword();
        }

        return [
            'email' => 'required|string|email|max:128',
            'token' => 'required|string|max:128',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * @param $data
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function aresetPassword($data)
    {
        $this->validateResetPassword($data);
        $resetAttribute = $this->queryParams['reset'];
        $resetValue = $data[$resetAttribute];
        $resetTokenAttribute = $this->queryParams['reset_token'];
        $resetTokenValue = $data[$resetTokenAttribute];

        $passwordResetTable = config('laraarea_api.auth.reset_table');
        $passwordResets = DB::table($passwordResetTable)
            ->where([$resetAttribute => $resetValue, $resetTokenAttribute => $resetTokenValue])
            ->first();

        if (empty($passwordResets)) {
            $this->setErrorDetails(401, $this->messages['invalid_email_or_token']);
            return false;
        }

        if (now()->diffInMinutes($passwordResets->created_at) > config('auth.passwords.users.expire')) {
            $this->setErrorDetails(\ConstErrorCodes::TOKEN_EXPIRED, $this->messages['token_expired']);
            return false;
        }

        $user = $this->model->where('email', $data['email'])->first(['id', 'email', 'name']);
        if (empty($user)) {
            // @TODO make dynamic by income config auth expiration time
            $this->setErrorDetails(\ConstErrorCodes::USER_DELETED, $this->messages['user_with_this_credentials_deleted']);
            return false;
        }
        DB::table('password_resets')->where(['email' => $data['email'], 'token' => $data['token']])->delete();
        $isUpdated = $user->update(['password' => Hash::make($data['password'])]);
        if ($isUpdated) {
            $user->notify(new PasswordReseted());
            return true;
        }

        return response_format(\ConstResponse::FAILED, [$this->messages['unknown_error']]);
    }
    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateUpdateAuth($data)
    {
        $rules = array_merge($this->updateAuthRules());
        $this->validate($data, $rules, $this->validator);
    }


    /**
     * @return array
     */
    public function updateAuthRules()
    {
        if (method_exists($this->validator, 'updateAuth')) {
            return $this->validator->updateAuth();
        }

        $user = $this->getAuth();
        return [
            'avatar' => 'image',
            'name' => 'string|max:128',
            'email' => ['string', 'max:128', Rule::unique('users')->ignore($user->id)], // @TODO discuss change with email confirm
            'phone' => 'string|max:191',
            'bio' => 'string',
            'timezone' => [
                'nullable',
                'in:' . collect(config('timezones'))->pluck('timezone')->implode(',')
            ],
            'odds_type' => [
                'in:' . \ConstOddsType::FRACTIONAL . ',' . \ConstOddsType::DECIMALS
            ],
            'birthday' => 'date',
        ];
    }

    /**
     * @param $settingId
     * @return array
     * @throws ApiException
     */
    public function updateSetting($settingId)
    {
        $allNotificationSettings = Cache::remember('notification_settings', 24 * 60 * 60, function () {
            return \Api\V1\Models\NotificationSetting::whereNull('parent_id')
                ->where('is_active', \ConstYesNo::YES)
                ->with('translations')
                ->get();
        });
        $notificationSetting = $allNotificationSettings->where('id', $settingId)->first();
        if (empty($notificationSetting)) {
            throw new ApiException(401, 'Invalid setting');
        }

        /* @var $user AuthUser*/
        $user = $this->getAuth();
        $model = $notificationSetting->is_notification_setting ? $user->notification_settings : $user->email_settings;

        $column = $notificationSetting->column;
        if (key_exists($column, $model->getAttributes())) {
            $model->update([$column => ! $model->{$column}]);
        }

        return ['is_enabled' => $model->{$column}];
    }

    /**
     * @param $data
     * @return bool
     * @throws ApiException
     */
    public function updateManySettings($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = (bool) $value;
        }

        $allNotificationSettings = Cache::remember('notification_settings', 24 * 60 * 60, function () {
            return \Api\V1\Models\NotificationSetting::whereNull('parent_id')
                ->where('is_active', \ConstYesNo::YES)
                ->with('translations')
                ->get();
        });
        $keys = array_keys($data);
        $notificationSettings = $allNotificationSettings->whereIN('id', $keys);

        if ($notificationSettings->isEmpty()) {
            throw new ApiException(401, 'No any valid setting');
        }
        list($notificationSettings, $emailSettings) = $notificationSettings->partition(function ($item) {
            return $item->is_notification_setting == 1;
        });

        /* @var $user AuthUser*/
        $user = $this->getAuth();
        $notificationData = [];
        foreach ($notificationSettings->pluck('column', 'id')  as $id => $column) {
            if (key_exists($column, $user->notification_settings->getAttributes())) {
                $notificationData[$column] = $data[$id];
            }
        }

        if ($notificationData) {
            $user->notification_settings->update($notificationData);
        }

        $emailData = [];
        foreach ($emailSettings->pluck('column', 'id')  as $id => $column) {
            if (key_exists($column, $user->email_settings->getAttributes())) {
                $emailData[$column] = $data[$id];
            }
        }

        if ($emailData) {
            $user->email_settings->update($emailData);
        }

        return true;
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function generateToken()
    {
        return random_int(10000, 99999);
    }

    /**
     * @param $data
     * @param bool $findDefault
     * @return mixed|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function getCountryByData($data, $findDefault = true)
    {
        $countries = get_cached_countries();
        $id = $data['country_id'] ?? null;

        if ($id) {
            $country = $countries->where('id', $id)->first();
        } else {
            $iso2 = $data['country'] ?? null;
            $iso2 = strtoupper($iso2);
            $country = $iso2 ? $countries->where('iso2', $iso2)->first() : null;
        }

        if ($country) {
            return $country;
        }

        return $findDefault ? get_country_by_ip() : null;
    }
}
