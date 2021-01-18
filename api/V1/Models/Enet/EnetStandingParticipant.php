<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStandingParticipant
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $standing_id
 * @property int $participant_id
 * @property int $is_deleted
 * @property int $n
 * @property int $rank
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetProperty[] $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetStandingData[] $standing_data
 * @property-read int|null $standing_data_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereStandingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStandingParticipant extends BaseModel
{

    protected $table = 'enet_standing_participants';

    public $fillable = [
        'id',
        'standing_id',
        'participant_id',
        'is_deleted',
        'n',
        'rank',
    ];

    public function standing_data()
    {
        return $this->hasMany(EnetStandingData::class, 'standing_participants_id');
    }

    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(EnetProperty::class, 'object_id')->where('object', \ConstEnetObjectType::STANDING_PARTICIPANTS);
    }
}
