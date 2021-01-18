<?php

namespace LaraAreaApi\Http\Responses;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use LaraAreaApi\Exceptions\ApiAuthTokenException;
use LaraAreaApi\Exceptions\ApiException;
use LaraAreaValidator\Exceptions\ValidationException;

class BaseApiResponse
{
    /**
     * @param Collection $items
     * @return \Illuminate\Http\JsonResponse
     */
    public function eloq_collection(Collection $items)
    {
        return $this->structure([
            'result' => $items->toArray(),
            'error' => null
            ]
        );
    }

    /**
     * @param Request $request
     * @param LengthAwarePaginator $items
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request, LengthAwarePaginator $items)
    {
        $links = [
            'first' => $this->getPaginationUrl($request, 1),
            'last' => $this->getPaginationUrl($request, $items->lastPage()),
            'prev' => $this->previousPageUrl($request, $items),
            'next' => $this->nextPageUrl($request, $items),
        ];

        $meta = [
            'current_page' => $items->currentPage(),
            'from' => $items->firstItem(),
            'last_page' => $items->lastPage(),
            'per_page' => $items->perPage(),
            'path' => $request->fullUrlWithQuery($request->toArray()),
            'to' => $items->lastItem(),
            'total' => $items->total(),
        ];

        return $this->structure([
            'result' => $items->items(),
            'error' => null,
            'additional' => [
                'links' => $links,
                'meta' => $meta
            ],
        ]);
    }

    /**
     * @param Request $request
     * @param ValidationException $exception
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationError(Request $request, ValidationException $exception, $code = 200)
    {
        $validator = $exception->getValidator();
        $errors = $validator->getMessageBag();
        $message = collect($errors->toArray())->flatten()->first();
        $additional = [
            'attributes' => $errors,
        ];

        $model = $validator->getModel();
        if ($model) {
            $additional['model'] = $model->getAttributes();
        }

        return $this->errorStructure($request, $exception->getErrorCode(), $message, $additional, $code);
    }

    /**
     * @param Request $request
     * @param ApiAuthTokenException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiAuthTokenError(Request $request, ApiAuthTokenException $exception)
    {
        return $this->structure([
            'result' => null,
            'error' => [
                'message' => $exception->getMessage(),
                'attributes' => $exception->getErrors(),
            ],
        ]);
    }

    /**
     * @param Request $request
     * @param ApiException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(Request $request, ApiException$exception)
    {
        return $this->errorStructure($request, $exception->getErrorCode(), $exception->getMessage());
    }

    /**
     * @param Request $request
     * @param $errorCode
     * @param $message
     * @param array $additional
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorStructure(Request $request, $errorCode, $message, $additional = [], $statusCode = 200)
    {
        if ($statusCode == 0) {
            $statusCode = 200;
        }

        $error = [
            'errorCode' => $errorCode,
            'message' => $message,
        ];

        if ($additional) {
            $error = array_merge($error, $additional);
        }
        return $this->structure(
            [
                'result' => null,
                'error' => $error,
            ],
            $statusCode
        );
    }

    /**
     * @param Request $request
     * @param $code
     * @param $message
     * @param array $additional
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundItem(Request $request, $code, $message, $additional = [], $statusCode = 200)
    {
        return $this->errorStructure($request, $code, $message, $additional, $statusCode);
    }

    /**
     * @param $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function authRegistered($auth)
    {
        return $this->structure([
            'result' => $auth,
            'error' => null,
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data)
    {
        return $this->structure([
            'result' => $data,
            'error' => null,
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($data)
    {
        return $this->structure([
            'result' => $data,
            'error' => null,
        ], 201);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($data)
    {
        $data['error'] = new \stdClass();

        return $this->structure($data);
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function structure($data = [], $status = 200, $headers = [], $options = 0)
    {
        return Response::json($data, $status, $headers, $options);
    }

    /**
     * @param Request $request
     * @param $page
     * @return string
     */
    protected function getPaginationUrl(Request $request, $page)
    {
        $params = $request->all();
        $params['page'] = $page;
        return $request->fullUrlWithQuery($params);
    }

    /**
     * @param Request $request
     * @param LengthAwarePaginator $items
     * @return string|null
     */
    public function previousPageUrl(Request $request, LengthAwarePaginator $items)
    {
        if ($items->currentPage() > 1) {
            return $this->getPaginationUrl($request, $items->currentPage() - 1);
        }
        return null;
    }

    /**
     * @param Request $request
     * @param LengthAwarePaginator $items
     * @return string|null
     */
    public function nextPageUrl(Request $request, LengthAwarePaginator $items)
    {
        if ($items->lastPage() > $items->currentPage()) {
            return $this->getPaginationUrl($request, $items->currentPage() + 1);
        }
        return null;
    }
}
