<?php

namespace LaraAreaModel\Exceptions;

use LaraAreaModel\Interfaces\CastInterface;
use RuntimeException;
use Throwable;

class CastException extends RuntimeException
{
    /**
     * CastException constructor.
     * @param $key
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($key, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $message = empty($message )
            ? sprintf('[%s] class cast must be instance of %s', $key, CastInterface::class)
            : $message;
        parent::__construct($message, $code, $previous);
    }
}
