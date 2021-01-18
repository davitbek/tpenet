<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait ServicePropertyTrait
{
    /**
     * @var
     */
    protected $service;

    /**
     * @var
     */
    protected $serviceClass;

    /**
     * @return string
     */
    protected function serviceClass()
    {
        return '';
    }

    /**
     * @param $service
     * @param null $default
     * @return ServicePropertyTrait
     * @throws \Exception
     */
    protected function makeService($service, $default = null)
    {
        if (is_null($service)) {
            $className = $this->dynamicClassName("service", "Service");
            if (class_exists($className)) {
                $service = App::make($className);
            } elseif($default) {
                $service = App::make($default);
            } elseif(property_exists($this, 'isNullableProperty') && ! in_array($this->isNullableProperty)) {
                throw new \Exception('ServicePropertyTrait Something wrong in this: ' . get_class());
            }
        }

        return $this->setService($service);
    }

    /**
     * @param $apiService
     * @return $this
     */
    protected function setService($apiService)
    {
        $this->service = $apiService;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getService()
    {
        return $this->service;
    }

}
