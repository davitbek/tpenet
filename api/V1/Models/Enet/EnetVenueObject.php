<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetVenueObject
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $object_type_id
 * @property int $object_id
 * @property int $venue_id
 * @property int $is_neutral
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereIsNeutral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereObjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueObject whereVenueId($value)
 * @mixin \Eloquent
 */
class EnetVenueObject extends BaseModel
{

    protected $table = 'enet_venue_objects';

    public $fillable = [
        'id',
        'object_type_id',
        'object_id',
        'venue_id',
        'is_neutral',
        'is_deleted',
        'n',
    ];

}
