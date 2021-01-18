<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventScope
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_id
 * @property int $scope_type_id
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereScopeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScope whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEventScope extends BaseModel
{
    protected $table = 'enet_event_scopes';

    protected $fillable = [
        'id',
        'event_id',
        'scope_type_id',
        'n',
        'is_deleted',
        'ut',
    ];
}
