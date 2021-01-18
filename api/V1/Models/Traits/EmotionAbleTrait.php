<?php

namespace Api\V1\Models\Traits;

use Api\V1\Models\Emotion;
use Api\V1\Models\Emotionable;
use Api\V1\Models\User;

trait EmotionAbleTrait
{
    protected $emotionUserLimit = 5;

    public function emotions()
    {
        return $this->morphToMany(Emotion::class, 'emotionable')->withPivot('user_id');
    }

    public function emotionables()
    {
        return $this->hasMany(Emotionable::class, 'emotionable_id')->where('emotionable_type', $this->getMorphClass());
    }

    public function getEmotionsGroupedAttribute()
    {
        $grouped = collect();
        foreach ($this->emotions->groupBy('id') as $items) {
            $emotion = $items->first();
            $userIds = $items->pluck('pivot.user_id');
            $emotion->all_user_ids = $userIds->toArray();
            $emotion->load_user_ids = $userIds->slice(0, $this->emotionUserLimit ?? 10)->toArray();
            $grouped->push($emotion);
        }

        $loadUserIds = $grouped->pluck('load_user_ids')->collapse()->unique()->all();
        $users = User::whereIn('id', $loadUserIds)->pluck('name', 'id');
        foreach ($grouped as $emotion) {
            $emotionUsers = $users->only($emotion->load_user_ids)->all();
            if ($emotion->load_user_ids < $emotion->all_user_ids) {
                $emotionUsers[0] = '... Load more `income soon`';
            }
            $emotion->users = $emotionUsers;
        }

        return $grouped;
    }


}
