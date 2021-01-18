<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait ResourceCollectionPropertyTrait
{
    /**
     * @var
     */
    protected $resourceCollection;

    /**
     * @var
     */
    protected $resourceCollectionClass;

    /**
     * @return string
     */
    protected function resourceCollectionClass()
    {
        return '';
    }

    /**
     * @param $resourceCollection
     * @param null $default
     * @return ResourceCollectionPropertyTrait
     * @throws \Exception
     */
    protected function makeResourceCollection($resourceCollection, $default = null)
    {
        if (is_null($resourceCollection)) {
            $className = $this->dynamicClassName("resourceCollection", "ResourceCollection");
            if (class_exists($className)) {
                $resourceCollection = App::make($className);
            } elseif($default) {
                $resourceCollection = App::make($default);
            } elseif(property_exists($this, 'isNullableProperty') && ! in_array($this->isNullableProperty)) {
                throw new \Exception('ResourceCollectionPropertyTrait Something wrong in this: ' . get_class());
            }
        }
        return $this->setResourceCollection($resourceCollection);
    }

    /**
     * @param $apiResourceCollection
     * @return $this
     */
    protected function setResourceCollection($apiResourceCollection)
    {
        $this->resourceCollection = $apiResourceCollection;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getResourceCollection()
    {
        return $this->resourceCollection;
    }

}
