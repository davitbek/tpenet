<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventScopeDetail
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_scope_id
 * @property int $n
 * @property int $is_deleted
 * @property string $del
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereEventScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventScopeDetail whereValue($value)
 * @mixin \Eloquent
 */
class EnetEventScopeDetail extends BaseModel
{
    protected $table = 'enet_event_scope_details';

    protected $fillable = [
        'id',
        'event_scope_id',
        'n',
        'is_deleted',
        'name',
        'value',
        'ut',
    ];
}
