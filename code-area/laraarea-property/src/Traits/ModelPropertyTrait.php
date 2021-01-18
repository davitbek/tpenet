<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait ModelPropertyTrait
{
    /**
     * @var
     */
    protected $modelClass;

    /**
     * @var
     */
    protected $model;

    /**
     * @return string
     */
    protected function modelClass()
    {
        return '';
    }

    /**
     * @param $model
     * @return $this
     */
    protected function makeModel($model)
    {
        if (is_null($model)) {
            $className = $this->dynamicClassName('model');
            $model = App::make($className);
        }

        return $this->setModel($model);
    }

    /**
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

}
