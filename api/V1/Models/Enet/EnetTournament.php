<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetTournament
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $tournament_template_id
 * @property int|null $sport_id
 * @property int $n
 * @property int $is_deleted
 * @property string|null $readable_id added manually
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetTournamentTemplate $tournament_template
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereTournamentTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetTournament whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetTournament extends BaseModel
{
    protected $table = 'enet_tournaments';

    protected $fillable = [
        'id',
        'tournament_template_id',
        'sport_id',
        'n',
        'is_deleted',
        'readable_id',
        'name',
        'ut',
    ];

    public function tournament_template()
    {
        return $this->belongsTo(EnetTournamentTemplate::class, 'tournament_template_id');
    }

    /**
     *
     */
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::saving(function (self $item) {

            $item->readable_id = str_replace('/', '-', $item->name);

            if (empty($item->sport_id)) {
                $item->sport_id = EnetTournamentTemplate::where('id', $item->tournament_template_id)->value('sport_id');
            }
        });
    }
}
