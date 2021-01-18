<?php

namespace LaraAreaApi\Services\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;
use LaraAreaProperty\Traits\ValidatorPropertyTrait;
use LaraAreaValidator\AreaValidator;

trait ApiServiceValidationTrait
{
    use ValidatorPropertyTrait;

    /**
     * @var AreaValidator
     */
    protected $validator;

    /**
     * @var
     */
    protected $validationErrors;

    /**
     * @param $data
     * @param string $rules
     * @param null $validator
     * @param bool $throwException
     * @return bool
     * @throws \LaraAreaValidator\Exceptions\ValidationException | \Exception
     */
    public function validate($data, $rules = 'create', $validator = null, $throwException = true)
    {
        $validator = $validator ?? $this->validator;
        if (is_null($validator) && is_array($rules)) {
            $validator = App::make(AreaValidator::class);
        }
        if ($validator->validate($data, $rules, $throwException)) {
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
     * @return MessageBag
     */
    public function getValidationErrorsErrors()
    {
        return $this->validationErrors;
    }
}
