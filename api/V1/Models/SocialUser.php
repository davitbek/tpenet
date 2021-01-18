<?php

namespace Api\V1\Models;

/**
 * Class SocialUser
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property string $social_user_id
 * @property string $provider facebook, linkedin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read SocialUser $social_user
 * @property-read \Illuminate\Database\Eloquent\Collection|SocialUser[] $social_users
 * @property-read int|null $social_users_count
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereSocialUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialUser whereUserId($value)
 * @mixin \Eloquent
 */
class SocialUser extends BaseModel
{
    protected $fillable = [
        'user_id',
        'social_user_id',
        'provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function social_user()
    {
        return $this->belongsTo(SocialUser::class);
    }
    
    public function social_users()
    {
        return $this->hasMany(SocialUser::class);
    }
}
