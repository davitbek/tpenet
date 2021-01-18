<?php

namespace LaraAreaApi\Http\Controllers\Traits;

use LaraAreaProperty\Traits\ServicePropertyTrait;
use LaraAreaProperty\Traits\DynamicTrait;
use LaraAreaProperty\Traits\ModelPropertyTrait;
use LaraAreaProperty\Traits\TransformerPropertyTrait;
use LaraAreaProperty\Traits\ValidatorPropertyTrait;

trait AutoInsertTrait
{
    use ValidatorPropertyTrait,
        ServicePropertyTrait,
        TransformerPropertyTrait,
        DynamicTrait,
        ModelPropertyTrait;

    /**
     * @var
     */
    protected $resource_name;

    /**
     * @return string
     */
    protected function getRelativeNamespace()
    {
        // @TODO improve
        $parts = explode('\\', get_class($this));
        if (empty($parts[1] )) {
            $this->relativeNamespace = '';
        } else {
            $this->relativeNamespace = '\\' . $parts[1];
        }
        return  $this->relativeNamespace;
    }

    /**
     * @param $apiService
     * @return $this
     */
    protected function setService($apiService)
    {
        $this->service = $apiService;

        if (! $apiService->getModel()) {
            $apiService->setModel($this->model);
        }

        if (! $apiService->getValidator()) {
            $apiService->setValidator($this->validator);
        }

        return $this;
    }

    /**
     * @param null $resourceName
     * @return AutoInsertTrait
     */
    protected function makeResourceName($resourceName = null)
    {
        if (! is_null($resourceName)) {
            return $this->setResourceName($resourceName);
        }

        if (! empty($this->service)) {
            $resourceName = $this->service->getResourceName();
            return $this->setResourceName($resourceName);
        }

        $resource = basename(get_class($this));
        $resource = str_replace('Controller', '', $resource);
        $resourceName = lcfirst($resource);
        return $this->setResourceName($resourceName);
    }

    /**
     * @param $resourceName
     * @return $this
     */
    public function setResourceName($resourceName)
    {
        $this->resource_name  = $resourceName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourceName()
    {
        return $this->resource_name ;
    }
}
