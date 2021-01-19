<?php

namespace LaraAreaApi\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use LaraAreaApi\Exceptions\ApiAuthTokenException;
use LaraAreaApi\Models\ApiAuth;
use Laravel\Passport\Passport;

trait AccessTokenTrait
{
    public function getLoginToken()
    {

    }

    /**
     * @param $data
     * @return mixed
     * @throws ApiAuthTokenException
     */
    public function getLoginTokenByCredentials($data)
    {
        if (!empty($data[$this->queryParams['remember_me']])) {
            Passport::tokensExpireIn(now()->addDays(config('laraarea_api.auth.remember_me_days', 30)));
        } elseif (!empty($data[$this->queryParams['remember_days']])) {
            Passport::tokensExpireIn(now()->addDays($data[$this->queryParams['remember_days']]));
        }
dd(12);
        return $tokens;
    }

    /**
     * @param ApiAuth $user
     * @param null $days
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function createToken(ApiAuth $user, $days = null)
    {
        $tokenResult = $user->createToken('Personal Access Token');

        if ($days) {
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addDays($days);
            $token->save();
        }

        return $tokenResult;
    }

    protected function createAccessTokenByCredentials($userName, $password)
    {
        $host = request()->getHost(); // TODO improve
        $tokenRequest = Request::create(
            '/oauth/token',
            'post', [
            'grant_type' => 'password',
            'client_id' => env('O_AUTH_CLIENT_ID'),
            'client_secret' => env('O_AUTH_CLIENT_SECRET'),
            'username' => $userName,
            'password' => $password,
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
        return json_decode((string) $response->getContent(), true);
    }
}
