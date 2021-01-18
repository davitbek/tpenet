<?php

namespace LaraAreaApi\Transformers;

use Illuminate\Http\Request;
use \LaraAreaTransformer\Transformer;

class AuthTransformer extends Transformer
{
    /**
     * @param $model
     * @param Request $request
     * @return array|mixed
     */
    public function transformRegistered($model, Request $request)
    {
        return $this->toArray($model, $request);
    }
}