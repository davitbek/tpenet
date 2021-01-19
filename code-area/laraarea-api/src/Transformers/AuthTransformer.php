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
        $response = $this->toArray($model, $request);

        if ($model->hasAttribute('access_tokens')) {
            $response['access_tokens'] = $model->access_tokens;
        }

        return $response;
    }
}
