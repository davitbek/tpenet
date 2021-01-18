<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetLineup
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_participants_id
 * @property int $participant_id
 * @property int $lineup_type_id
 * @property int $shirt_number
 * @property int $pos
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Api\V1\Models\Enet\EnetEventParticipant $event_participant
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetParticipant $participant
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereLineupTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereShirtNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetLineup extends BaseModel
{
    protected $table = 'enet_lineups';

    protected $fillable = [
        'id',
        'event_participants_id',
        'participant_id',
        'lineup_type_id',
        'shirt_number',
        'pos',
        'n',
        'ut',
        'is_deleted'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_participant()
    {
        return $this->belongsTo(EnetEventParticipant::class, 'event_participants_id');
    }
}
