<?php

namespace Api\V1\Models;

use Api\V1\Models\Archived\ArchivedBettingOffer;
use Api\V1\Models\Archived\ArchivedOutcome;
use Api\V1\Models\Enet\EnetBettingOffer;
use Api\V1\Models\Enet\EnetEvent;
use Api\V1\Models\Enet\EnetOddsProvider;
use Api\V1\Models\Enet\EnetOutcome;
use Api\V1\Models\Enet\EnetParticipant;
use Api\V1\Models\Traits\CommentAbleTrait;
use Api\V1\Models\Traits\EmotionAbleTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Traits\Models\TimeTrait;

/**
 * Class UserTip
 *
 * @package Api\V1\Models
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
 * @property array|null $validation_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read ArchivedBettingOffer|null $archived_betting_offer
 * @property-read ArchivedOutcome|null $archived_outcome
 * @property-read EnetParticipant|null $away_team
 * @property-read EnetBettingOffer|null $betting_offer
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Emotionable[] $emotionables
 * @property-read int|null $emotionables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Emotion[] $emotions
 * @property-read int|null $emotions_count
 * @property-read EnetBettingOffer|null $enet_betting_offer
 * @property-read EnetOutcome|null $enet_outcome
 * @property-read EnetEvent|null $event
 * @property-read string $away_image_url
 * @property-read string $away_name_translated
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $emotions_grouped
 * @property-read string $home_image_url
 * @property-read string $home_name_translated
 * @property-read mixed $start_date_timezone
 * @property-read mixed $url_by
 * @property-read EnetParticipant|null $home_team
 * @property-read EnetOddsProvider|null $odds_provider
 * @property-read EnetOutcome|null $outcome
 * @property-read \Api\V1\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\User[] $userEmotions
 * @property-read int|null $user_emotions_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserTip onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereAwayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereAwayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereEventEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereEventStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereHomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereHomeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereLeagueName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOddsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOddsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOddsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOddsTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereOddsTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereResultStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereResultValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereSportReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereTipAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereValidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTip whereValidationDetails($value)
 * @method static \Illuminate\Database\Query\Builder|UserTip withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserTip withoutTrashed()
 * @mixin \Eloquent
 */
class UserTip extends BaseModel
{
    use SoftDeletes, EmotionAbleTrait, CommentAbleTrait, TimeTrait;

    /**
     * @var string
     */
    protected $resource = 'tips';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'sport_id',
        'odds_provider_id',
        'odds_type_id',
        'odds_id',
        'away_id',
        'home_id',
        'odds',
        'tip_amount',
        'point',
        'provider',
        'score',
        'result_status',
        'result_validation',
        'provider',
        'sport_readable_id',
        'league_name',
        'odds_type_name',
        'odds_name',
        'home_name',
        'away_name',
        'event_started_at',
        'event_ends_at',
        'validated_at',
        'validation_details',
    ];

    protected $casts = [
        'validation_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outcome()
    {
        return $this->belongsTo(EnetOutcome::class, 'odds_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archived_outcome()
    {
        return $this->belongsTo(ArchivedOutcome::class, 'odds_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function betting_offer()
    {
        return $this->belongsTo(EnetBettingOffer::class, 'odds_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archived_betting_offer()
    {
        return $this->belongsTo(ArchivedBettingOffer::class, 'odds_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enet_outcome()
    {
        return $this->belongsTo(EnetOutcome::class, 'odds_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enet_betting_offer()
    {
        return $this->belongsTo(EnetBettingOffer::class, 'odds_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function odds_provider()
    {
        return $this->belongsTo(EnetOddsProvider::class, 'odds_provider_id');
    }

    public function userEmotions()
    {
        return $this->belongsToMany(User::class, 'emotionables', 'emotionable_id');
    }

    public function event()
    {
        return $this->belongsTo(EnetEvent::class, 'event_id');
    }

    public function home_team()
    {
        return $this->belongsTo(EnetParticipant::class, 'home_id');
    }

    public function away_team()
    {
        return $this->belongsTo(EnetParticipant::class, 'away_id');
    }

    /**
     * @return string
     */
    public function getAwayImageUrlAttribute()
    {
        if ($this->provider == \ConstProviders::ENETPULSE) {
            return $this->away_team->image_url ?? EnetParticipant::defaultUploadUrl('image_path');
        }

        return get_team_image_url($this->sport_readable_id, $this->away_name);
    }

    /**
     * @return string
     */
    public function getHomeImageUrlAttribute()
    {
        if ($this->provider == \ConstProviders::ENETPULSE) {
            return $this->home_team->image_url ?? EnetParticipant::defaultUploadUrl('image_path');
        }

        return get_team_image_url($this->sport_readable_id, $this->home_name);
    }

    /**
     * @return string
     */
    public function getHomeNameTranslatedAttribute()
    {
        if ($this->provider == \ConstProviders::ENETPULSE) {
            return $this->home_team->name_translated ?? $this->home_name;
        }

        return $this->home_name;
    }

    /**
     * @return string
     */
    public function getAwayNameTranslatedAttribute()
    {
        if ($this->provider == \ConstProviders::ENETPULSE) {
            return $this->away_team->name_translated ?? $this->away_name;
        }

        return $this->away_name;
    }

    /**
     *
     */
    public function getStartDateTimezoneAttribute()
    {
        return $this->getTimezoneTime('event_started_at');
    }
}
