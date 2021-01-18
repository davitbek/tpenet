<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetBettingOffer
 *
 * @package Api\V1\Models\Enet
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
 * @property-read \Api\V1\Models\Enet\EnetOutcome $outcome
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereBettingOfferStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereCouponKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereIsBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereIsLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereIsSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereOdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereOddsOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereOddsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereOutcomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOffer whereVolume($value)
 * @mixin \Eloquent
 */
class EnetBettingOffer extends BaseModel
{
    protected $table = 'enet_betting_offers';

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
        return $this->belongsTo(EnetOutcome::class, 'outcome_id');
    }

}
