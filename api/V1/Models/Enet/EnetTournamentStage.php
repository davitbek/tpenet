<?php

namespace Api\V1\Models\Enet;

use Api\V1\Models\User;
use Api\V1\Models\UserFavoriteEnetTournamentTemplate;
use App\Models\Admin\Enet\EnetFavoriteTournamentTemplate;
use Illuminate\Support\Str;
use Traits\Models\CountryRelatedTrait;

/**
 * Class EnetTournamentStage
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $tournament_id
 * @property int|null $tournament_template_id
 * @property int|null $sport_id
 * @property int|null $country_id
 * @property int $is_favorite
 * @property int|null $is_active
 * @property int $n
 * @property string|null $locked
 * @property int $is_deleted
 * @property int $start_date_numeric
 * @property int $end_date_numeric
 * @property string|null $readable_id added manually
 * @property string $name
 * @property string|null $league_name
 * @property string|null $years
 * @property string|null $country_name
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string $gender
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Api\V1\Models\Enet\EnetCountry|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetEvent[] $events
 * @property-read int|null $events_count
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $icon_url
 * @property-read mixed $image_base64
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetTournament $tournament
 * @property-read \Api\V1\Models\Enet\EnetTournamentTemplate|null $tournament_template
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereEndDateNumeric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereIsFavorite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereLeagueName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereStartDateNumeric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereTournamentTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentStage whereYears($value)
 * @mixin \Eloquent
 */
class EnetTournamentStage extends BaseModel
{
    use CountryRelatedTrait;

    protected $table = 'enet_tournament_stages';

    protected $fillable = [
        'id',
        'tournament_id',
        'tournament_template_id',
        'sport_id',
        'country_id',
        'is_favorite',
        'is_active',
        'n',
        'locked',
        'is_deleted',
        'start_date_numeric',
        'end_date_numeric',
        'readable_id',
        'name',
        'league_name',
        'years',
        'country_name',
        'image_path',
        'image_disk',
        'gender',
        'start_date',
        'end_date',
    ];

    protected $defaultUpload = 'default.png';

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'readable_id' => 'string',
        'country_name' => 'string',
        'gender' => 'string',
        'start_date' => 'string',
        'end_date' => 'string',
    ];

    protected $wrap = [
        'icon_url' => 'image_path'
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::saving(function (self $item) {
            if ($item->name) {
                $item->readable_id = Str::slug($item->name);
            }

            if (empty($item->country_name) && $item->country_id) {
                $item->country_name = EnetCountry::where('id', $item->country_id)->value('name');
                $item->image_path = $item->country_name ?  Str::slug( $item->country_name) . '.png' : '';
            }

            if (empty($item->tournament_template_id) && $item->tournament_id) {
                $item->tournament_template_id = EnetTournament::where('id', $item->tournament_id)->value('tournament_template_id');
            }

            if (empty($item->league_name) && $item->name) {
                $item->league_name = $item->name;
            }

            if (empty($item->sport_id) && $item->tournament_template_id) {
                $item->sport_id = EnetTournamentTemplate::where('id', $item->tournament_template_id)->value('sport_id');
            }
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function standings()
    {
        return $this->hasMany(EnetStanding::class, 'object_id')->where('object', \ConstEnetObjectType::TOURNAMENT_STAGE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function draws()
    {
        return $this->hasMany(EnetDraw::class, 'object_id')->where('object_type_id', 4);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_favorite_enet_tournament_template', 'tournament_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_favorite_tournament_templates()
    {
        return $this->hasMany(UserFavoriteEnetTournamentTemplate::class, 'tournament_template_id', 'tournament_template_id');
    }

    public function events()
    {
        return $this->hasMany(EnetEvent::class, 'tournament_stage_id');
    }

    public function tournament()
    {
        return $this->belongsTo(EnetTournament::class, 'tournament_id');
    }
    public function tournament_template()
    {
        return $this->belongsTo(EnetTournamentTemplate::class, 'tournament_template_id');
    }

    public function getImageBase64Attribute()
    {
        $this->hidden = ['country_id'];
        $country = $this->getForeverCachedRelation('country');
        return $country->image_base_64 ?? get_sport_image_url('football');
    }

    public function getNameAttribute()
    {
        return $this->attributes['league_name'] ?? $this->attributes['name'] ?? '';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite_tournament_templates()
    {
        return $this->hasMany(EnetFavoriteTournamentTemplate::class, 'tournament_template_id', 'tournament_template_id');
    }

    /**
     * Get folder path where must be upload file
     *
     * @param $attribute
     * @param null $rootPath
     * @return string
     */
    public function getUploadFolderPath($attribute, $rootPath = null)
    {
        $prePtah = 'countries';
        if (count($this->getUploadable()) > 1) {
            $prePtah .= $attribute ? '/' . $this->processPathAttribute($attribute) : '';
        }
        return $this->includeIdInPath($attribute) ? $prePtah . '/' .  $this->getKey() : $prePtah ;
    }

    public function getIconUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }
}
