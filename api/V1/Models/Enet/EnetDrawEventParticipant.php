<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawEventParticipant
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $draw_event_id
 * @property int $participant_id
 * @property int $number
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereDrawEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetDrawEventParticipant extends BaseModel
{

    protected $table = 'enet_draw_event_participants';

    public $fillable = [
        'id',
        'draw_event_id',
        'participant_id',
        'number',
        'n',
        'is_deleted',
    ];

    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'participant_id');
    }
}
