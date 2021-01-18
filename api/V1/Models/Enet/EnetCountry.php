<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetCountry
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property int $is_enet
 * @property string|null $iso2
 * @property string|null $readable_id added manually
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string $name
 * @property string|null $country
 * @property int|null $odds_type
 * @property string|null $timezone
 * @property string|null $language
 * @property string|null $href_language
 * @property string|null $currency
 * @property array|null $timezones
 * @property array|null $currencies
 * @property array|null $languages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Api\V1\Models\Enet\EnetImage|null $flag_image
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $image_url
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereCurrencies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereHrefLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereIsEnet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereOddsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereTimezones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetCountry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetCountry extends BaseModel
{
    protected $table = 'enet_countries';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'readable_id',
        'image_path',
        'name',
        'ut',
        'is_enet',
        'iso2',
        'country',
        'odds_type',
        'timezone',
        'language',
        'href_language',
        'currency',
        'timezones',
        'currencies',
        'languages'
    ];

    protected $casts = [
        'timezones' => 'array',
        'currencies' => 'array',
        'languages' => 'array'
    ];

    protected $defaultUpload = 'default.png';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function flag_image()
    {
        return $this->hasOne(EnetImage::class, 'object_id', 'id')->where('object', 'country');
    }

    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }

    public function getResource()
    {
        return 'countries';
    }
}
