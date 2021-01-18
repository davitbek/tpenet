<?php

namespace LaraAreaModel;

use LaraAreaModel\Interfaces\CastInterface;

class Cast implements CastInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function handle($value)
    {
        return $value;
    }
}