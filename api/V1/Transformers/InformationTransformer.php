<?php

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

class InformationTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $model->translate();
        return [
            'id' => $model->id,
            'headline' => $model->headline_translated,
            'content' => $model->content_translated,
        ];
    }
}
