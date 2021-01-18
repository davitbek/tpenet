<?php

namespace LaraAreaApi\Http\Middleware;

class ApiAuthHeader
{
    /**
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! is_null($request->header('ApiAuth')) && empty($request->header('Authorization'))) {
            $request->headers->add(['Authorization' => 'Bearer ' . $request->header('ApiAuth')]);
        }

        return $next($request);
    }
}
