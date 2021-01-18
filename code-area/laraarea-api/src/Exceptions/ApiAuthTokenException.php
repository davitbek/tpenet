<?php

namespace LaraAreaApi\Exceptions;

use Throwable;

class ApiAuthTokenException extends ApiException
{
    /**
     * @var
     */
    protected $errors;

    /**
     * ApiValidationException constructor.
     * @param $message
     * @param $errors
     * @param $errorCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($errorCode, $message, $errors,  $code = 0, Throwable $previous = null)
    {
        if (0 == $code) {
            $code = config('laraarea_api.http_codes.validation', 401);
        }
        $this->setErrors($errors);
        parent::__construct($errorCode, $message, $code, $previous);
    }

    /**
     * @param $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
