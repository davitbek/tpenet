<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetVenueDataType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueDataType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetVenueDataType extends BaseModel
{

    protected $table = 'enet_venue_data_types';

    public $fillable = [
        'id',
        'name',
        'n',
        'ut',
        'is_deleted',
    ];

}
