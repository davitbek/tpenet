<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventIncidentTypeText
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_incident_type_id
 * @property int $n
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereEventIncidentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentTypeText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEventIncidentTypeText extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'enet_event_incident_type_texts';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'event_incident_type_id',
        'n',
        'name',
    ];
}
