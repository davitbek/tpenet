<?php

namespace Api\V1\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WhereScope implements Scope
{
    /**
     * @var
     */
    protected $column;

    /**
     * @var
     */
    protected $operator;

    /**
     * @var
     */
    protected $value;

    /**
     * WhereScope constructor.
     * @param $column
     * @param null $operator
     * @param null $value
     */
    public function __construct($column, $operator = null, $value = null)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where( $this->column, $this->operator, $this->value);
    }
}