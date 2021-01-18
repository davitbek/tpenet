<?php

namespace LaraAreaApi\Services;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Passport\Passport;
use LaraAreaApi\Events\AuthLogin;
use LaraAreaApi\Events\AuthRegistered;
use LaraAreaApi\Events\SocialAuthLogin;
use LaraAreaApi\Exceptions\ApiAuthTokenException;
use LaraAreaApi\Exceptions\ApiException;
use LaraAreaApi\Models\ApiAuth;

class ApiBaseAuthService extends ApiBaseService
{
    use DispatchesJobs;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $queryParams;

    /**
     * @var ApiAuth
     */
    protected $model;

    /**
     * ApiBaseAuthService constructor.
     * @param null $model
     * @param null $validator
     */
    public function __construct($model = null, $validator = null)
    {
        parent::__construct($model, $validator);
        $this->queryParams = config('laraarea_api.query_params.auth');
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|\LaraAreaApi\Models\ApiModel
     * @throws \Exception
     */
    public function register($data)
    {
        $this->validateRegister($data);
        $user = $this->_register($data);
        if (!empty($data[$this->queryParams['get_access_tokens']])) {
            $accessTokens = $this->getLoginTokens($data);
            $user->setAttribute('access_tokens', $accessTokens);
        }
        event(new AuthRegistered($user));
        return $user;
    }

    /**
     * @param $data
     * @return ApiAuth
     */
    public function _register($data)
    {
        $qpUserName = $this->queryParams['username'];
        $qpPassword = $this->queryParams['password'];
        $userData = [
            $qpUserName => $data[$qpUserName],
            $qpPassword => $this->bcriptPassword($data[$qpPassword]),
        ];
        $userData = array_merge($userData, $this->fixDataForRegister($data));
        return $this->model->create($userData);
    }

    /**
     * @param $data
     * @return array
     */
    protected function fixDataForRegister($data)
    {
        return [];
    }

    /**
     * @param $data
     * @param array $columns
     * @return array
     * @throws ApiAuthTokenException
     * @throws ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function login($data, $columns = ['*'])
    {
        $this->validateLogin($data);
        $authUser = $this->attempt($data, $columns);
        $tokens = $this->getLoginTokens($data);
        event(new AuthLogin($authUser, $tokens));

        return [
            $authUser,
            $tokens
        ];
    }

    /**
     * @param $data
     * @return mixed
     * @throws ApiAuthTokenException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function refreshToken($data)
    {
        $this->validateRefresh($data);
        $tokenRequest = Request::create('/oauth/token', 'post', [
            'grant_type' => 'refresh_token',
            'client_id' => env('O_AUTH_CLIENT_ID'),
            'client_secret' => env('O_AUTH_CLIENT_SECRET'),
            'scope' => '',
            'refresh_token' => $data[$this->queryParams['refresh_token']],
        ]);

        $response = app()->handle($tokenRequest);
        $tokens = json_decode((string) $response->getContent(), true);

        if (! key_exists('access_token', $tokens)) {
            throw new ApiAuthTokenException(laraarea_api_error_code('access_token'), $this->message('auth_failure'), $tokens);
        }

        return $tokens;
    }

    /**
     * @param $data
     * @param array $columns
     * @return array
     * @throws ApiAuthTokenException
     * @throws \LaraAreaValidator\Exceptions\ValidationException | \Exception
     */
    public function socialLogin($data, $columns = ['*'])
    {
        $this->validateSocialLogin($data);
        $id = $this->callChildClassMethod('getUserIdBySocialData', [$data]);

        $authUser = $this->model->newQuery()->find($id, $columns);

        $qpUserName = $this->queryParams['username'];
        $qpPassword = $this->queryParams['password'];
        $data[$qpPassword] = $authUser->{$qpUserName} . $authUser->{$qpPassword};

        $tokens = $this->getLoginTokens($data);
        event(new SocialAuthLogin($authUser, $tokens));

        return [
            $authUser,
            $tokens
        ];
    }

    /**
     * @param $data
     * @return mixed
     * @throws ApiAuthTokenException
     */
    public function getLoginTokens($data)
    {
        if (!empty($data[$this->queryParams['remember_me']])) {
            Passport::tokensExpireIn(now()->addDays(config('laraarea_api.auth.remember_me_days', 30)));
        } elseif (!empty($data[$this->queryParams['remember_days']])) {
            Passport::tokensExpireIn(now()->addDays($data[$this->queryParams['remember_days']]));
        }

        $host = request()->getHost(); // TODO improve
        $tokenRequest = Request::create(
            '/oauth/token',
            'post', [
            'grant_type' => 'password',
            'client_id' => env('O_AUTH_CLIENT_ID'),
            'client_secret' => env('O_AUTH_CLIENT_SECRET'),
            'username' => $data[$this->queryParams['username']],
            'password' => $data[$this->queryParams['password']],
            'scope' => '',
        ],
            [],
            [],
            [
                'SERVER_NAME' => $host,
                'HTTP_HOST' => $host,
            ]
        );
        $tokenRequest = clone $tokenRequest;
        $response = app()->handle($tokenRequest);
        $tokens = json_decode((string) $response->getContent(), true);
        if (! key_exists('access_token', $tokens)) {
            // @TODO auth failure code
            throw new ApiAuthTokenException(laraarea_api_error_code('access_token'), mobile_validation('auth_failure'), $tokens);
        }

        return $tokens;
    }

    /**
     * @param $data
     * @param array $columns
     * @return bool|null
     * @throws \LaraAreaValidator\Exceptions\ValidationException | \Exception
     */
    public function forgotPassword($data, $columns = ['*'])
    {
        $this->validateForgotPassword($data);
        $resetAttribute = $this->queryParams['reset'];
        $resetValue = $data[$resetAttribute];
        $user = $this->model->where($resetAttribute, $resetValue)->first($columns);

        if (empty($user)) {
            throw new ApiException(laraarea_api_error_code('invalid_email'), $this->message('invalid_reset_value'));
        }

        $passwordResetTable = config('laraarea_api.auth.reset_table');
        DB::table($passwordResetTable)->where([$resetAttribute => $resetValue])->delete();

        if (method_exists($this, 'generateToken')) {
            $token = $this->generateToken();
        } else {
            $token = Str::random();
        }

        $passwordReset = DB::table($passwordResetTable)->insert([
            $resetAttribute => $resetValue,
            'token' => $token,
            'created_at' => now()
        ]);

        if(empty($passwordReset)) {
            throw new ApiException(laraarea_api_error_code('un_categorized'), $this->message('unknown_error'));
        }

        $this->callChildClassMethod('notifyResetPassword', [$user, $token]);
        return true;
    }

    /**
     * @param $data
     * @param array $columns
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function resetPassword($data, $columns = ['*'])
    {
        $this->validateResetPassword($data);
        $resetAttribute = $this->queryParams['reset'];
        $resetValue = $data[$resetAttribute];
        $resetTokenAttribute = $this->queryParams['reset_token'];
        $resetTokenValue = $data[$resetTokenAttribute];

        $passwordResetTable = config('laraarea_api.auth.reset_table');
        $passwordResetQuery = DB::table($passwordResetTable)
            ->where([$resetAttribute => $resetValue, $resetTokenAttribute => $resetTokenValue]);

        $passwordResets = $passwordResetQuery->first();
        if (empty($passwordResets)) {
            throw new ApiException(laraarea_api_error_code('un_categorized'), $this->message('invalid_email_or_token'));
        }

        if (now()->diffInMinutes($passwordResets->created_at) > config('auth.passwords.users.expire')) {
            throw new ApiException(laraarea_api_error_code('un_categorized'), $this->message('token_expired'));
        }

        $user = $this->model->where( $resetAttribute, $resetValue)->first($columns);
        if (empty($user)) {
            throw new ApiException(laraarea_api_error_code('un_categorized'), $this->message('user_with_this_credentials_deleted'));
        }

        DB::beginTransaction();
        $passwordResetQuery->delete();
        $isUpdated = $user->update([$this->queryParams['password'] => $this->bcriptPassword($data['password'])]);

        if ($isUpdated) {
            $this->callChildClassMethod('notifyPasswordReset', [$user]);
            DB::commit();
            return true;
        }

        DB::rollBack();
        throw new ApiException(laraarea_api_error_code('un_categorized'), $this->message('user_with_this_credentials_deleted'));
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateAuth($data)
    {
        $this->validateUpdateAuth($data);
        $user = \Auth::guard('api')->user();
        $data = $this->fixUpdatedPasswordData($data);
        return $this->_updateExisting($user, $data);
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model|null
     * @throws ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateAuthPassword($data)
    {
        $this->validateUpdateAuthPassword($data);
        $oldPassword = $data[$this->queryParams['current_password']];
        $newPassword = $data[$this->queryParams['password']];
        $user = \Auth::guard('api')->user();

        if ($oldPassword == $newPassword) {
            return $user;
        }

        $updatedData = $this->fixUpdatedPasswordData($data);
        return $this->_updateExisting($user, $updatedData);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function deleteAuth()
    {
        $user = $this->getAuth();
        return $this->deleteExisting($user);
    }

    /**
     * @param $data
     * @param null $user
     * @return mixed
     * @throws ApiException
     */
    protected function fixUpdatedPasswordData($data, $user = null)
    {
        if (! isset($data[$this->queryParams['password']]) || !isset($data[$this->queryParams['current_password']])) {
            return $data;
        }

        $oldPassword = $data[$this->queryParams['current_password']];
        $newPassword = $data[$this->queryParams['password']];
        $user = $user ?? \Auth::guard('api')->user();

        if ($oldPassword == $newPassword) {
            unset($data[$this->queryParams['password']]);
            return $data;
        }

        $this->checkPassword($this->queryParams['current_password'], $user->getAuthPassword());
        $data[$this->queryParams['password']] = $this->bcriptPassword($this->queryParams['password']);
        return $data;
    }

    /**
     * @param $password
     * @return string
     */
    protected function bcriptPassword($password)
    {
        return Hash::make($password);
    }

    /**
     * @param $new
     * @param $old
     * @throws ApiException
     */
    public function checkPassword($new, $old)
    {
        $hasher = App::make(Hasher::class);
        if (! $hasher->check($new, $old)) {
            throw new ApiException(laraarea_api_error_code('incorrect_password'), $this->message('current_password_is_wrong'));
        }
    }

    /**
     * @param $data
     * @param array $columns
     * @return mixed
     * @throws ApiException
     */
    protected function attempt($data, $columns = ['*'])
    {
        $qpUserName = $this->queryParams['username'];
        $qpPassword = $this->queryParams['password'];
        if (['*'] != $columns) {
            $columns[] = $qpUserName;
            $columns[] = $qpPassword;
            $columns = array_unique($columns);
        }
        
        $user = $this->model->where($qpUserName, $data[$qpUserName])
            ->first($columns);
        if (empty($user)) {
            throw new ApiException(laraarea_api_error_code('attempt'), $this->message('invalid_user_credentials'));
        }

        $this->additionalCheck($user, $data);

        $hasher = \App::make(HashManager::class);
        if (!$hasher->check($data[$qpPassword], $user->{$qpPassword})) {
            throw new ApiException(laraarea_api_error_code('attempt'), $this->message('invalid_user_credentials'));
        }

        return $user;
    }

    /**
     * @param $user
     * @param $data
     */
    protected function additionalCheck($user, $data)
    {
    }

    /**
     * @param $data
     * @param bool $throwException
     * @return bool
     * @throws \Exception
     */
    public function validateRegister($data, $throwException = true)
    {
        $rules = $this->registerRules();
        return $this->validate($data, $rules, $this->validator, $throwException);
    }

    /**
     * @return array
     */
    public function registerRules()
    {
        if (method_exists($this->validator, 'register')) {
            return $this->validator->register();
        }

        return [
            $this->queryParams['username'] => ['required', 'string', 'email', 'max:255', 'unique:users'],// @TODO dynamic
            $this->queryParams['password'] => ['required', 'string', 'min:8', 'confirmed'],
            $this->queryParams['password'] . '_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateRefresh($data)
    {
        $rules = [
             $this->queryParams['refresh_token'] => ['required', 'string'],
        ];
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateLogin($data)
    {
        $rules = $this->loginRules();
        $rules = $this->fixLoginRememberRules($rules);
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @return array
     */
    public function loginRules()
    {
        if (method_exists($this->validator, 'login')) {
            return $this->validator->login();
        }

        return [
            $this->queryParams['username'] => ['required', 'string'],
            $this->queryParams['password'] => ['required', 'string'],
            $this->queryParams['remember_days'] => ['integer', 'min:1', 'max:366' ],
        ];
    }

    /**
     * @param $rules
     * @return mixed
     */
    protected function fixLoginRememberRules($rules)
    {
        if (!key_exists($this->queryParams['remember_days'], $rules)) {
            $rules[$this->queryParams['remember_days']] = ['integer', 'min:1', 'max:366' ];
        }

        return $rules;
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateSocialLogin($data)
    {
        $rules = $this->socialLoginRules();
        $rules = $this->fixLoginRememberRules($rules);
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @return array
     */
    public function socialLoginRules()
    {
        if (method_exists($this->validator, 'socialLogin')) {
            return $this->validator->socialLogin();
        }

        return [];
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateForgotPassword($data)
    {
        $rules = $this->passwordForgotPasswordRules();
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @return array
     */
    public function passwordForgotPasswordRules()
    {
        if (method_exists($this->validator, 'forgotPassword')) {
            return $this->validator->forgotPassword();
        }

        return [
            $this->queryParams['reset'] => 'required|string'
        ];
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateUpdateAuthPassword($data)
    {
        $rules = $this->updateAuthPasswordRules();
        $this->validate($data, $rules, $this->validator);
    }

    /**
     * @return array
     */
    public function updateAuthPasswordRules()
    {
        if (method_exists($this->validator, 'updateAuthPassword')) {
            return $this->validator->updateAuthPassword();
        }

        return [
            $this->queryParams['current_password'] => 'required|string',
            $this->queryParams['password'] => 'required|string|confirmed',
            $this->queryParams['password']. '_confirmation' => 'required|string',
        ];
    }

    /**
     * @param $data
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function validateUpdateAuth($data)
    {
        $rules = array_merge($this->updateAuthRules(), $this->updateAuthPasswordRules());
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

        $user = \Auth::guard('api')->user();
        return [
            $this->queryParams['username'] => ['string', Rule::unique($user->getTable())->ignore($user->getKey())],
        ];
    }

    /**
     * @param $data
     * @throws \Exception
     */
    public function validateResetPassword($data)
    {
        $rules = $this->passwordResetPasswordRules();
        $this->validate($data, $rules, $this->validator);
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
            $this->queryParams['reset_token'] => 'required|string',
            $this->queryParams['username'] => 'required|string',
            $this->queryParams['password'] => 'required|string|confirmed',
            $this->queryParams['password']. '_confirmation' => 'required|string',
        ];
    }

    /**
     * @param $method
     * @param array $arguments
     * @param null $object
     * @return mixed
     * @throws \Exception
     */
    public function callChildClassMethod($method, $arguments = [], $object = null)
    {
        $object = $object ?? $this;
        if (method_exists($this, $method)) {
            return $object->{$method}(... $arguments);
        } else {
            throw new \Exception(sprintf('[%s] method absent in [%s] class. Please implement it', $method, get_class($object)));
        }
    }

    /**
     *
     * @param $key
     * @param array $replace
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function message($key, $replace = [])
    {
        return __laraarea_api($key, $replace);
    }
}
