<?php

namespace LaraAreaValidator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Traits\ForwardsCalls;
use LaraAreaValidator\Exceptions\ValidationException;

class AreaValidator
{
    use ForwardsCalls;

    /**
     * Validation errors
     *
     * @var
     */
    protected $errors;

    /**
     * @var Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Incoming data for validate
     *
     * @var
     */
    protected $data;

    /**
     * Eloquent model
     *
     * @var Model
     */
    protected $model;

    /**
     * Validate incoming data
     *
     * @param $data
     * @param string $options
     * @param bool $throwExeption
     * @return bool
     * @throws \Exception
     */
    public function validate($data, $options = 'create', $throwExeption = false)
    {
        $this->data = $data;
        if (is_string($options)) {
            $rules = $this->{$options}($data);
        } elseif(is_array($options)) {
            $rules = $options;
        } else {
            throw new \Exception('Incorrect Validator attribute');
        }

        $this->validator = Validator::make($data, $rules);

        if (! $this->validator->fails()) {
            return true;
        }

        if ($throwExeption) {
            throw new ValidationException(401, 'Validation error', $this);
        }

        $this->setErrors($this->validator->getMessageBag());
        return false;
    }

    /**
     * Make Validator
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return LaraAreaValidator
     */
    protected function makeValidator(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $factory = \App::make(\Illuminate\Validation\Factory::class);
        return $factory->make($data, $rules, $messages, $customAttributes);
    }

    /**
     * Set validation errors
     *
     * @param MessageBag $errors
     * @return $this
     */
    public function setErrors(MessageBag $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Get validation errors
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set Model
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get Model
     *
     * @param $model
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Validation extend rule
     *
     * @param $ruleName
     * @param $extension
     * @param null $message
     * @return mixed
     */
    public function extend($ruleName, $extension, $message = null)
    {
        Validator::extend($ruleName, $extension, $message);
        return $ruleName;
    }

    /**
     * Format for extended rule
     *
     * @param $ruleClass
     * @param mixed ...$params
     * @return string
     */
    protected function customRule($ruleClass, ...$params)
    {
        return (new $ruleClass)->getRule() . ':' . implode(',', $params);
    }

    /**
     * Add new data in validation data
     *
     * @param $add
     * @return array
     */
    public function addData($add)
    {
        $data = $this->validator->getData();
        $data = array_merge($data, $add);
        return $this->data = $data;
    }

    /**
     * Get validation data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->forwardCallTo($this->validator, $name, $arguments);
    }
}
