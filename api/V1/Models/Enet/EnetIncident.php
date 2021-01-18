<?php

namespace Api\V1\Models\Enet;

use App\Jobs\Notification\EventRedCardIncidentNotification;
use App\Jobs\Notification\EventGoalIncidentNotification;

/**
 * Class EnetIncident
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_participants_id
 * @property int $incident_type_id
 * @property string $incident_code
 * @property int $elapsed
 * @property int $sort_order
 * @property int $n
 * @property int $is_deleted
 * @property int $ref_participant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Api\V1\Models\Enet\EnetEventParticipant $event_participant
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetIncidentType $incident_type
 * @property-read \Api\V1\Models\Enet\EnetParticipant $participant
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetProperty[] $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereElapsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereIncidentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereIncidentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereRefParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncident whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetIncident extends BaseModel
{
    protected $table = 'enet_incidents';

    protected $fillable = [
        'id',
        'event_participants_id',
        'incident_type_id',
        'incident_code',
        'elapsed',
        'sort_order',
        'n',
        'ut',
        'is_deleted',
        'ref_participant_id'
    ];


    public static function boot()
    {
        parent::boot();

        self::saved(function ($item) {
            $keys = ['incident_code', 'event_participants_id', 'incident_type_id', 'elapsed'];
            $changes = $item->getChanges();

            if (($item->wasRecentlyCreated || array_keys_exists($keys, $changes)) && 'goal' == $item->incident_code) {
                if (!in_array($item->incident_type_id, [\ConstIncidentsType::PenaltyShootoutMissed, \ConstIncidentsType::PenaltyShootoutScored])) {
                    if ($changes) {
                       if (in_array('incident_type_id', $changes)) {
                           if (\ConstIncidentsType::CancelledGoal == $item->incident_type_id) {
                                dispatch(new EventGoalIncidentNotification($item));
                           }
                       }  else {
                            dispatch(new EventGoalIncidentNotification($item));
                       }
                    } else {
                        dispatch(new EventGoalIncidentNotification($item));
                    }
                }
            }

            if (($item->wasRecentlyCreated || array_keys_exists($keys, $changes)) && \ConstIncidentsType::RedCard == $item->incident_type_id) {
                dispatch(new EventRedCardIncidentNotification($item));
            }
        });
    }

    public function incident_type()
    {
        return $this->belongsTo(EnetIncidentType::class, 'incident_type_id');
    }

    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'ref_participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_participant()
    {
        return $this->belongsTo(EnetEventParticipant::class, 'event_participants_id');
    }

    public function properties()
    {
        return $this->hasMany(EnetProperty::class, 'object_id')->where('object', \ConstEnetObjectType::INCIDENT);
    }
}
