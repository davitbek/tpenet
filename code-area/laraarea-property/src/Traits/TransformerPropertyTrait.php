<?php

namespace LaraAreaProperty\Traits;

use Illuminate\Support\Facades\App;

trait TransformerPropertyTrait
{
    /**
     * @var
     */
    protected $transformer;

    /**
     * @var
     */
    protected $transformerClass;

    /**
     * @return string
     */
    protected function transformerClass()
    {
        return '';
    }

    /**
     * @param $transformer
     * @param null $default
     * @return TransformerPropertyTrait
     * @throws \Exception
     */
    protected function makeTransformer($transformer, $default = null)
    {
        if (is_null($transformer)) {
            $className = $this->dynamicClassName("transformer", "Transformer");
            if (class_exists($className)) {
                $transformer = App::make($className);
            } elseif($default) {
                $transformer = App::make($default);
            } elseif(property_exists($this, 'isNullableProperty') && ! in_array($this->isNullableProperty)) {
                throw new \Exception('TransformerPropertyTrait Something wrong in this: ' . get_class());
            }
        }
        return $this->setTransformer($transformer);
    }

    /**
     * @param $apiTransformer
     * @return $this
     */
    protected function setTransformer($apiTransformer)
    {
        $this->transformer = $apiTransformer;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getTransformer()
    {
        return $this->transformer;
    }

}
