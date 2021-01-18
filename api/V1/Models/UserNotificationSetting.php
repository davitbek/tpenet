<?php

namespace Api\V1\Models;

/**
 * Class UserNotificationSetting
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property string|null $ios_one_token
 * @property string|null $android_one_token
 * @property int $system
 * @property int|null $follow when one people start follow you
 * @property int|null $following_add_tips when your follower made new tip
 * @property int|null $tip_ended When you tip is ended and result is ready
 * @property int|null $football_before5
 * @property int|null $football_started
 * @property int|null $football_halftime_result
 * @property int|null $football_second_half_started
 * @property int|null $football_final_result
 * @property int|null $football_goals
 * @property int|null $football_red_cards
 * @property int|null $football_lineups
 * @property int|null $ice_hockey_before5
 * @property int|null $ice_hockey_started
 * @property int|null $ice_hockey_final_result
 * @property int|null $ice_hockey_goals
 * @property int|null $ice_hockey_lineups
 * @property int|null $tennis_before5
 * @property int|null $tennis_started
 * @property int|null $tennis_final_score
 * @property int|null $handball_before5
 * @property int|null $handball_started
 * @property int|null $handball_halftime_result
 * @property int|null $handball_second_half_started
 * @property int|null $handball_end_result
 * @property int|null $basketball_before5
 * @property int|null $basketball_started
 * @property int|null $basketball_end_result
 * @property int|null $baseball_before5
 * @property int|null $baseball_started
 * @property int|null $baseball_end_result
 * @property int|null $baseball_change_result
 * @property int|null $volleyball_before5
 * @property int|null $volleyball_started
 * @property int|null $volleyball_end_result
 * @property int|null $am_football_before5
 * @property int|null $am_football_stared
 * @property int|null $am_football_start_third_quarter
 * @property int|null $am_football_change_result
 * @property int|null $am_football_end_result
 * @property int|null $table_tennis_before5
 * @property int|null $table_tennis_started
 * @property int|null $table_tennis_end_result
 * @property int|null $esport_before5
 * @property int|null $esport_end_result
 * @property int|null $rugby_union_before5
 * @property int|null $rugby_union_started
 * @property int|null $rugby_union_halftime_result
 * @property int|null $rugby_union_second_half_started
 * @property int|null $rugby_union_change_result
 * @property int|null $rugby_union_end_result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAmFootballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAmFootballChangeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAmFootballEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAmFootballStared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAmFootballStartThirdQuarter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereAndroidOneToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBaseballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBaseballChangeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBaseballEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBaseballStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBasketballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBasketballEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereBasketballStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereEsportBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereEsportEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFollowingAddTips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballFinalResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballHalftimeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballLineups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballRedCards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballSecondHalfStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereFootballStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereHandballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereHandballEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereHandballHalftimeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereHandballSecondHalfStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereHandballStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIceHockeyBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIceHockeyFinalResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIceHockeyGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIceHockeyLineups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIceHockeyStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereIosOneToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionChangeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionHalftimeResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionSecondHalfStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereRugbyUnionStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTableTennisBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTableTennisEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTableTennisStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTennisBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTennisFinalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTennisStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereTipEnded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereVolleyballBefore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereVolleyballEndResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationSetting whereVolleyballStarted($value)
 * @mixin \Eloquent
 */
class UserNotificationSetting extends BaseModel
{
    protected $table = 'user_notification_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ios_one_token',
        'android_one_token',
        'system',
        'follow',
        'following_add_tips',
        'tip_ended',
        'football_before5',
        'football_started',
        'football_halftime_result',
        'football_second_half_result',
        'football_final_result',
        'football_goals',
        'football_red_cards',
        'football_lineups',
        'ice_hockey_before5',
        'ice_hockey_started',
        'ice_hockey_start_of_period',
        'ice_hockey_end_of_period',
        'ice_hockey_final_result',
        'ice_hockey_goals',
        'ice_hockey_lineups',
        'tennis_before5',
        'tennis_started',
        'tennis_end_of_set',
        'tennis_final_score',
        'handball_before5',
        'handball_started',
        'handball_halftime_result',
        'handball_second_half_started',
        'handball_end_result',
        'basketball_before5',
        'basketball_started',
        'basketball_end_of_quarter',
        'basketball_start_of_third_quarter',
        'basketball_end_result',
        'baseball_before5',
        'baseball_started',
        'baseball_end_result',
        'baseball_change_result',
        'volleyball_before5',
        'volleyball_started',
        'volleyball_end_set',
        'volleyball_end_result',
        'am_football_before5',
        'am_football_stared',
        'am_football_end_of_quarter',
        'am_football_start_third_quarter',
        'am_football_change_result',
        'am_football_end_result',
        'table_tennis_before5',
        'table_tennis_started',
        'table_tennis_end_set',
        'table_tennis_end_result',
        'esport_before5',
        'esport_end_result',
        'rugby_union_before5',
        'rugby_union_started',
        'rugby_union_halftime_result',
        'rugby_union_second_half_started',
        'rugby_union_change_result',
        'rugby_union_end_result',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
