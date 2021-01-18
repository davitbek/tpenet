<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventTip
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $user_id
 * @property int|null $event_id
 * @property int|null $sport_id
 * @property int|null $odds_provider_id
 * @property int|null $odds_type_id market_id in outcome_type_id in enetpulse
 * @property int|null $odds_id
 * @property int|null $home_id
 * @property int|null $away_id
 * @property string|null $odds
 * @property string|null $tip_amount
 * @property string|null $point
 * @property string|null $score
 * @property int|null $result_status
 * @property int|null $result_validation
 * @property string $provider
 * @property string|null $sport_readable_id
 * @property string $league_name
 * @property string|null $odds_type_name
 * @property string|null $odds_name
 * @property string $home_name
 * @property string $away_name
 * @property string $event_started_at
 * @property string|null $event_ends_at
 * @property string|null $validated_at
 * @property string|null $validation_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereAwayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereAwayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereEventEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereEventStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereHomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereHomeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereLeagueName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOddsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOddsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOddsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOddsTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereOddsTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereResultStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereResultValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereSportReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereTipAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereValidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventTip whereValidationDetails($value)
 * @mixin \Eloquent
 */
class EnetEventTip extends BaseModel
{

    protected $table = 'user_tips';
}
