<?php

namespace LaraAreaValidator\Exceptions;

use LaraAreaValidator\AreaValidator;
use Throwable;

class ValidationException extends \Exception
{
    /**
     * Error code
     *
     * @var
     */
    protected $errorCode;

    /**
     * @var AreaValidator
     */
    protected $validator;

    /**
     * ValidationException constructor.
     * @param $errorCode
     * @param $message
     * @param AreaValidator $validator
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($errorCode, $message, AreaValidator $validator, $code = 0, Throwable $previous = null)
    {
        $this->setValidator($validator);
        $this->setErrorCode($errorCode);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Set Validator
     *
     * @param AreaValidator $validator
     * @return $this
     */
    public function setValidator(AreaValidator $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Get validator
     *
     * @return AreaValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set error code
     *
     * @param $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * Get Error code
     *
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
