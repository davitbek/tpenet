<?php

namespace LaraAreaValidator\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LaraAreaValidator\Rules\UniqueRule;
use LaraAreaValidator\ValidatorServiceProvider;

class AreaValidatorServiceProvider extends ValidatorServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $rule = new UniqueRule();
        Validator::extend($rule->getRule(), UniqueRule::class, $rule->message());


        $customClasses = [];
        $this->bootExtendedRules($customClasses);

        $this->extend('greaterOrEqual', function ($name, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            $property = $parameters[0];
            if (empty($data[$property])) {
                return true;
            }
            $validator->setFallbackMessages([Str::snake('greaterOrEqual') => __('validation.gte.numeric', ['value' => $data[$property]])]);
            return $value >= $data[$property];
        });

        $this->extend('different_when', function ($name, $value, $parameters, Validator $validator) {
            $data = $validator->getData();
            $property = $parameters[0];
            $propertyValue = $parameters[1];
            $attributeValue = $parameters[2] ?? $propertyValue;

            if ($attributeValue == $value && ! empty($data[$property]) && $data[$property] == $propertyValue) {
                if ($propertyValue != $attributeValue) {
                    $validator->setFallbackMessages(['different_when' => sprintf('Same time %s = %s and %s = %s is not permitted', $name, $attributeValue, $property, $propertyValue)]);
                } else {
                    $validator->setFallbackMessages(['different_when' => __('validation.different', ['other ' => $property])]);
                }

                return false;
            }
            return true;
        });

        $this->extend('uniqueTranslation', function ($name, $value, $parameters, $validator) {
            $data = $validator->getData();
            $modelName = array_shift($parameters);
            $model = new $modelName;

            return ! $model->where('parent_id', $data['parent_id'])
                ->where($name, $value)->when(! empty($data['id']), function ($q) use($data) {
                    $q->where('id', '!=', $data['id']);
                })->exists();
        });
    }

    /**
     * Register extended Rules
     *
     * @param array $extendedClasses
     */
    public function bootExtendedRules($extendedClasses = [])
    {
        foreach ($extendedClasses as $class) {
            $rule = (new $class);
            Validator::extend($rule->getRule(), $class, $rule->message());
        }
    }

    /**
     * Alias method for extend new rule
     *
     * @param $name
     * @param $callback
     */
    protected function extend($name, $callback)
    {
        Validator::extend($name, $callback);
    }
}
