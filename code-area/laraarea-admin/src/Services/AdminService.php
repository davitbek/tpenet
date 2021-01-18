<?php

namespace LaraAreaAdmin\Services;

use LaraAreaAdmin\Models\AdminModel;
use LaraAreaAdmin\Validators\AdminValidator;
use LaraAreaUpload\Traits\UploadProcessTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;

class AdminService
{
    use ForwardsCalls, UploadProcessTrait;

    /**
     * @var bool
     */
    protected $isMakeDynamic = true;

    /**
     * @var
     */
    protected $modelClass;

    /**
     * @var
     */
    protected $validatorClass;

    /**
     * @var  AdminModel | Builder | \Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $modelQuery;

    /**
     * @var
     */
    protected $resource;

    /**
     * @var AdminValidator
     */
    protected $validator;

    /**
     * @var
     */
    protected $validationErrors;

    protected $message;

    /**
     * AdminService constructor.
     */
    public function __construct()
    {
        if ($this->isMakeDynamic) {
            $this->makeModel();
            $this->makeValidator();
        }
    }

    /**
     *
     */
    protected function makeModel()
    {
        $modelClass = $this->getModelClass();
        $this->model = \App::make($modelClass);
        $this->modelQuery = $this->model->newQuery();
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
     * @return string
     */
    public function getValidatorClass()
    {
        if (empty($this->validatorClass)) {
            $this->validatorClass = str_replace('Service', 'Validator', get_class($this));
        }

        return $this->validatorClass;
    }

    /**
     *
     */
    protected function makeValidator()
    {
        $validatorClass = $this->getValidatorClass();

        if (class_exists($validatorClass)) {
            $this->validator = \App::make($validatorClass);
        }
    }

    /**
     * @param $callback
     */
    public function pushCriteria($callback)
    {
        $callback($this->modelQuery);
    }

    /**
     * @param null $group
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($group = null)
    {
        $group = $group ?? AdminModel::PAGINATE_GROUP;
        $data = $this->model->getPaginateAble(true, $group);
        $columns = $data['columns'];
        $search = $this->model->getPaginateAble(false, $group)->where('search', true);
        $searchValue = app('request')->get('search');

        $items = $this->modelQuery->select($columns)
            ->when($data['withCount'], function ($query) use ($data) {
                $query->withCount($data['withCount']);
            })->when($data['with'], function ($query) use ($data) {
                $query->with($data['with']);
            })->when($data['orderBy'], function ($q) use ($data) {
                foreach ($data['orderBy'] as $col => $order) {
                    $q->orderBy($col, $order);
                }
            })->when($searchValue && $search->isNotEmpty(), function ($q) use ($search, $searchValue) {
                $q->where(function ($q) use ($search, $searchValue) {
                    foreach ($search as $config) {
                        if (request('strict')) {
                            $q->orWhere($config['column'], $searchValue);
                        } else {
                            $q->orWhere($config['column'], 'like', '%' . $searchValue . '%');
                        }
                    }
                });
            })->when(request('advanced'), function ($q) use ($group) {
                $q->where(function ($q) use ($group) {
                    $searchDetails = $this->model->getPaginateAble(false, $group)->whereNotNull('searchDetails')->pluck('searchDetails');
                    foreach ($searchDetails as $config) {
                        $value = request($config['column']) ?? '';
                        if ($value) {
                            if (!empty($config['operation']) && $config['operation'] == 'whereIn') {
                                $values = array_filter(Arr::wrap($value));
                                if ($values) {
                                    $q->whereIn($config['column'], $values);
                                }
                            } else {
                                $q->where($config['column'], 'like', '%' . $value . '%');
                            }
                        }
                    }
                });
            })->paginate();

        $this->addPropertiesToPaginator($items, $group);
        return $items;
    }

    /**
     * @param $value
     * @param array $columns
     * @param string $column
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|Builder|mixed|object|null
     */
    public function find($value, $columns = ['*'], $column = null, $with = [])
    {
        $column = $column ?? $this->model->getRouteKeyName();
        if ($column == $this->model->getKeyName()) {
            return $this->modelQuery
                ->when($with, function ($q) use ($with) {
                    $q->with($with);
                })
                ->find($value, $columns);
        }
        return $this->modelQuery
            ->when($with, function ($q) use ($with) {
                $q->with($with);
            })->where($column, $value)
            ->first($columns);
    }

    /**
     * @param $data
     * @return AdminModel|bool|\Illuminate\Database\Eloquent\Builder|Model
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function create($data)
    {
        \DB::beginTransaction();

        if ($this->validate($data)) {
            $item = $this->_create($data);
            \DB::commit();
            return $item;
        }

        \DB::rollBack();

        return false;
    }

    /**
     * @param $data
     * @param null $with
     * @return AdminModel|\Illuminate\Database\Eloquent\Builder|Model
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function _create($data)
    {
        $data = $this->fixDataForCreate($data);
        $with = Arr::pull($data, 'with', []);
        $item = $this->model->create($data);

        if (is_a($item, get_class($this->model))) {
            $this->createRelations($item, $with);
            $this->itemCreated($item);
        }

        return $item;
    }

    /**
     * @param $id
     * @param $data
     * @return AdminModel|AdminModel[]|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|Builder|mixed|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function update($id, $data)
    {
        $data[$this->model->getKeyName()] = $id;
        $method = method_exists($this->validator, 'update') ? 'update' : 'create';

        if (!$this->validate($data, $method)) {
            return false;
        }

        $item = $this->model->find($id);
        if (empty($item)) {
            return false;
        }

        return $this->_update($item, $data);
    }

    /**
     * @param $item
     * @param $data
     * @param null $with
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function _update($item, $data)
    {
        $data = $this->fixDataForUpdate($item, $data);
        $with = Arr::pull($data, 'with', []);

        if ($item->update($data)) {
            $this->updateRelations($item, $with);
            $this->itemUpdated($item);
        }

        return $item;
    }

    /**
     * @param $items
     * @param $group
     */
    public function addPropertiesToPaginator($items, $group = AdminModel::PAGINATE_GROUP)
    {
        $items->paginateConfig = $this->model->getPaginateAble(false, $group);
        $items->model = $this->model;
        $items->actions = $this->model->getActions($group);
    }

    public function createRelations($item, $with)
    {
        $this->saveRelations($item, $with);
    }

    public function updateRelations($item, $with)
    {
        $this->saveRelations($item, $with);
    }

    public function saveRelations($item, $with)
    {

    }

    /**
     * @param $data
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function fixDataForCreate($data)
    {
        $uploadables = $this->getUploadable();
        foreach ($uploadables as $uploadCol) {
            $data = $this->upload($data, $uploadCol);
        }
        unset($data['_token']);
        return $data;
    }

    /**
     * @param $item
     * @param $data
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function fixDataForUpdate($item, $data)
    {
        $uploadables = $this->getUploadable();
        $this->model = $item; // @TODO tmp fix
        foreach ($uploadables as $uploadCol) {
            $data = $this->upload($data, $uploadCol);
            $newUploadValue = $data[$uploadCol] ?? null;
            if ($newUploadValue && $newUploadValue != $item->{$uploadCol}) {
                try {
                    // @TODO delete old images more good way
                    $oldDisk = $item->getUploadRelatedName($uploadCol . '_disk');
                    $oldDisk = $item->{$oldDisk};
                    \Storage::disk($oldDisk)->delete($item->getUploadFullPath($uploadCol));
                } catch (\Exception $exception) {
                }
            }
        }
        unset($data['_method']);
        unset($data['_token']);
        return $data;
    }

    /**
     * @param $data
     * @param string $options
     * @param null $validator
     * @return bool
     * @throws \Exception
     */
    public function validate($data, $options = 'create', $validator = null)
    {
        $validator = $validator ?? $this->validator;
        if (empty($validator)) {
            return true;
        }
        if ($validator->validate($data, $options)) {
            return true;
        }

        $this->setValidationErrors($validator->getErrors());
        return false;
    }

    /**
     * @param $errors
     * @return $this
     */
    public function setValidationErrors($errors)
    {
        $this->validationErrors = $errors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationErrorsErrors()
    {
        return $this->validationErrors;
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

    /**
     * @return string
     */
    public function getResource()
    {
        if (!empty($this->resource)) {
            return $this->resource;
        }

        if ($this->model) {
            return $this->resource = $this->model->getResource();
        }
        $className = class_basename($this);
        $className = str_replace('Service', '', $className);
        return $this->resource = Str::snake($className);
    }

    public function delete($id)
    {
        $model = $this->model->find($id, [$this->model->getKeyName()]);
        if ($model) {
            return $this->deleteExisting($model);
        }

        return $model;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function deleteExisting($model)
    {
        $deleted = $model->delete();
        if ($deleted) {
            $this->itemDeleted($model);
        }

        return $deleted;
    }

    /**
     * @return array
     */
    public function getUploadable()
    {
        return $this->model->getUploadable();
    }

    /**
     * @param $data
     * @return bool
     */
    public function storeDefaultUpload($data)
    {
        $uploadables = $this->getUploadable();
        foreach ($uploadables as $attribute) {
            $fileData = \Arr::get($data, $attribute);
            $file = $fileData['file'] ?? null;
            if ($file && is_a($file, UploadedFile::class)) {
                $this->model->uploadDefaultFile($file, $attribute, 'public');
            }
        }

        return true;
    }

    /**
     * @return AdminModel|\Illuminate\Database\Eloquent\Builder|Builder
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $item
     */
    protected function itemCreated($item)
    {
        $this->itemSaved($item);
    }

    /**
     * @param $item
     */
    protected function itemUpdated($item)
    {
        $this->itemSaved($item);
    }

    /**
     * @param $item
     */
    protected function itemSaved($item)
    {
    }

    /**
     * @param $item
     * @return mixed
     */
    protected function itemDeleted($item)
    {
        return $item;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
