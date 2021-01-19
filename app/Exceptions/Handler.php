<?php

namespace App\Exceptions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use LaraAreaApi\Exceptions\ApiAuthTokenException;
use LaraAreaApi\Exceptions\ApiException;
use LaraAreaApi\Http\Responses\BaseApiResponse;
use LaraAreaValidator\Exceptions\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected $baseResponse;

    public function __construct(
        Container $container,
        BaseApiResponse $baseResponse
    )
    {
        parent::__construct($container);
        $this->baseResponse = $baseResponse;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * @param Throwable $e
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        if (Str::contains($e->getMessage(), 'telescope')) {
            return;
        }

        parent::report($e);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if (is_a($e, ValidationException::class)) {
            return $this->baseResponse->validationError($request, $e, $e->getCode());
        }

        if (is_a($e, ApiAuthTokenException::class)) {
            return $this->baseResponse->apiAuthTokenError($request, $e);
        }

        if (is_a($e, ApiException::class)) {
            return $this->baseResponse->error($request, $e);
        }

        return parent::render($request, $e);
    }
}
