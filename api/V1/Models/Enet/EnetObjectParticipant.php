<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetObjectParticipant
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property int $is_active
 * @property string|null $object
 * @property int $object_id
 * @property int $participant_id
 * @property string $participant_type
 * @property string|null $date_from
 * @property string|null $date_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetParticipant $participant
 * @property-read \Api\V1\Models\Enet\EnetParticipant $team
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereParticipantType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetObjectParticipant extends BaseModel
{
    protected $table = 'enet_object_participants';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'is_active',
        'object',
        'object_id',
        'participant_id',
        'participant_type',
        'date_from',
        'date_to',
        'ut',
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
    public function team()
    {
        return $this->belongsTo(EnetParticipant::class, 'object_id');
    }
}
