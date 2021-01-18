<?php

namespace LaraAreaModel;

use Illuminate\Database\Eloquent\Model;
use LaraAreaModel\Traits\ArrayToQueryTrait;
use LaraAreaModel\Traits\ModelTrait;

class AreaModel extends Model
{
    use  ModelTrait, ArrayToQueryTrait;

    /**
     *
     */
    const PAGINATE_GROUP = 'index';

    /**
     * @var array
     */
    protected $paginateable = [];

    /**
     * @return mixed|string
     */
    public function getMorphClass()
    {
        return $this->getResource();
    }
}