<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventStatistic
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $enet_id
 * @property int $standing_id
 * @property int $rank
 * @property int $points
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereEnetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereStandingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventStatistic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEventStatistic extends BaseModel
{

    protected $table = 'enet_standing_participant_ranking_lights';
}
