<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetTournamentTemplate
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $sport_id
 * @property int|null $old_sport_id
 * @property int $n
 * @property int $is_deleted
 * @property string|null $readable_id added manually
 * @property string $gender
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetSport $sport
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereOldSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournamentTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetTournamentTemplate extends BaseModel
{
    protected $table = 'enet_tournament_templates';

    protected $fillable = [
        'id',
        'sport_id',
        'old_sport_id',
        'n',
        'is_deleted',
        'readable_id',
        'gender',
        'name',
        'ut',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(EnetSport::class, 'sport_id');
    }
}
