<?php

namespace LaraAreaModel;

use LaraAreaModel\Traits\ModelTrait;
use LaraAreaSupport\Traits\MorphTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AreaAuth extends Authenticatable
{
    use MorphTrait, ModelTrait;
    /**
     * @var array
     */
    const PAGINATE_GROUP = 'index';
}