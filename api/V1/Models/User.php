<?php

namespace Api\V1\Models;

use App\Models\Traits\UserTrait;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Comment[] $commentEmotions
 * @property-read int|null $comment_emotions_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTip[] $tipEmotions
 * @property-read int|null $tip_emotions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTipStatistic[] $user_tip_statistics
 * @property-read int|null $user_tip_statistics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserTip[] $user_tips
 * @property-read int|null $user_tips_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedTipCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEditedLeagues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFeedbackRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNewsletter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOddsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordResetExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePromotions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipCashBackCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipLostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipWinCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTipWinPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereValidatedTipCount($value)
 * @mixin \Eloquent
 */
class User extends BaseModel
{
    use UserTrait, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'edited_sport_templates'
    ];

    protected $wrap = [
        'profile_url' => [
            'profile_disk',
            'profile_path',
        ]
    ];

    public $hidden = [
        'password',
    ];

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
    
    public function social_users()
    {
        return $this->hasMany(SocialUser::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    
    public function user_tip_statistics()
    {
        return $this->hasMany(UserTipStatistic::class);
    }

    public function user_tips()
    {
        return $this->hasMany(UserTip::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function read_news()
    {
        return $this->belongsToMany(News::class, 'news_user');
    }

    public function tipEmotions()
    {
        return $this->belongsToMany(UserTip::class, 'emotionables', 'user_id', 'emotionable_id')
            ->where('emotionable_type', (new UserTip())->getMorphClass());
    }

    public function commentEmotions()
    {
        return $this->belongsToMany(Comment::class, 'emotionables', 'user_id', 'emotionable_id')
            ->where('emotionable_type', (new Comment())->getMorphClass());
    }

    public function email_settings()
    {
        return $this->hasOne(EmailSetting::class);
    }

    public function notification_settings()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getDisk($attribute)
    {
        if (isset($this->attributes['profile_path']) && empty($this->attributes['profile_path'])) {
            return 's3';
        }

        return parent::getDisk($attribute);
    }
}
