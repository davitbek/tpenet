<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetVenueType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenueType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetVenueType extends BaseModel
{

    protected $table = 'enet_venue_types';

    public $fillable = [
        'id',
        'name',
        'n',
        'ut',
        'is_deleted',
    ];

}
