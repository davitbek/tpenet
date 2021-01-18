<?php

namespace LaraAreaApi\Http\Middleware;

use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use LaraAreaApi\Http\Responses\BaseApiResponse;

class ApiAuth
{
    protected $apiResponse;

    public function __construct(BaseApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    /**
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (! empty($request->header('ApiAuth')) && empty($request->header('Authorization'))) {
            $code = config('laraarea_api.error_codes.header_missed');
            return $this->apiResponse->errorStructure($request, $code, mobile_auth('In header `ApiAuth` or Authorization is required'), [], 401);
        }

        $header = $request->header('Authorization');
        if (! empty(\Auth::guard('api')->user())) {
            return $next($request);
        }
        $header = str_replace('Bearer ', '', $header);

        try {
            $token = (new Parser())->parse($header);
            $accessTokenId = $token->getClaim('jti');
            if (\DB::table('oauth_access_tokens')->where('id', $accessTokenId)->exists()) {
                $code = config('laraarea_api.error_codes.access_token_expired');
                return $this->apiResponse->errorStructure($request, $code, mobile_auth('expired_access_token'), [], 401);
            }
        } catch (\Exception $e) {

        }

        $code = config('laraarea_api.error_codes.access_token_invalid');
        return $this->apiResponse->errorStructure($request, $code, mobile_auth('invalid_access_token'), [], 401);
    }
}
