<?php

namespace LaraAreaSeo\Providers;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use LaraAreaSupport\LaraAreaServiceProvider;

class ServiceProvider extends LaraAreaServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->mergeConfig(__DIR__);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        \Illuminate\Support\Facades\Validator::extend('greaterOrEqual', function ($name, $value, $parameters, Validator $validator) {
            $data = $validator->getData();
            $property = $parameters[0];
            if (empty($data[$property])) {
                return true;
            }
            $validator->setFallbackMessages([Str::snake('greaterOrEqual') => __('validation.gte.numeric', ['value' => $data[$property]])]);
            return $value >= $data[$property];
        });

        \Illuminate\Support\Facades\Validator::extend('different_when', function ($name, $value, $parameters, Validator $validator) {
            $data = $validator->getData();
            $property = $parameters[0];
            $propertyValue = $parameters[1];
            $attributeValue = $parameters[2] ?? $propertyValue;

            if ($attributeValue == $value && !empty($data[$property]) && $data[$property] == $propertyValue) {
                $validator->setFallbackMessages(['different_when' => sprintf('Same time %s = %s and %s = %s is not permitted', $name, $attributeValue, $property, $propertyValue)]);
                return false;
            }
            return true;
        });
    }
}

