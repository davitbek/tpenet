<?php

namespace Api\V1\Transformers;

use App\Facades\AppCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentTransformer extends BaseTransformer
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
            'comment' => (string) $model->comment,
            'created_at' => (string) $model->created_at,
            'sub_comments_count' => $this->when(! is_null($model->sub_comments_count), (int) $model->sub_comments_count),
            'sub_comments' => $this->when($model->relationLoaded('sub_comments'), (array) $this->transform($model->sub_comments)),
            'user' => $this->when($model->user, [
                'id' => $model->user->id,
                'name' => $model->user->name,
                'profile_url' => $model->user->profile_url,
                'follow_status' => AppCache::isFollow($model->user),
            ]),
            'emotions_count' => $this->whenNotNull($model->emotions_count),
            'emotions' => $this->when($model->emotions, (new EmotionTransformer())->transformCollectionWithCount($model->emotions, $request)),
            'reacted_emotion_id' => (int) ($model->emotions->where('pivot.user_id', Auth::guard('api')->id())->first()->id ?? null)
        ];
    }
}
