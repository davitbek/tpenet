<?php

namespace Api\V1\Models\Enet;

/**
 * Class CountryBettingOffer
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $country_id
 * @property int $odds_provider_id
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryBettingOffer whereOddsProviderId($value)
 * @mixin \Eloquent
 */
class CountryBettingOffer extends BaseModel
{
    public $timestamps = false;

    protected $table = 'country_odds_provider';

    protected $fillable = [
        'country_id',
        'odds_provider_id',
    ];
}
