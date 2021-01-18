<?php

namespace LaraAreaApi\Exceptions;

use Throwable;

class ApiException extends \Exception
{

    /**
     * @var
     */
    protected $errorCode;

    /**
     * ApiException constructor.
     * @param $message
     * @param $errorCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($errorCode,  $message, $code = 0, Throwable $previous = null)
    {
        if (0 == $code) {
            $code = config('laraarea_api.http_codes.validation', 401);
        }
        $this->setErrorCode($errorCode);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**]
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }


}
