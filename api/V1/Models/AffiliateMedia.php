<?php

namespace Api\V1\Models;

use Api\V1\Models\Enet\EnetOddsProvider;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AffiliateMedia
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $odds_provider_id
 * @property int|null $sport_id
 * @property int|null $active
 * @property int|null $is_mobile
 * @property int|null $width
 * @property int|null $height
 * @property int|null $is_embed
 * @property string|null $embed_code
 * @property string|null $category
 * @property string|null $product
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $description
 * @property string|null $terms_and_conditions
 * @property string|null $link
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string|null $started_at
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read string $image_url
 * @property-read string $odds_provider_name
 * @property-read mixed $url_by
 * @property-read EnetOddsProvider $odds_provider
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia newQuery()
 * @method static \Illuminate\Database\Query\Builder|AffiliateMedia onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereEmbedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereIsEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereIsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereOddsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereTermsAndConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateMedia whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|AffiliateMedia withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AffiliateMedia withoutTrashed()
 * @mixin \Eloquent
 */
class AffiliateMedia extends BaseModel
{
    use SoftDeletes;

    protected $table = 'affiliates_media';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function odds_provider()
    {
        return $this->belongsTo(EnetOddsProvider::class);
    }

    public function sport()
    {
        return true;// @TODO fix
    }

    /**
     * @return string
     */
    public function getOddsProviderNameAttribute()
    {
        return $this->odds_provider->brand ?? 'Bookmaker Deleted';
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }
}
