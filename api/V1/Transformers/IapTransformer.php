<?php

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

class IapTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        return [
            'id' => (int) $model->id,
            'text_color' => (string) $model->text_color,
            'border_color' => (string) $model->border_color,
            'bg_color' => (string) $model->bg_color
        ];
    }
}
