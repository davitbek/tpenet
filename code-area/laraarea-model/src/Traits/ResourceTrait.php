<?php

namespace LaraAreaModel\Traits;

trait ResourceTrait
{
    /**
     * @var
     */
    protected $resource;

    /**
     * Set Resource
     *
     * @param $resource
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * Get Resource
     *
     * @return mixed
     */
    public function getResource()
    {
        return ! empty($this->resource) ? $this->resource : $this->getTable();
    }
}