<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatusDescription
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $status_type
 * @property int $map_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereMapTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereStatusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatusDescription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStatusDescription extends BaseModel
{
    protected $table = 'enet_status_descriptions';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'status_type',
        'map_to',
        'ut',
    ];

}
