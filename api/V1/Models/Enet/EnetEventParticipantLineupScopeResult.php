<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventParticipantLineupScopeResult
 *
 * @package Api\V1\Models\Enet
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventParticipantLineupScopeResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventParticipantLineupScopeResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventParticipantLineupScopeResult query()
 * @mixin \Eloquent
 */
class EnetEventParticipantLineupScopeResult extends BaseModel
{
//    use SoftDeletes;

    protected $table = 'enet_event_participant_lineup_scope_results';

    public $fillable = [
        'id',
        'event_participant_lineup_id',
        'lineup_id',
        'event_scope_id',
        'scope_data_type_id',
        'value',
        'n',
        'ut',
    ];

}
