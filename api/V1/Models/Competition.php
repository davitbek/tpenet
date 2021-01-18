<?php

namespace Api\V1\Models;

use Api\V1\Casts\PlacePrizeCast;
use Api\V1\Models\Enet\EnetSport;
use Api\V1\Models\Enet\EnetTournamentStage;
use LaraAreaModel\Traits\CastsTrait;

/**
 * Class Competition
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $order
 * @property int|null $rank_position
 * @property int|null $is_recurring
 * @property int|null $interval_type
 * @property int|null $interval_count
 * @property string|null $lang
 * @property string $picture_path
 * @property string $picture_disk
 * @property int|null $prizepool
 * @property string|null $currency
 * @property PlacePrizeCast|null $place_prizes
 * @property string $headline
 * @property string $slug
 * @property string $sponsor
 * @property string $text
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $iteration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\CompetitionRank[] $competition_ranks
 * @property-read int|null $competition_ranks_count
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed|string $language
 * @property-read mixed $picture_url
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read Competition|null $main
 * @property-read \Illuminate\Database\Eloquent\Collection|EnetSport[] $sports
 * @property-read int|null $sports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|EnetTournamentStage[] $tournament_stages
 * @property-read int|null $tournament_stages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Competition[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Competition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Competition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Competition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereCurrentEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereCurrentStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereHeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereIntervalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereIntervalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereIteration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition wherePictureDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition wherePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition wherePlacePrizes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition wherePrizepool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereRankPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereSponsor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Competition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Competition extends TranslateableModel
{
    use CastsTrait;

    /**
     * @var array
     */
    protected $fillable= [
        'parent_id',
        'order',
        'rank_position',
        'iteration',
        'is_recurring',
        'interval_type',
        'interval_count',
        'lang',
        'picture_path',
        'picture_disk',
        'prizepool',
        'currency',
        'place_prizes',
        'headline',
        'slug',
        'sponsor',
        'sponsor_url',
        'text',
        'start_date',
        'end_date',
        'current_start_date',
        'current_end_date',
    ];

    protected $translateable = [
        'headline',
        'slug',
        'sponsor',
        'sponsor_url',
        'text',
    ];

    /**
     * @var array
     */
    public $wrap = [
        'picture_url' => [
            'picture_disk',
            'picture_path'
        ],
        'sponsor_image_url' => [
            'sponsor_image_disk',
            'sponsor_image_path'
        ],
    ];

    protected $uploadable = [
       'picture_path',
       'sponsor_image_path',
    ];

    public $casts = [
        'place_prizes' => PlacePrizeCast::class
    ];

    /**
     * @return mixed
     */
    public function getPictureUrlAttribute()
    {
        return $this->getUrlByAttribute('picture_path');
    }

    /**
     * @return mixed
     */
    public function getSponsorImageUrlAttribute()
    {
        return $this->getUrlByAttribute('sponsor_image_path');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competition_ranks()
    {
        return $this->hasMany(CompetitionRank::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competition_iterations()
    {
        return $this->hasMany(CompetitionIteration::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sports()
    {
        return $this->belongsToMany(EnetSport::class, 'competition_sport', 'competition_id', 'sport_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tournament_stages()
    {
        return $this->belongsToMany(EnetTournamentStage::class, 'competition_tournament_stage', 'competition_id', 'tournament_stage_id', 'id', 'id');
    }
}
