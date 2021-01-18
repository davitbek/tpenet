<?php

namespace Api\V1\Models;

/**
 * Class EmailSetting
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property int $news_product_update Product updates for new versions
 * @property int $news_tipya_partner Partner news for new partner relations
 * @property int $suggestions_recommended_accounts suggestion for user accounts to follow
 * @property int $research_surveys Tipya survey questions
 * @property int $missed_since_login When not logged in for a while send what users has missed
 * @property int $top_tips_matches Best tips
 * @property int $offers Offers for product
 * @property int $new_follower User get a new follower
 * @property int $tip_ended Users tip has ended
 * @property int $new_notification @TODO
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereMissedSinceLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereNewFollower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereNewNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereNewsProductUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereNewsTipyaPartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereOffers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereResearchSurveys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereSuggestionsRecommendedAccounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereTipEnded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereTopTipsMatches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereUserId($value)
 * @mixin \Eloquent
 */
class EmailSetting extends BaseModel
{
    protected $table = 'user_email_settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'news_product_update',
        'news_tipya_partner',
        'suggestions_recommended_accounts',
        'research_surveys',
        'missed_since_login',
        'top_tips_matches',
        'offers',
        'new_follower',
        'tip_ended',
        'new_notification',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
