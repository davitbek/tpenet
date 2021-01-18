<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventIncidentDetail
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $type
 * @property int $event_incident_id
 * @property int $participant_id
 * @property string $value
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereEventIncidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentDetail whereValue($value)
 * @mixin \Eloquent
 */
class EnetEventIncidentDetail extends BaseModel
{
    protected $table = 'enet_event_incident_details';

    protected $fillable = [
        'id',
        'type',
        'event_incident_id',
        'participant_id',
        'value',
        'is_deleted',
        'n',
    ];
}
