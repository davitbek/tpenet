<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetIncidentResult
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $incident_id
 * @property int $result_type_id
 * @property int $event_participants_id
 * @property string $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereIncidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereResultTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentResult whereValue($value)
 * @mixin \Eloquent
 */
class EnetIncidentResult extends BaseModel
{
    protected $table = 'enet_incident_results';

    protected $fillable = [
        'id',
        'incident_id',
        'result_type_id',
        'event_participants_id',
        'value',
        'n',
        'is_deleted',
    ];
}
