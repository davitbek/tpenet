<?php

namespace Api\V1\Models;

/**
 * Class Emotion
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $position
 * @property string|null $name
 * @property string|null $key
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string|null $json
 * @property string|null $json_disk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $image_liked_url
 * @property-read mixed $image_url
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTip[] $tips
 * @property-read int|null $tips_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereJsonDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Emotion extends BaseModel
{
    public function tips()
    {
        return $this->morphedByMany(UserTip::class, 'emotionable')
            ->using(EmotionablePivot::class)
            ->withPivot(['user_id']);
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'emotionable')
            ->using(EmotionablePivot::class)
            ->withPivot(['user_id']);
    }

    public function getImageUrlAttribute()
    {
        return asset('images/emotions/'  . $this->image_path);
    }

    public function getImageLikedUrlAttribute()
    {
        return asset('images/emotions/normal.png');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'emotionables');
    }
}
