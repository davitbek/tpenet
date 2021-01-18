<?php

namespace Api\V1\Models\Enet;

use Api\V1\Models\AffiliateMedia;
use Api\V1\Models\TranslateableModel;
use LaraAreaUpload\Traits\UploadableTrait;

/**
 * Class EnetOddsProvider
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $is_enet
 * @property int $exclude_countries
 * @property int|null $parent_id
 * @property int|null $position
 * @property string|null $lang
 * @property string|null $rating
 * @property int|null $tipya_active
 * @property string|null $brand
 * @property string|null $promo_code
 * @property string|null $image_path
 * @property string|null $small_icon_path
 * @property string|null $slug
 * @property int $country_id
 * @property int $is_active
 * @property int $is_bookmaker
 * @property int $is_betex
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $url
 * @property string|null $related_url
 * @property string|null $related_url_mobile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $text
 * @property string|null $short_description
 * @property string|null $image_disk
 * @property string|null $small_icon_disk
 * @property-read \Illuminate\Database\Eloquent\Collection|AffiliateMedia[] $affiliates_media
 * @property-read int|null $affiliates_media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\CountryBettingOffer[] $country_betting_offers
 * @property-read int|null $country_betting_offers_count
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $image_url
 * @property-read mixed|string $language
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read EnetOddsProvider|null $main
 * @property-read \Illuminate\Database\Eloquent\Collection|EnetOddsProvider[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereExcludeCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereIsBetex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereIsBookmaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereIsEnet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereRelatedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereRelatedUrlMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereSmallIconDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereSmallIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereTipyaActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOddsProvider whereUrl($value)
 * @mixin \Eloquent
 */
class EnetOddsProvider extends TranslateableModel
{
    use UploadableTrait;

    protected $table = 'enet_odds_providers';

    /**
     * @var string
     */
    protected $resource = 'affiliates';

    /**
     *
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * @var array
     */
    public $fillable = [
        'id',
        'is_enet',
        'parent_id',
        'position',
        'lang',
        'rating',
        'tipya_active',
        'brand',
        'image_path',
        'small_icon_path',
        'slug',
        'country_id',
        'is_active',
        'is_bookmaker',
        'is_betex',
        'n',
        'is_deleted',
        'name',
        'url',
        'related_url',
        'created_at',
        'updated_at',
        'text',
        'short_description',
        'image_disk',
        'small_icon_disk'
    ];

    /**
     * @var array
     */
    protected $translateable = [
        'text',
        'short_description',
        'related_url',
    ];

    /**
     * @return mixed
     */
    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliates_media()
    {
        return $this->hasMany(AffiliateMedia::class, 'odds_provider_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function country_betting_offers()
    {
        return $this->hasMany(CountryBettingOffer::class, 'odds_provider_id');
    }
}
