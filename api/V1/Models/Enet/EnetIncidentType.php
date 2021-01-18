<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetIncidentType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $subtype
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetIncidentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetIncidentType extends BaseModel
{

    protected $table = 'enet_incident_types';

    public $fillable = [
        'id',
        'name',
        'subtype',
        'n',
        'ut',
        'is_deleted',
    ];

}
