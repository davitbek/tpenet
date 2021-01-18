<?php

namespace Api\V1\Models;

use Api\V1\Models\Enet\EnetEvent;

/**
 * Class UserFavoriteEnetEvent
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property int $is_enabled
 * @property string|null $created_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetEvent whereUserId($value)
 * @mixin \Eloquent
 */
class UserFavoriteEnetEvent extends BaseModel
{
    public $timestamps = false;

    protected $table = 'user_favorite_enet_event';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'is_enabled',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(EnetEvent::class, 'event_id');
    }
}
