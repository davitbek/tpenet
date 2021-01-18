<?php

namespace Api\V1\Models;

use LaraAreaApi\Models\ApiAuth;

/**
 * Class AuthUser
 * @package Api\V1\Models
 */
class AuthUser extends ApiAuth
{
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
