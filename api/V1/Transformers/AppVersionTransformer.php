<?php

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

class AppVersionTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        return [
            'id' => $model->id,
            'ios' => (bool) $model->is_active_ios,
            'android' => (bool) $model->is_active_android,
            'version' => (string) $model->version,
            'name' => (string) $model->name,
            'description' => (string) $model->description,
            'maintenance' => (int) $model->maintenance,
            'maintenance_text' => (string) $model->maintenance_text,
        ];
    }
}
