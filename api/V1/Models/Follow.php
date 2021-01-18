<?php

namespace Api\V1\Models;

/**
 * Class Follow
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $follower_user_id the follower id
 * @property int|null $following_user_id who must be follow
 * @property string|null $date
 * @property-read \Api\V1\Models\User|null $follower_user
 * @property-read \Api\V1\Models\User|null $following_user
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowingUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereId($value)
 * @mixin \Eloquent
 */
class Follow extends BaseModel
{
    protected $table = 'followers';

    protected $fillable = [
        'follower_user_id',
        'following_user_id',
        'date'
    ];

    public $timestamps = false;

    public $selectableWith = [
        'index' => [
            'user',
            'follow_user',
        ],
        'show' => [
            'user',
            'follow_user',
        ],
    ];

    public $passableWith = [
        'create' => [
            'user',
            'follow_user',
        ],
        'update' => [
            'user',
            'follow_user',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function follower_user()
    {
        return $this->belongsTo(User::class, 'follower_user_id');
    }

    public function following_user()
    {
        return $this->belongsTo(User::class, 'following_user_id');
    }
}
