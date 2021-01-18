<?php

namespace Api\V1\Models\Archived;

use Api\V1\Models\BaseModel;

/**
 * Class ArchivedBettingOffer
 *
 * @package Api\V1\Models\Archived
 * @property int $id
 * @property int $outcome_id
 * @property int $odds_provider_id
 * @property int $betting_offer_status_id
 * @property float $odds
 * @property float $odds_old
 * @property int $is_active
 * @property int $is_back
 * @property int $is_single
 * @property int $is_live
 * @property int $volume
 * @property string $currency
 * @property string $coupon_key
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Archived\ArchivedOutcome $outcome
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereBettingOfferStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereCouponKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereIsBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereIsLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereIsSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereOdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereOddsOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereOddsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereOutcomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedBettingOffer whereVolume($value)
 * @mixin \Eloquent
 */
class ArchivedBettingOffer extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'archived_betting_offers';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'outcome_id',
        'odds_provider_id',
        'betting_offer_status_id',
        'odds',
        'odds_old',
        'is_active',
        'is_back',
        'is_single',
        'is_live',
        'volume',
        'currency',
        'coupon_key',
        'is_deleted',
        'n',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outcome()
    {
        return $this->belongsTo(ArchivedOutcome::class, 'outcome_id');
    }

}
