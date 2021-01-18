<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait ResourcePropertyTrait
{
    /**
     * @var
     */
    protected $resource;

    /**
     * @var
     */
    protected $resourceClass;

    /**
     * @return string
     */
    protected function resourceClass()
    {
        return '';
    }

    /**
     * @param $resource
     * @param null $default
     * @return ResourcePropertyTrait
     * @throws \Exception
     */
    protected function makeResource($resource, $default = null)
    {
        if (is_null($resource)) {
            $className = $this->dynamicClassName("resource", "Resource");
            if (class_exists($className)) {
                $resource = App::make($className);
            } elseif($default) {
                $resource = App::make($default);
            } elseif(property_exists($this, 'isNullableProperty') && ! in_array($this->isNullableProperty)) {
                throw new \Exception('ResourcePropertyTrait Something wrong in this: ' . get_class());
            }
        }
        return $this->setResource($resource);
    }

    /**
     * @param $apiResource
     * @return $this
     */
    protected function setResource($apiResource)
    {
        $this->resource = $apiResource;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getResource()
    {
        return $this->resource;
    }

}
