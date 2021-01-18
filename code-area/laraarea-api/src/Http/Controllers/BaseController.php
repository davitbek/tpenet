<?php

namespace LaraAreaApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LaraAreaApi\Http\Controllers\Traits\AutoInsertTrait;
use LaraAreaApi\Http\Responses\BaseApiResponse;
use LaraAreaApi\Services\ApiBaseService;
use LaraAreaValidator\AreaValidator;
use LaraAreaTransformer\Transformer;

class BaseController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        AutoInsertTrait;

    /**
     * @var ApiBaseService
     */
    protected $service;

    /**
     * @var AreaValidator
     */
    protected $validator;

    /**
     * @var BaseApiResponse
     */
    protected $response;

    /**
     * @var Transformer
     */
    protected $transformer;

    /**
     * @var bool
     */
    protected $makeDynamic = true;

    /**
     * BaseController constructor.
     * @param BaseApiResponse|null $apiResponse
     * @param null $apiTransformer
     * @param null $apiService
     * @param null $apiModel
     * @param null $apiValidator
     * @throws \Exception
     */
    public function __construct(BaseApiResponse $apiResponse = null, $apiTransformer = null, $apiService = null, $apiModel = null, $apiValidator = null)
    {
        if ($this->makeDynamic) {
            $this->makeModel($apiModel);
            $this->makeValidator($apiValidator, AreaValidator::class);
            $this->makeService($apiService, ApiBaseService::class);
            $this->makeTransformer($apiTransformer, Transformer::class);
            $this->response = $apiResponse;
        } else {
            $this->model = $apiModel;
            $this->response = $apiResponse;
            $this->transformer = $apiTransformer;
            $this->service = $apiService;
            $this->validator = $apiValidator;
        }
        $this->makeResourceName();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->indexTransformBy($request);
    }

    /**
     * @param Request $request
     * @param null $method
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexTransformBy(Request $request, $method = null)
    {
        $result = $this->service->index($request->all());
        if (is_null($result)) {
            return $this->response->success([]);
        }

        $response = $this->transformer->transform($result, $request, $method);
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $item = $this->service->create($request->all());
        if (is_object($item)) {
            $response = $this->transformer->transform($item, $request);
            return $this->response->created($response);
        }

        $code = laraarea_api_error_code('un_categorized');
        return $this->response->errorStructure($request, $code, $this->message('unknown_error'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $item = $this->service->findByArray($id, $request->all());
        if ($item) {
            $response = $this->transformer->transform($item, $request);
            return $this->response->success($response);
        } else {
            $message = $this->message('not_found', ['item' => $this->resource_name, 'id' => $id]);
            $code = laraarea_api_error_code('not_found');
            return $this->response->notFoundItem($request, $code, $message);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $item = $this->service->update($id, $request->all());
        return $this->sendSuccess($item);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->service->delete($id);
        return $this->sendSuccess($item, $request, 'transformDeletedModel' );
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function getAuth()
    {
        return Auth::guard('api')->user();
    }

    /**
     * @return int|string|null
     */
    protected function getAuthId()
    {
        return Auth::guard('api')->id();
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnFailureResponse($request)
    {
        [$errorCode, $message] = $this->service->getErrorDetails();
        return $this->response->errorStructure($request, $errorCode, $message);
    }

    /**
     * @param $result
     * @param Request|null $request
     * @param null $method
     * @param null $transformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccess($result, ? Request $request = null, $method = null, $transformer = null)
    {
        if ($method && ! Str::startsWith($method, 'transform')) {
            $method = 'transform' . ucfirst($method);
        }

        $transformer = $transformer ?? $this->transformer;
        $response = $transformer->transform($result, $request, $method);
        return $this->response->success($response);
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function __call($method, $parameters)
    {
        $parameters = !empty($parameters) ? $parameters : [app('request')->toArray()];
        $result = $this->service->{$method}(...$parameters);
        return $this->sendSuccess($result, null, $method);
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
