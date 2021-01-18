<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatsLive
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $stat_rules_id
 * @property int $participant_id
 * @property int $event_id
 * @property int $team_id
 * @property string $trigger_type
 * @property int $matchcount
 * @property string $value
 * @property float $value_div_matchcount
 * @property int $incident_id
 * @property int $outcome_id
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereIncidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereMatchcount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereOutcomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereStatRulesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereTriggerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatsLive whereValueDivMatchcount($value)
 * @mixin \Eloquent
 */
class EnetStatsLive extends BaseModel
{

    protected $table = 'enet_stats_live';

    public $fillable = [
        'id',
        'stat_rules_id',
        'participant_id',
        'event_id',
        'team_id',
        'trigger_type',
        'matchcount',
        'value',
        'value_div_matchcount',
        'incident_id',
        'outcome_id',
        'n',
        'is_deleted',
    ];

}
