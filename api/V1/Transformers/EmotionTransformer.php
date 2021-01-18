<?php

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

class EmotionTransformer extends BaseTransformer
{
    public function toArray($model, ? Request $request = null)
    {
        return [
            'id' => (int)$model->id,
            'name' => (string)$model->name,
            'image_url' => (string)asset($model->image_url),
            'image_url_for_box' => $this->when($model->id == 1, $model->image_liked_url),
            'json' => $this->whenNotNull($model->json, (array)json_decode($model->json))
        ];
    }

    /**
     * @param $models
     * @param Request|null $request
     * @return mixed
     */
    public function transformCollectionWithCount($models, ? Request $request = null)
    {
        return $models->groupBy('id')->transform(function ($_models) use ($request) {
            $result = $this->toArray($_models->first(), $request);
            $result['count'] = $_models->count();
            return $this->filter($result);
        })->values();
    }
}
