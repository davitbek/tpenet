<?php

namespace Api\V1\Models\Enet;

use Api\V1\Models\UserFavoriteEnetParticipant;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class EnetParticipant
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int|null $country_id
 * @property int|null $sport_id
 * @property int|null $is_suggest
 * @property int|null $n
 * @property int $is_deleted
 * @property string|null $gender
 * @property string|null $name
 * @property string|null $name_da
 * @property string|null $name_en
 * @property string|null $name_short_da
 * @property string|null $name_short_en
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $type
 * @property string|null $country_name
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|EnetParticipant[] $athletes
 * @property-read int|null $athletes_count
 * @property-read \Api\V1\Models\Enet\EnetObjectParticipant|null $coach
 * @property-read \Api\V1\Models\Enet\EnetCountry|null $country
 * @property-read \Api\V1\Models\Enet\EnetEvent $event
 * @property-read string $away_shirt_image_url
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $home_shirt_image_url
 * @property-read string $image_url
 * @property-read string $logo
 * @property-read mixed $name_translated
 * @property-read string $short_name_translated
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetLanguage[] $languages
 * @property-read int|null $languages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetObjectParticipant[] $object_participants
 * @property-read int|null $object_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetObjectParticipant[] $objects
 * @property-read int|null $objects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetParticipantSuggestion[] $participant_suggestions
 * @property-read int|null $participant_suggestions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetProperty[] $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetObjectParticipant[] $team_objects
 * @property-read int|null $team_objects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|EnetParticipant[] $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserFavoriteEnetParticipant[] $user_favorite_participants
 * @property-read int|null $user_favorite_participants_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereIsSuggest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereNameDa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereNameShortDa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereNameShortEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetParticipant extends BaseModel
{
    protected $table = 'enet_participants';

    protected $fillable = [
        'id',
        'country_id',
        'n',
        'is_deleted',
        'gender',
        'name',
        'name_da',
        'name_en',
        'name_short_da',
        'name_short_en',
        'first_name',
        'last_name',
        'type',
        'country_name',
        'image_path',
        'ut',
        'is_suggest',
        'sport_id'
    ];

    protected $defaultUpload = 'default.png';

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::saving(function (self $item) {
            if (empty($item->country_name)) {
                $item->country_name = EnetCountry::where('id', $item->country_id)->value('name');
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(EnetProperty::class, 'object_id')->where('object', \ConstEnetObjectType::PARTICIPANT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function object_participants()
    {
        return $this->hasMany(EnetObjectParticipant::class, 'object_id')->where('object', \ConstEnetObjectType::PARTICIPANT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objects()
    {
        return $this->hasMany(EnetObjectParticipant::class, 'participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languages()
    {
        return $this->hasMany(EnetLanguage::class, 'object_id')->where('object', \ConstEnetObjectType::PARTICIPANT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function team_objects()
    {
        return $this->objects()->where('participant_type', \ConstParticipantType::Team);
    }

    public function participant_suggestions()
    {
        return $this->hasMany(EnetParticipantSuggestion::class, 'participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coach()
    {
        return $this->hasOne(EnetObjectParticipant::class, 'object_id')
            ->where('is_active', \ConstYesNo::YES)
            ->where('participant_type', \ConstParticipantType::Coach)
            ->where('object', \ConstEnetObjectType::PARTICIPANT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(EnetCountry::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(EnetEvent::class, 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(EnetImage::class, 'object_id', 'id')->where('object', 'participant');
    }

    /**
     * @return string
     */
    public function getLogoAttribute()
    {
        return $this->logo_image->base_64 ?? get_team_image_url('football', $this->name); // @TODO get related tournament
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }


    /**
     * @param $attribute
     * @param null $default
     * @return mixed|string|null
     */
    public function getUploadRootPath($attribute, $default = null)
    {
        if ($default) {
            return $default;
        }

        return Str::plural($this->type ?? 'team');
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function includeIdInPath($attribute)
    {
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_favorite_participants()
    {
        return $this->hasMany(UserFavoriteEnetParticipant::class, 'participant_id');
    }

    /**
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getDefaultUploadUrl($attribute, $rootPath = null)
    {
        if (\ConstParticipantType::Athlete == $this->type || empty($this->country_id)) {
            $country = get_cached_countries()->where('id', $this->country_id)->first();
            if (! empty($country)) {
                return $country->image_url;
            }
        }
        return parent::getDefaultUploadUrl($attribute, $rootPath);
    }

    /**
     *
     */
    public function getNameTranslatedAttribute()
    {
        $language = Auth::guard('api')->user()->lang ?? App::getLocale();
        $language = ($language == 'da') ? 'da' : 'en';
        $name = $this->{'name_' . $language} ?? $this->name;
        if ('female' == $this->gender) {
            $name .= ' ' . __('teams.female');
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getShortNameTranslatedAttribute()
    {
        $language = Auth::guard('api')->user()->lang ?? App::getLocale();
        $language = ($language == 'da') ? 'da' : 'en';
        $shortName = $this->{'name_short_' . $language} ?? $this->{'name_short_en'};
        return $shortName ?? substr($this->name_translated, 0, 3);
    }

    public function getHomeShirtImageUrlAttribute()
    {
        return Cache::remember('home_shirt_image_url' . $this->id, 30 * 24 * 60 * 60, function () {
            $image = $this->images()->where('name', 'home')->first();
            return !empty($image->image_url) ? $image->image_url : EnetImage::getDefaultShirtImageUrl();
        });
    }

    /**
     * @return string
     */
    public function getAwayShirtImageUrlAttribute()
    {
        return Cache::remember('away_shirt_image_url' . $this->id, 30 * 24 * 60 * 60, function () {
            $image = $this->images()->where('name', 'away')->first();
            return !empty($image->image_url) ? $image->image_url : EnetImage::getDefaultShirtImageUrl();
        });
    }

    public static function getDefaultShirtImageUrl()
    {
        return Storage::disk('s3')->url('teams/default-shirt.gif');
    }
}
