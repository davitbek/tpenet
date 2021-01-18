<?php

namespace LaraAreaModel\Interfaces;

interface CastInterface
{
    /**
     * You can modify value
     *
     * @param $value
     * @return mixed
     */
    public function handle($value);
}