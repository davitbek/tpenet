<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetScopeResult
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_participants_id
 * @property int $event_scope_id
 * @property int $scope_data_type_id
 * @property string|null $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereEventScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereScopeDataTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeResult whereValue($value)
 * @mixin \Eloquent
 */
class EnetScopeResult extends BaseModel
{
    protected $table = 'enet_scope_results';

    protected $fillable = [
        'id',
        'event_participants_id',
        'event_scope_id',
        'scope_data_type_id',
        'value',
        'n',
        'is_deleted',
    ];
}
