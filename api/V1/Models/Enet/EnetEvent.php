<?php

namespace Api\V1\Models\Enet;

use Api\V1\Models\User;
use App\Jobs\Notification\EventUpdatedNotification;
use App\Models\Admin\Enet\Participant;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Traits\Models\TimeTrait;

/**
 * Class EnetEvent
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int|null $tournament_stage_id
 * @property int|null $country_id
 * @property int|null $status_description_id
 * @property int $event_status_id
 * @property int|null $tournament_id
 * @property int|null $tournament_template_id
 * @property int|null $sport_id
 * @property int|null $old_sport_id
 * @property int|null $event_first_participants_id
 * @property int|null $event_second_participants_id
 * @property int|null $first_participant_id
 * @property int|null $second_participant_id
 * @property int|null $first_win_betting_offer_id
 * @property int|null $draw_betting_offer_id
 * @property int|null $second_win_betting_offer_id
 * @property string|null $elapsed_time
 * @property int|null $n
 * @property int $is_deleted
 * @property int $is_offer_set
 * @property string|null $del
 * @property string|null $start_date_numeric
 * @property string|null $readable_id added manually
 * @property string|null $status_type
 * @property string|null $name
 * @property string|null $tournament_stage_name
 * @property string|null $country_name
 * @property string|null $tournament_name
 * @property string|null $tournament_template_name
 * @property string $sport_name
 * @property string|null $old_sport_name
 * @property string|null $gender
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $locked
 * @property-read \Api\V1\Models\Enet\EnetParticipant|null $away_team
 * @property-read \Api\V1\Models\Enet\EnetResult|null $away_team_final_result
 * @property-read \Api\V1\Models\Enet\EnetResult|null $away_team_halftime_result
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetResult[] $away_team_results
 * @property-read int|null $away_team_results_count
 * @property-read \Api\V1\Models\Enet\EnetResult|null $away_team_running_score
 * @property-read \Api\V1\Models\Enet\EnetCountry|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetEventParticipant[] $event_participants
 * @property-read int|null $event_participants_count
 * @property-read null $away_final_score
 * @property-read null $away_first_half_score
 * @property-read null $away_full_event_score
 * @property-read mixed $away_image_url
 * @property-read mixed $away_name
 * @property-read null $away_ordinary_time_score
 * @property-read mixed $away_participant
 * @property-read mixed $away_participant_id
 * @property-read null $away_second_half_score
 * @property-read mixed $away_short_name
 * @property-read mixed $cacheable_timestamp
 * @property-read string $country_league_name
 * @property-read array|string|null $elapsed_time_long
 * @property-read array|string|null $elapsed_time_short
 * @property-read array|string|null $elapsed_time_short_extended
 * @property-read mixed $event_away_participant
 * @property-read mixed $event_away_participants_id
 * @property-read mixed $event_home_participant
 * @property-read mixed $event_home_participants_id
 * @property-read string $final_score
 * @property-read string $halftime_score
 * @property-read null $home_final_score
 * @property-read null $home_first_half_score
 * @property-read null $home_full_event_score
 * @property-read mixed $home_image_url
 * @property-read mixed $home_name
 * @property-read null $home_ordinary_time_score
 * @property-read mixed $home_participant
 * @property-read null $home_second_half_score
 * @property-read mixed $home_short_name
 * @property-read mixed $start_date_timezone
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetParticipant|null $home_team
 * @property-read \Api\V1\Models\Enet\EnetResult|null $home_team_final_result
 * @property-read \Api\V1\Models\Enet\EnetResult|null $home_team_halftime_result
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetResult[] $home_team_results
 * @property-read int|null $home_team_results_count
 * @property-read \Api\V1\Models\Enet\EnetResult|null $home_team_running_score
 * @property-read \Api\V1\Models\Enet\EnetSport|null $old_sport
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetOutcome[] $outcomes
 * @property-read int|null $outcomes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetProperty[] $properties
 * @property-read int|null $properties_count
 * @property-read \Api\V1\Models\Enet\EnetSport|null $sport
 * @property-read \Api\V1\Models\Enet\EnetStanding|null $standing
 * @property-read \Api\V1\Models\Enet\EnetTournamentStage|null $tournament_stage
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $user
 * @property-read int|null $user_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\UserFavoriteEnetEvent[] $user_favorite_enet_events
 * @property-read int|null $user_favorite_enet_events_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereDrawBettingOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereElapsedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereEventFirstParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereEventSecondParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereEventStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereFirstParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereFirstWinBettingOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereIsOfferSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereOldSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereOldSportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereSecondParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereSecondWinBettingOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereSportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereStartDateNumeric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereStatusDescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereStatusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentStageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereTournamentTemplateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEvent extends BaseModel implements Auditable
{
    use \OwenIt\Auditing\Auditable, TimeTrait;

    protected $table = 'enet_events';

    protected $fillable = [
        'id',
        'tournament_stage_id',
        'country_id',
        'status_description_id',
        'event_status_id',
        'tournament_id',
        'tournament_template_id',
        'sport_id',
        'old_sport_id',
        'event_first_participants_id',
        'event_second_participants_id',
        'first_participant_id',
        'second_participant_id',
        'first_win_betting_offer_id',
        'draw_betting_offer_id',
        'second_win_betting_offer_id',
        'elapsed_time',
        'n',
        'is_deleted',
        'is_offer_archived',
        'del',
        'start_date_numeric',
        'readable_id',
        'status_type',
        'name',
        'tournament_stage_name',
        'country_name',
        'tournament_name',
        'tournament_template_name',
        'sport_name',
        'old_sport_name',
        'gender',
        'start_date',
        'end_date',
        'locked'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'readable_id' => 'string',
        'tournament_stage_id' => 'integer',
        'status_description_id' => 'integer',
        'tournament_id' => 'integer',
        'tournament_template_id' => 'integer',
        'sport_id' => 'integer',
        'start_date_numeric' => 'string',
        'status_type' => 'string',
        'tournament_stage_name' => 'string',
        'tournament_name' => 'string',
        'tournament_template_name' => 'string',
        'sport_name' => 'string',
        'gender' => 'string',
        'start_date' => 'string',
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::saving(function (self $item) {
            if (empty($item->tournament_stage_name) && $item->tournament_stage_id) {
                $item->tournament_stage_name = EnetTournamentStage::where('id', $item->tournament_stage_id)->value('name');
            }

            if (empty($item->country_id) && $item->tournament_stage_id) {
                $item->country_id = EnetTournamentStage::where('id', $item->tournament_stage_id)->value('country_id');
            }

            if (empty($item->country_name) && $item->country_id) {
                $item->country_name = EnetCountry::where('id', $item->country_id)->value('name');
            }

            if (empty($item->tournament_id) && $item->tournament_stage_id) {
                $item->tournament_id = EnetTournamentStage::where('id', $item->tournament_stage_id)->value('tournament_id');
            }

            if (empty($item->tournament_id) && $item->tournament_stage_id) {
                $item->tournament_id = EnetTournamentStage::where('id', $item->tournament_stage_id)->value('tournament_id');
            }

            if (empty($item->tournament_name) && $item->tournament_id) {
                $item->tournament_name = EnetTournament::where('id', $item->tournament_id)->value('name');
            }

            if (empty($item->tournament_template_id) && $item->tournament_id) {
                $item->tournament_template_id = EnetTournament::where('id', $item->tournament_id)->value('tournament_template_id');
            }

            if (empty($item->tournament_template_name) && $item->tournament_template_id) {
                $item->tournament_template_name = EnetTournamentTemplate::where('id', $item->tournament_template_id)->value('name');
            }

            if (empty($item->sport_id) && $item->tournament_template_id) {
                $item->sport_id = EnetTournamentTemplate::where('id', $item->tournament_template_id)->value('sport_id');
            }

            if (empty($item->sport_name) && $item->sport_id) {
                $item->sport_name = EnetSport::where('id', $item->sport_id)->value('name');
            }
        });
        
        self::updating(function (self $item) {
            dispatch(new EventUpdatedNotification($item));
        });
    }









    public function user_favorite_enet_events()
    {
        return $this->hasMany(\Api\V1\Models\UserFavoriteEnetEvent::class, 'event_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function home_team()
    {
        return $this->belongsTo(EnetParticipant::class, 'first_participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function away_team()
    {
        return $this->belongsTo(EnetParticipant::class, 'second_participant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function home_team_results()
    {
        return $this->hasMany(EnetResult::class, 'event_participants_id', 'event_first_participants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function away_team_results()
    {
        return $this->hasMany(EnetResult::class, 'event_participants_id', 'event_second_participants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function home_team_final_result()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_first_participants_id')
            ->where('result_type_id', \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function away_team_final_result()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_second_participants_id')
            ->where('result_type_id', \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function home_team_running_score()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_first_participants_id')
            ->where('result_type_id', \ConstEnetResultType::RUNNING_SCORE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function away_team_running_score()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_second_participants_id')
            ->where('result_type_id', \ConstEnetResultType::RUNNING_SCORE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function home_team_halftime_result()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_first_participants_id')
            ->where('result_type_id', \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function away_team_halftime_result()
    {
        return $this->hasOne(EnetResult::class, 'event_participants_id', 'event_second_participants_id')
            ->where('result_type_id', \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(EnetCountry::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(EnetSport::class, 'sport_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function old_sport()
    {
        return $this->belongsTo(EnetSport::class, 'old_sport_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(EnetProperty::class, 'object_id')->where('object', \ConstEnetObjectType::EVENT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament_stage()
    {
        return $this->belongsTo(EnetTournamentStage::class, 'tournament_stage_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outcomes()
    {
        return $this->hasMany(EnetOutcome::class, 'object_id')->where('object', \ConstEnetObjectType::EVENT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event_participants()
    {
        return $this->hasMany(EnetEventParticipant::class, 'event_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_favorite_enet_event', 'event_id');
    }









    /************************************************************************
     *                         Corrected attributes                         *
     ************************************************************************/

    /**
     * @return array|string|null
     */
    public function getElapsedTimeShortAttribute()
    {
        if ($this->status_type == \ConstEnetStatusType::NotStarted) {
            return $this->start_date_timezone->format('H.i');
        }

        if ($this->status_type == \ConstEnetStatusType::Inprogress && $this->sport_id != \ConsEnetSport::FOOTBALL) {
            return mobile_status_type($this->status_type);
        }

        if (empty($this->attributes['elapsed_time'])) {
            return $this->start_date_timezone->format('H.i');
        }

        $time = $this->attributes['elapsed_time'];
        if (\Lang::has('mobile.game_time.' . $time . '.short')) {
            return __('mobile.game_time.' . $time . '.short');
        }

        return $time;
    }

    /**
     * @return array|string|null
     */
    public function getElapsedTimeShortExtendedAttribute()
    {
        if ($this->status_type == \ConstEnetStatusType::NotStarted) {
            return $this->start_date_timezone->format('H.i');
        }

        if ($this->status_type == \ConstEnetStatusType::Inprogress && $this->sport_id != \ConsEnetSport::FOOTBALL) {
            return mobile_status_type($this->status_type);
        }

        if (empty($this->attributes['elapsed_time'])) {
            return $this->start_date_timezone->format('H.i');
        }

        $time = $this->attributes['elapsed_time'];
        if (\Lang::has('mobile.game_time.' . $time . '.long')) {
            return __('mobile.game_time.' . $time . '.long');
        }

        return $time;
    }

    /**
     *
     */
    public function getStartDateTimezoneAttribute()
    {
        return $this->getTimezoneTime('start_date');
    }

    /**
     * @return mixed
     */
    public function getHomeNameAttribute()
    {
        return $this->home_participant->name_translated ?? head(explode('-', $this->name));
    }

    /**
     * @return mixed
     */
    public function getHomeTypeAttribute()
    {
        return $this->home_participant->type ?? 'team';
    }

    /**
     * @return mixed
     */
    public function getAwayTypeAttribute()
    {
        return $this->away_participant->type ?? 'team';
    }

    /**
     * @return mixed
     */
    public function getAwayNameAttribute()
    {
        return $this->away_participant->name_translated ?? last(explode('-', $this->name));
    }

    /**
     * @return mixed
     */
    public function getHomeShortNameAttribute()
    {
        return $this->home_participant->short_name_translated ?? substr(head(explode('-', $this->name)), 0, 3);
    }

    /**
     * @return mixed
     */
    public function getAwayShortNameAttribute()
    {
        return $this->away_participant->short_name_translated ?? substr(last(explode('-', $this->name)), 0, 3);
    }

    /**
     * @return mixed
     */
    public function getHomeParticipantAttribute()
    {
        return $this->event_home_participant->participant ?? null;
    }

    /**
     * @return mixed
     */
    public function getAwayParticipantAttribute()
    {
        return $this->event_away_participant->participant ?? null;
    }

    /**
     * @return mixed
     */
    public function getEventHomeParticipantAttribute()
    {
        // TODO will cache
        return $this->event_participants->where('number', 1)->first();
    }

    /**
     * @return mixed
     */
    public function getEventAwayParticipantAttribute()
    {
        // TODO will cache
        return $this->event_participants->where('number', 2)->first();
    }

    /************************************************************************
     *                         Corrected attributes                         *
     ************************************************************************/




































    /**
     * @return string
     */
    public function getCountryLeagueNameAttribute()
    {
        if (\ConsEnetSport::E_SPORTS == $this->sport_id) {
            return $this->tournament_stage_name;
        }
        $part = $this->country_id ? mobile_country($this->country_id) : 'International';
        return $part . ' : ' . $this->tournament_stage_name;
    }



    /**
     * @return mixed
     */
    protected function getHomeParticipantIdAttribute()
    {
        if (empty($this->first_participant_id)) {
            return $this->event_home_participant->participant_id ?? null;
        }

        return $this->first_participant_id;
    }

    /**
     * @return mixed
     */
    public function getAwayParticipantIdAttribute()
    {
        if (empty($this->second_participant_id)) {
            return $this->event_away_participant->participant_id ?? null;
        }

        return $this->second_participant_id;
    }

    /**
     * @return mixed
     */
    public function getEventHomeParticipantsIdAttribute()
    {
        if (empty($this->event_first_participants_id)) {
            return $this->event_home_participant->id ?? null;
        }
        return $this->event_first_participants_id;
    }

    /**
     * @return mixed
     */
    public function getEventAwayParticipantsIdAttribute()
    {
        if (empty($this->event_second_participants_id)) {
            return $this->event_away_participant->id ?? null;
        }
        return $this->event_second_participants_id;
    }





    /**
     * @return mixed
     */
    public function getHomeImageUrlAttribute()
    {
        $type = $this->home_participant->type ?? 'team';
        $type = Str::plural($type);
        return ! empty($this->home_participant->image_url)
            ? $this->home_participant->image_url
            : (new Participant())->getDefaultUploadUrl('image_path', $type);
    }

    /**
     * @return mixed
     */
    public function getAwayImageUrlAttribute()
    {
        $type = $this->away_participant->type ?? 'team';
        $type = Str::plural($type);
        return ! empty($this->away_participant->image_url)
            ? $this->away_participant->image_url
            : (new Participant())->getDefaultUploadUrl('image_path', $type);
    }





    /**
     * @return array|string|null
     */
    public function getElapsedTimeLongAttribute()
    {
        if (empty($this->attributes['elapsed_time'])) {
            return '';
        }

        $time = $this->attributes['elapsed_time'];
        if (\Lang::has('mobile.game_time.' . $time . '.long')) {
            return __('mobile.game_time.' . $time . '.long');
        }

        return $time . "'";
    }

    /**
     * @return |null
     */
    public function getHomeFirstHalfScoreAttribute()
    {
        return $this->getScore($this->home_team_results, \ConstEnetResultType::HALFTIME);
    }

    /**
     * @return |null
     */
    public function getAwayFirstHalfScoreAttribute()
    {
        return $this->getScore($this->away_team_results, \ConstEnetResultType::HALFTIME);
    }

    /**
     * @return |null
     */
    public function getHomeSecondHalfScoreAttribute()
    {
        return $this->getSecondHalfScore($this->home_team_results);
    }

    /**
     * @return |null
     */
    public function getAwaySecondHalfScoreAttribute()
    {
        return $this->getSecondHalfScore($this->away_team_results);
    }

    /**
     * @return |null
     */
    public function getHomeOrdinaryTimeScoreAttribute()
    {
        return $this->getScore($this->home_team_results, \ConstEnetResultType::ORDINARY_TIME);
    }

    /**
     * @return |null
     */
    public function getAwayOrdinaryTimeScoreAttribute()
    {
        return $this->getScore($this->away_team_results, \ConstEnetResultType::ORDINARY_TIME);
    }

    /**
     * @return |null
     */
    public function getHomeFinalScoreAttribute()
    {
        return $this->getScore($this->home_team_results, \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return |null
     */
    public function getAwayFinalScoreAttribute()
    {
        return $this->getScore($this->away_team_results, \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return |null
     */
    public function getHomeRunningScoreAttribute()
    {
        return $this->getScore($this->home_team_results, \ConstEnetResultType::RUNNING_SCORE);
    }

    /**
     * @return |null
     */
    public function getAwayRunningScoreAttribute()
    {
        return $this->getScore($this->away_team_results, \ConstEnetResultType::RUNNING_SCORE);
    }


    /**
     * @return |null
     */
    public function getHomeSetsSumScoreAttribute()
    {
        return $this->getSetsSumScore($this->home_team_results);
    }

    /**
     * @return |null
     */
    public function getAwaySetsSumScoreAttribute()
    {
        return $this->getSetsSumScore($this->away_team_results);
    }

    /**
     * @return string
     */
    public function getFinalScoreAttribute()
    {
        if ($this->relationLoaded('home_team_final_result') && $this->relationLoaded('away_team_final_result')) {
            $homeResult = $this->home_team_final_result->value ?? '';
            $awayResult = $this->away_team_final_result->value ?? '';
            return $homeResult . ' - ' . $awayResult;
        }
        return '-';
    }

    /**
     * @return string
     */
    public function getHalftimeScoreAttribute()
    {
        if ($this->relationLoaded('home_team_halftime_result') && $this->relationLoaded('home_team_halftime_result')) {
            $homeResult = $this->home_team_halftime_result->value ?? '';
            $awayResult = $this->home_team_halftime_result->value ?? '';
            return $homeResult . ' - ' . $awayResult;
        }
        return '-';
    }


    /**
     * @return |null
     */
    public function getHomeFullEventScoreAttribute()
    {
        return $this->getScore($this->home_team_results, \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @return |null
     */
    public function getAwayFullEventScoreAttribute()
    {
        return $this->getScore($this->away_team_results, \ConstEnetResultType::FINAL_RESULT);
    }

    /**
     * @param $results
     * @return null
     */
    protected function getSecondHalfScore($results)
    {
        $ordinaryTimeResult = $results->where('result_type_id', \ConstEnetResultType::ORDINARY_TIME)->first();
        $halfTimeResult = $results->where('result_type_id', \ConstEnetResultType::HALFTIME)->first();
        if (empty($ordinaryTimeResult) || empty($halfTimeResult)) {
            return null;
        }

        return $ordinaryTimeResult->value - $halfTimeResult->value;
    }

    /**
     * @param $results
     * @param $resultTypeId
     * @return |null
     */
    protected function getScore($results, $resultTypeId)
    {
        $ordinaryTimeResult = $results->where('result_type_id', $resultTypeId)->first();
        if (empty($ordinaryTimeResult)) {
            return null;
        }

        return $ordinaryTimeResult->value;
    }

    /**
     * @param $results
     * @return mixed
     */
    protected function getSetsSumScore($results)
    {
        return $results->sum(function ($result) {
            $resultTypes = [
                \ConstEnetResultType::SET_1,
                \ConstEnetResultType::SET_2,
                \ConstEnetResultType::SET_3,
                \ConstEnetResultType::SET_4,
                \ConstEnetResultType::SET_4,
            ];
            return in_array($result->result_type_id, $resultTypes) ? $result->value : 0;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function standing()
    {
        return $this->hasOne(EnetStanding::class, 'object_id')->where('object', \ConstEnetObjectType::EVENT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function standings()
    {
        return $this->hasMany(EnetStanding::class, 'object_id')->where('object', \ConstEnetObjectType::EVENT);
    }

    /**
     * @return string
     */
    public function getSportNameAttribute()
    {
        if (empty($this->attributes['sport_name'])) {
            return '';
        }

        return $this->attributes['sport_name'] === 'Soccer' ? 'Football' : $this->attributes['sport_name'];
    }

    /**
     * @return string
     */
    public function getSportKeyAttribute()
    {
        $sports = get_cached_sports();
        $sport = $sports->where('id', $this->sport_id)->first();
        return $sport->readable_id ?? 'football';
    }
}
