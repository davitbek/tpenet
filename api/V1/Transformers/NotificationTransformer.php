<?php

namespace Api\V1\Transformers;

use Api\V1\Models\Notification;
use Illuminate\Http\Request;

class NotificationTransformer extends BaseTransformer
{
    /**
     * @param Notification $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $type = config('app_settings')[$model->type]['type'] ?? 'system';
        $relatedId = config('app_settings')[$model->type]['related_id'] ?? 'related_id';
        return [
            'id' => $model->id,
            'title' => $model->getDataTranslatableAttribute('title'),
            'description' => $model->getDataTranslatableAttribute('description'),
            'profile_url' => $model->image_url ?? get_profile_white_url(),
            'date' => $model->created_at->toDateTimeString(),
            'read_at' => $model->read_at ? $model->read_at->toDateTimeString() : '',
            'type' => $type,
            'related_id' => $model->data[$relatedId] ?? '',
        ];
    }
}
