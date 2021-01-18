<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetVenue
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $del
 * @property string $name
 * @property string $country_id
 * @property string $venue_type_id
 * @property string $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetVenue whereVenueTypeId($value)
 * @mixin \Eloquent
 */
class EnetVenue extends BaseModel
{
    protected $table = 'enet_venue';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'country_id',
        'venue_type_id',
        'details',
        'ut',
    ];
}
