<?php

namespace Api\V1\Transformers;

use Api\V1\Models\AuthUser;
use Illuminate\Http\Request;

class AuthUserTransformer extends \LaraAreaApi\Transformers\AuthTransformer
{
    /**
     * @param AuthUser $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $response = $model->toArray();

        if ($model->hasAttribute('access_tokens')) {
            $response['access_tokens'] = $model->access_tokens;
        }

        return $response;
    }
}
