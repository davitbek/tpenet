<?php

namespace LaraAreaTransformer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Transformer
{
    use ConditionallyLoadsAttributes;

    /**
     *
     */
    public function initialize()
    {

    }

    /**
     * @param $resource
     * @param Request|null $request
     * @param null $method
     * @return array|mixed
     */
    public function transform($resource, ? Request $request = null, $method = null)
    {
        $this->initialize();

        if (is_a($resource, LengthAwarePaginator::class)) {
            $result = $this->transformPaginator($resource, $request, $method);
        } elseif (is_a($resource, Collection::class)) {
            $result = $this->transformCollection($resource, $request, $method);
        } elseif ($method && method_exists($this, $method)) {
            $result  = $this->{$method}($resource, $request);
        } elseif (is_a($resource, Model::class)) {
            $result  = $this->transformModel($resource, $request);
        } elseif (is_array($resource)) {
            $result =  $this->transformArray($resource, $request);
        } elseif (is_object($resource)) {
            $result = $this->transformObject($resource, $request);
        }

        if (isset($result)) {
            $result = $this->filter($result);
            return $result;
        }

        return $this->transformPlain($resource, $request);
    }

    /**
     * @param $lengthAwarePaginator
     * @param Request|null $request
     * @param null $method
     * @return array
     */
    public function transformPaginator($lengthAwarePaginator, ? Request $request = null, $method = null)
    {
        if (! ($method && method_exists($this, $method))) {
            $method = 'transformPaginated';
        }
        $data = $lengthAwarePaginator->map(function ($model) use ($method, $request) {
            return $this->{$method}($model, $request);
        })->all();

        $request = $request ?? app('request');
        parse_str($request->getQueryString(), $appends);
        $paginated = $lengthAwarePaginator->appends($appends)->toArray();
        $response = [
            'items' => $data,
            'links' => $this->paginationLinks($paginated),
            'meta' => $this->meta($paginated),
        ];
        return $response;
    }

    /**
     * @param $collection
     * @param Request|null $request
     * @param null $method
     * @return mixed
     */
    public function transformCollection($collection, ? Request $request = null, $method = null)
    {
        if (! ($method && method_exists($this, $method))) {
            $method = 'transformCollected';
        }

        $data = $collection->map(function ($model) use ($method, $request) {
            return $this->{$method}($model, $request);
        })->all();

        return $data;
    }

    /**
     * @param $array
     * @param Request|null $request
     * @return mixed
     */
    public function transformArray($array, ? Request $request = null)
    {
        return $array;
    }

    /**
     * @param Model $model
     * @param Request|null $request
     * @return array
     */
    public function transformUpdatedModel(Model $model, ? Request $request = null)
    {
        $response = [
            'changes' => $model->getChanges(),
            'attributes' => $model->getAttributes(),
        ];
        return $response;
    }

    /**
     * @param Model $model
     * @param Request|null $request
     * @return array
     */
    public function transformDeletedModel(Model $model, ? Request $request = null)
    {
        $response = [
            'is_deleted' => ! $model->exists,
            'attributes' => $model->getAttributes(),
        ];
        return $response;
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function transformPaginated($model, ? Request $request = null)
    {
        return $this->transformModel($model, $request);
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function transformCollected($model, ? Request $request = null)
    {
        return $this->transformModel($model, $request);
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function transformModel($model, ? Request $request = null)
    {
        return $this->toArray($model, $request);
    }

    /**
     * @param $resource
     * @param Request|null $request
     * @return mixed
     */
    public function transformObject($resource, ? Request $request = null)
    {
        return $resource;
    }

    /**
     * @param $resource
     * @param Request|null $request
     * @return mixed
     */
    public function transformPlain($resource, ? Request $request = null)
    {
        return $resource;
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        return $model->toArray();
    }

    /**
     * Get the pagination links for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function paginationLinks($paginated)
    {
        return [
            'first' => $paginated['first_page_url'] ?? '',
            'last' => $paginated['last_page_url'] ?? '',
            'prev' => $paginated['prev_page_url'] ?? '',
            'next' => $paginated['next_page_url'] ?? '',
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }

    /**
     * @param $condition
     * @param null $value
     * @param null $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    public function whenNotNull($condition, $value = null, $default = null)
    {
        $count = count(func_get_args());
        if (1 == $count) {
            return $this->when(! is_null($condition), $condition);
        }

        if (2 == $count) {
            return $this->when(! is_null($condition), $value);
        }

        return $this->when(! is_null($condition), $value, $default);
    }

}