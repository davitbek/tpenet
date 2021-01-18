<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetVenueData
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string|null $value
 * @property int $venue_data_type_id
 * @property int $venue_id
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereVenueDataTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueData whereVenueId($value)
 * @mixin \Eloquent
 */
class EnetVenueData extends BaseModel
{
    protected $table = 'enet_venue_data';

    protected $fillable = [
        'id',
        'value',
        'venue_data_type_id',
        'venue_id',
        'is_deleted',
        'n',
        'ut',
    ];
}
