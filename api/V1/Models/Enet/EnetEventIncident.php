<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventIncident
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_id
 * @property int $sport_id
 * @property int $event_incident_type_id
 * @property int $elapsed
 * @property int $elapsed_plus
 * @property string $comment
 * @property int $sort_order
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereElapsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereElapsedPlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereEventIncidentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncident whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEventIncident extends BaseModel
{
    protected $table = 'enet_event_incidents';

    protected $fillable = [
        'id',
        'event_id',
        'sport_id',
        'event_incident_type_id',
        'elapsed',
        'elapsed_plus',
        'comment',
        'sort_order',
        'is_deleted',
        'n',
    ];
}
