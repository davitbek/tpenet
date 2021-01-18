<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait ValidatorPropertyTrait
{
    /**
     * @var
     */
    protected $validator;

    /**
     * @var
     */
    protected $validatorClass;

    /**
     * @return string
     */
    protected function validatorClass()
    {
        return '';
    }

    /**
     * @param $validator
     * @param null $default
     * @return ValidatorPropertyTrait
     * @throws \Exception
     */
    protected function makeValidator($validator, $default = null)
    {
        if (is_null($validator)) {
            $className = $this->dynamicClassName("validator", "Validator");
            if (class_exists($className)) {
                $validator = App::make($className);
            } elseif($default) {
                $validator =  App::make($default);
            } elseif(property_exists($this, 'notNullable') && in_array($this->notNullable)) {
                throw new \Exception('please look validator property not nullable in : ' . get_class());
            }
        }

        return $this->setValidator($validator);
    }

    /**
     * @param $apiValidator
     * @return $this
     */
    public function setValidator($apiValidator)
    {
        $this->validator = $apiValidator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

}
