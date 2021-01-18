<?php

namespace Api\V1\Transformers\Enet;

use App\Facades\AppCache;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnetEventTipTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        // TODO check maybe need delete
        return [
            'tip_id' => $model->id,
            'user_id' => $model->user_id,
            'user_name' => $model->user->name ?? 'User deleted',
            'follow_status' => AppCache::isFollow($model->user),
            'event_id' => $model->event_id,
            'game_style' => $model->sport_readable_id,
            'home_name' => $model->home_name,
            'away_name' => $model->away_name,
            'start_date_time' => ($model->event->start_date_timezone ?? $model->start_date_timezone)->toDateTimeString(),
            'league_name' => $model->league_name,
            'market_style' => $model->odds_type_name,
            'odd_style' => $model->odds_name,
            'odd' => $model->odds,
            'tip_amount' => number_format($model->tip_amount),
            'profile_url' => $model->user->profile_url ?? get_profile_white_url(),
            'home_image_url' => $model->home_image_url,
            'away_image_url' => $model->away_image_url,
            'result_status' => $this->whenNotNull($model->result_status),
            'comments_count' => $this->whenNotNull($model->comments_count),
            'emotions_count' => $this->whenNotNull($model->emotions_count),
//            'emotions' => $this->when($model->emotions, (new EmotionTransformer())->transformCollectionWithCount($model->emotions, $request)),
//            'reacted_emotion_id' => (int) ($model->emotions->where('pivot.user_id', Auth::guard('api')->id())->first()->id ?? null)
        ];
    }
}
