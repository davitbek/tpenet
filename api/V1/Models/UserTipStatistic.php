<?php

namespace Api\V1\Models;

/**
 * Class UserTipStatistic
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property int $user_percentage_position
 * @property int $user_profit_position
 * @property int $percentage_position
 * @property int $profit_position
 * @property int $type values 1 => monthly, 2 => yearly, 3 => weekly, 4 => daily, 5 quarter
 * @property string $period
 * @property string|null $balance
 * @property string|null $amount
 * @property string|null $profit
 * @property int $count
 * @property int $validated_count
 * @property int $deleted_count
 * @property int $defer_count event defer other month
 * @property int $past_count event play this month but tip added past months
 * @property int $win_count
 * @property int $lost_count
 * @property int $cash_back_count
 * @property string|null $win_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereCashBackCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereDeferCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereDeletedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereLostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic wherePastCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic wherePercentagePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereProfitPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereUserPercentagePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereUserProfitPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereValidatedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereWinCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTipStatistic whereWinPercent($value)
 * @mixin \Eloquent
 */
class UserTipStatistic extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_percentage_position',
        'user_profit_position',
        'percentage_position',
        'profit_position',
        'type',
        'period',
        'balance',
        'amount',
        'profit',
        'count',
        'validated_count',
        'deleted_count',
        'defer_count',
        'past_count',
        'win_count',
        'lost_count',
        'cash_back_count',
        'win_percent',
    ];

    public $selectableWith = [
        'index' => [
            'user',
        ],
        'show' => [
            'user',
        ],
    ];

    public $passableWith = [
        'create' => [
            'user',
        ],
        'update' => [
            'user',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
