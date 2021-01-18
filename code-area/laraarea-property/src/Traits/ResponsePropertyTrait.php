<?php

namespace LaraAreaApi\Traits;

use LaraAreaApi\Http\Responses\BaseApiResponse;
use LaraAreaApi\Models\ApiModel;
use Illuminate\Support\Facades\App;
use LaraAreaApi\Services\ApiBaseService;
use LaraAreaSupport\Arr;
use LaraAreaValidator\AreaValidator;
use Illuminate\Support\Str;

trait ResponsePropertyTrait
{
    /**
     * @var
     */
    protected $modelClass;

    /**
     * @var
     */
    protected $serviceClass;

    /**
     * @var
     */
    protected $validatorClass;

    /**
     * @var
     */
    private $classMainName;

    /**
     * @param ApiModel $apiModel
     * @return $this
     */
    protected function setModel($apiModel)
    {
        if (is_null($apiModel)) {
            $modelName = $this->getClassName('model');
            $apiModel = App::make($modelName);
        }
        $this->model = $apiModel;
        return $this;
    }


    /**
     * @param $apiValidator
     * @return $this
     */
    protected function setValidator($apiValidator)
    {
        if (is_null($apiValidator)) {
            $validatorName = $this->getClassName('validator', AreaValidator::class);
            $apiValidator = App::make($validatorName);
        }
        $this->validator = $apiValidator;
        return $this;
    }

    /**
     * @param $apiService
     * @return $this
     */
    protected function setService($apiService)
    {
        if (is_null($apiService)) {
            $serviceName = $this->getClassName('service', ApiBaseService::class);
            $apiService = App::make($serviceName);
        }

        if (! $apiService->getModel()) {
            $apiService->setModel($this->model);
        }

        if (! $apiService->getValidator()) {
            $apiService->setValidator($this->validator);
        }
        $this->service = $apiService;
        return $this;
    }

    /**
     * @param $apiService
     * @return $this
     */
    protected function setResponse($apiResponse)
    {
        if (is_null($apiResponse)) {
            $responseName = $this->getClassName('response', BaseApiResponse::class);
            $apiResponse = App::make($responseName);
        }

        $this->response = $apiResponse;
        return $this;
    }

    /**
     * @param null $resource
     */
    protected function setResource($resource = null)
    {
        if ( ! is_null($resource)) {
            $this->resource = $resource;
        } elseif (empty($this->resource)) {
            if (! empty($this->service)) {
                $this->resource = $this->service->getResource();
            } else {
                $resource = basename(get_class($this));
                $resource = str_replace('Controller', '', $resource);
                $this->resource = lcfirst($resource);
            }
        }
    }
    /**
     * @param $pattern
     * @param null $default
     * @return mixed
     */
    public function getClassName($pattern, $default = null)
    {
        $propertyName = $pattern . 'Class';
        if (! empty($this->{$propertyName})) {
            return $this->{$propertyName};
        }

        $pattern = ucfirst($pattern);

        $namespace = $this->getRootNamespace();

        $className = $namespace . Str::plural($pattern) . '\\' . $this->getClassMainName();
        $className = 'Model' == $pattern ? $className : $className . $pattern;
        if ($default && ! class_exists($className)) {
            $className = $default;
        }

        $this->{$propertyName} = $className;
        return $this->{$propertyName};
    }

    /**
     * @return mixed
     */
    private function getRootNamespace()
    {
        if ($this->rootNamespace) {
            return $this->rootNamespace;
        }

        $class = get_class($this);
        $parts = explode('\\', $class);
        array_pop($parts);
        array_pop($parts);
        array_pop($parts);
        return $this->classRootPath = implode('\\', $parts) . '\\';
    }

    protected function getClassMainName()
    {
        if (empty($this->classMainName)) {
            $this->classMainName = Arr::last(explode("\\", get_class($this)));
            $this->classMainName = str_replace('Controller', '', $this->classMainName);
        }

        return $this->classMainName;
    }

    /**
     *
     */
    private function makeViewRoot()
    {
        if (empty($this->viewRoot)) {
            $this->viewRoot = lcfirst($this->getClassRootPath()) . '.pages';
        }
    }

    /**
     * @return mixed
     */
    private function getClassRootPath()
    {
        if ($this->classRootPath) {
            return $this->classRootPath;
        }

        $class = get_class($this);
        $parts = explode('\\', $class);
        array_pop($parts);
        return $this->classRootPath = array_pop($parts);
    }

    /**
     * @param $request
     * @param $result
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function downloadResponse($request, $result)
    {
        $path = storage_path(Str::random());
        file_put_contents($path, json_encode($result->toArray(), JSON_PRETTY_PRINT));
        $savePath = str_replace($request->root(), '', $request->fullUrl());
        $savePath = str_replace('/', '_', $savePath);
        $savePath = str_replace('\\', '_', $savePath);
        $savePath = str_replace(PHP_EOL, '_', $savePath);
        return response()->download($path, time() . $savePath . '.txt')->deleteFileAfterSend(true);;

    }

    /**
     * @param $data
     * @param array $errors
     * @param null $resource
     * @return array
     */
    protected function responseFormat($data, $errors = [], $resource = null)
    {
        $resource = $resource ?? $this->instance->getResource();
        $response = [
            'resource' => $resource,
            'result' => [$resource => $data]
        ];
        if ($errors) {
            $response['errors'] = $errors;
        }

        return $response;
    }
}
