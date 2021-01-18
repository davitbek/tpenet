<?php

namespace Api\V1\Models;

use Api\V1\Models\Enet\EnetParticipant;

/**
 * Class UserFavoriteEnetParticipant
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property int $participant_id
 * @property string $participant_type
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read EnetParticipant $participant
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant whereParticipantType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavoriteEnetParticipant whereUserId($value)
 * @mixin \Eloquent
 */
class UserFavoriteEnetParticipant extends BaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'user_favorite_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'participant_id',
        'participant_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'participant_id');
    }
}
