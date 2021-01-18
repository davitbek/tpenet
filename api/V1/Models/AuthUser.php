<?php

namespace Api\V1\Models;

use App\Models\Traits\UserTrait;
use LaraAreaApi\Models\ApiAuth;

/**
 * Class AuthUser
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $country_id
 * @property string $is_active
 * @property string $is_flag
 * @property string $is_subscriber
 * @property int $role
 * @property string $feedback_rating
 * @property string|null $balance
 * @property string|null $tip_amount
 * @property string|null $tip_profit
 * @property int $tip_count
 * @property int $validated_tip_count
 * @property int $deleted_tip_count
 * @property int $tip_win_count
 * @property int $tip_lost_count
 * @property int $tip_cash_back_count
 * @property string|null $tip_win_percent
 * @property int $odds_type
 * @property string $timezone
 * @property string|null $lang
 * @property string|null $country
 * @property string $name
 * @property string|null $edited_sport_templates
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string|null $password_reset_expires_at
 * @property string|null $activation_token
 * @property string|null $profile_path
 * @property string|null $profile_disk
 * @property string $phone
 * @property string $bio
 * @property string|null $Newsletter
 * @property string|null $Promotions
 * @property string|null $birthday
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Api\V1\Models\EmailSetting|null $email_settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Follow[] $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Follow[] $followings
 * @property-read int|null $followings_count
 * @property-read mixed $cacheable_timestamp
 * @property-read string $profile_image
 * @property-read string $profile_url
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\UserNotificationSetting|null $notification_settings
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Purchase[] $purchases
 * @property-read int|null $purchases_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\News[] $read_news
 * @property-read int|null $read_news_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\SocialUser[] $social_users
 * @property-read int|null $social_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTipStatistic[] $user_tip_statistics
 * @property-read int|null $user_tip_statistics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTip[] $user_tips
 * @property-read int|null $user_tips_count
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereActivationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereDeletedTipCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereEditedLeagues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereFeedbackRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereIsFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereIsSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereNewsletter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereOddsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser wherePasswordResetExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereProfileDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereProfilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser wherePromotions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipCashBackCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipLostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipWinCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereTipWinPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthUser whereValidatedTipCount($value)
 * @mixin \Eloquent
 */
class AuthUser extends ApiAuth
{
    use  UserTrait;

    protected $table = 'users';

    protected $fillable = [
        'country_id',
        'is_active',
        'is_flag',
        'is_subscriber',
        'role',
        'feedback_rating',
        'balance',
        'tip_amount',
        'tip_profit',
        'tip_count',
        'validated_tip_count',
        'deleted_tip_count',
        'tip_win_count',
        'tip_lost_count',
        'tip_cash_back_count',
        'tip_win_percent',
        'odds_type',
        'timezone',
        'lang',
        'country',
        'name',
        'email',
        'password',
        'remember_token',
        'password_reset_expires_at',
        'activation_token',
        'profile_path',
        'profile_disk',
        'phone',
        'bio',
        'Newsletter',
        'Promotions',
        'birthday',
        'edited_sport_templates',
    ];

    protected $resource = 'users';

    /**
     * @return mixed|string
     */
    public function getMorphClass()
    {
        return $this->getResource();
    }

    public $hidden = [
        'password',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function read_news()
    {
        return $this->belongsToMany(News::class, 'news_user', 'user_id');
    }

    public function social_users()
    {
        return $this->hasMany(SocialUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_user_id');
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function user_tips()
    {
        return $this->hasMany(UserTip::class, 'user_id');
    }
    
    public function user_tip_statistics()
    {
        return $this->hasMany(UserTipStatistic::class);
    }

    /**
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return \ConstYesNo::YES == $this->is_active;
    }

    public function email_settings()
    {
        return $this->hasOne(EmailSetting::class, 'user_id');
    }

    public function notification_settings()
    {
        return $this->hasOne(UserNotificationSetting::class, 'user_id');
    }

    /**
     * @param $changes
     */
    public function mergeChanges($changes)
    {
        $this->changes = array_merge($this->changes, $changes);
    }

    /**
     * @return string
     */
    public function getLargeImagePath()
    {
        return $this->getUploadFolderPath('profile_path') . '/large';
    }

    /**
     * @return string
     */
    public function getOriginalPath()
    {
        return $this->getUploadFolderPath('profile_path') . '/original';
    }
}
