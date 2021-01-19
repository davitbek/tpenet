<?php

namespace LaraAreaApi\Services;

use Illuminate\Support\Facades\Auth;
use LaraAreaApi\Exceptions\ApiException;
use LaraAreaApi\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use LaraAreaApi\Services\Traits\ApiServiceValidationTrait;
use LaraAreaProperty\Traits\ModelPropertyTrait;

class ApiBaseService
{
    use ForwardsCalls, ModelPropertyTrait, ApiServiceValidationTrait;

    /**
     * @var
     */
    protected $modelClass;

    /**
     * @var
     */
    protected $validatorClass;

    /**
     * @var  ApiModel| Model | Builder | \Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @var
     */
    protected $errorCode;

    /**
     * @var
     */
    protected $errorMessage;

    /**
     * ApiBaseService constructor.
     * @param null $model
     * @param null $validator
     */
    public function __construct($model = null, $validator = null)
    {
        if (! is_null($model)) {
            $this->setModel($model);
        }
        if (! is_null($validator)) {
            $this->setValidator($validator);
        }
    }

    /**
     * @throws \Exception
     */
    protected function makeModel()
    {
        $modelClass = $this->getModelClass();

        if (! class_exists($modelClass)) {
            throw new \Exception("Please make [$modelClass]@TODO CODE");
        }

        $this->model = \App::make($modelClass);
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        if (empty($this->modelClass)) {
            $this->modelClass = Str::replaceFirst('Service', 'Model', get_class($this));
            $this->modelClass = Str::replaceFirst('Service', '', $this->modelClass);
        }

        return $this->modelClass;
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function index($data)
    {
        if (empty($data['all'])) {
            $data['paginate'] = true;
        }

        $result = $this->model->getByArray($data);
        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @param null $key
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|int|mixed|object|null
     */
    public function findByArray($id, $data, $key = null)
    {
        $key = $key ?? $this->model->getKeyName();
        $data['where'][$key] = $id;
        $data['first'] = true;
        $result = $this->model->getByArray($data);
        return $result;
    }

    /**
     * @param string $guard
     * @return int|string|null
     */
    public function getAuthUserId($guard = 'api')
    {
        return Auth::guard($guard)->id();
    }

    /**
     * @param string $guard
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getAuth($guard = 'api')
    {
        return Auth::guard($guard)->user();
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function create($data)
    {
        if (method_exists($this->validator, 'create')) {
            $this->validate($data, 'create', $this->validator);
        } elseif(method_exists($this, 'createRules')) {
            $this->validate($data, $this->createRules(), $this->validator);
        }

        return $this->_create($data);
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public function _create($data)
    {
        $with = Arr::pull($data, 'with', []);
        $data = $this->fixDataForCreate($data);
        $item = $this->model->create($data);

        if (is_a($item, get_class($this->model))) {
            $this->createRelations($item, $with);
        }

        return $item;
    }

    /**
     * @param $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|Builder|mixed|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param $data
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|Builder|mixed|null
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function update($id, $data)
    {
        $with = Arr::pull($data, 'with', []);
        $method = method_exists($this->validator, 'update') ? 'update' : 'create';
        if (! $this->validate($data, $method)) {
            return false;
        }

        $item = $this->model->find($id);
        if (empty($item)) {
            return false;
        }

        $data = $this->fixDataForUpdate($data, $item);
        if ($item->update($data)) {
            $this->updateRelations($item, $with);
        }

        return $item;
    }

    /**
     * @param Model $model
     * @param $data
     * @return mixed
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function updateExisting(Model $model, $data)
    {
        $method = method_exists($this->validator, 'update') ? 'update' : 'create';
        $this->validate($data, $method);
        return $this->_updateExisting($model, $data);
    }

    /**
     * @param $model
     * @param $data
     * @return mixed
     */
    public function _updateExisting($model, $data)
    {
        $with = Arr::pull($data, 'with', []);
        $data = $this->fixDataForUpdate($data, $model);
        $updatedData = collect($data)->only($model->getFillable())->all();

        if ($model->update($updatedData)) {
            $this->updateRelations($model, $with);
        }

        return $model;
    }

    /**
     * @param $id
     * @return Model
     * @throws ApiException | \Exception
     */
    public function delete($id)
    {
        $item = $this->model->find($id);

        if (empty($item)) {
            throw new ApiException(laraarea_api_error_code('not_found'), $this->getResourceName() . ' is invalid');
        }

        return $this->deleteExisting($item);
    }

    /**
     * @param Model $item
     * @return Model
     * @throws \Exception
     */
    public function deleteExisting($item)
    {
        $item->delete();
        return $item;
    }

    /**
     * @param $item
     * @param $with
     */
    public function createRelations($item, $with) {

    }

    /**
     * @param $item
     * @param $with
     */
    public function updateRelations($item, $with)
    {

    }

    /**
     * @param $data
     * @return mixed
     */
    protected function fixDataForCreate($data)
    {
        unset($data['_token']);
        return $data;
    }

    /**
     * @param $data
     * @param $item
     * @return mixed
     */
    protected function fixDataForUpdate($data, $item)
    {
        unset($data['_method']);
        unset($data['_token']);
        return $data;
    }

    /**
     * @param $errorCode
     * @param $message
     * @return $this
     */
    public function setErrorDetails($errorCode, $message)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrorDetails()
    {
        return [$this->errorCode , $this->errorMessage];
    }

    /**
     * @return mixed
     */
    public function getResourceName()
    {
        return $this->model->getResource();
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->model, $method, $parameters);
    }
}
