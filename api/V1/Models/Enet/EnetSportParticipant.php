<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetSportParticipant
 *
 * @package Api\V1\Models\Enet
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSportParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSportParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSportParticipant query()
 * @mixin \Eloquent
 */
class EnetSportParticipant extends BaseModel
{
    protected $table = 'enet_sport_participants';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'is_active',
        'sport_id',
        'participant_id',
        'participant_type',
        'date_from',
        'date_to',
        'ut',
    ];
}
