<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetLineupScopeResult
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $lineup_id
 * @property int $event_scope_id
 * @property int $scope_data_type_id
 * @property string|null $value
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereEventScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereLineupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereScopeDataTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupScopeResult whereValue($value)
 * @mixin \Eloquent
 */
class EnetLineupScopeResult extends BaseModel
{
    protected $table = 'enet_lineup_scope_results';

    protected $fillable = [
        'id',
        'lineup_id',
        'event_scope_id',
        'scope_data_type_id',
        'value',
        'is_deleted',
        'n',
    ];
}
