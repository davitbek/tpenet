<?php

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

class EmotionPivotTransformer extends BaseTransformer
{
    public function toArray($model, ? Request $request = null)
    {
        return [
            'user_id' => (int)$model->user_id,
            'emotion_id' => (int)$model->emotion_id,
            'emotionable_id' => (int)$model->emotionable_id,
            'emotionable_type' => (string)$model->emotionable_type,
        ];
    }
}
