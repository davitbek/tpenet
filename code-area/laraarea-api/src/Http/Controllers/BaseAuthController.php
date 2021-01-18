<?php

namespace LaraAreaApi\Http\Controllers;

use Illuminate\Http\Request;
use LaraAreaApi\Services\ApiBaseAuthService;
use LaraAreaApi\Transformers\AuthTransformer;

/**
 * Class BaseAuthController
 * @package LaraAreaApi\Http\Controllers
 */
class BaseAuthController extends BaseController
{
    /**
     * @var ApiBaseAuthService
     */
    protected $service;

    /**
     * @var
     */
    protected $model;

    /**
     * @var AuthTransformer
     */
    protected $transformer;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $user = $this->service->register($request->all());
        $userData = $this->transformer->transformRegistered($user, $request);
        return $this->response->authRegistered($userData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     * @throws \LaraAreaApi\Exceptions\ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function login(Request $request)
    {
        [$user, $tokens] = $this->service->login($request->all());
        $userData = $this->transformer->transform($user, $request);
        return $this->response->success(['user' => $userData, 'tokens' => $tokens]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function refreshToken(Request $request)
    {
        $tokens = $this->service->refreshToken($request->all());
        return $this->response->success($tokens);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiAuthTokenException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function socialLogin(Request $request)
    {
        [$user, $tokens] = $this->service->socialLogin($request->all());
        $userData = $this->transformer->transform($user, $request);
        return $this->response->success(['user' => $userData, 'tokens' => $tokens]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser(Request $request)
    {
        $user = $this->getAuth();
        $userData = $this->transformer->transform($user, $request);
        return $this->response->success($userData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function forgotPassword(Request $request)
    {
        $this->service->forgotPassword($request->toArray());

        return $this->response->success([
            'email' => $request->email,
            'message' => $this->message('forgot_password')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function resetPassword(Request $request)
    {
        $this->service->resetPassword($request->toArray());

        return $this->response->success([
            'email' => $request->email,
            'message' => $this->message('reset_password')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateAuth(Request $request)
    {
        $result = $this->service->updateAuth($request->all());
        $response = $this->transformer->transform($result, $request, 'transformUpdatedModel');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateAuthPassword(Request $request)
    {
        $result = $this->service->updateAuthPassword($request->all());
        $response = $this->transformer->transform($result, $request, 'transformUpdatedModel');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAuth(Request $request)
    {
        $result = $this->service->deleteAuth();
        $response = $this->transformer->transform($result, $request, 'transformDeletedModel');
        return $this->response->success($response);
    }
}
