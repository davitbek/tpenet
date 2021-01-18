<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetEventIncidentType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property string $name
 * @property int $player1
 * @property int $player2
 * @property int $team
 * @property string $comment
 * @property string $subtype1
 * @property string $subtype2
 * @property string|null $type
 * @property string $comment_type
 * @property string $player2_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_deleted
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereCommentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType wherePlayer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType wherePlayer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType wherePlayer2Type($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereSubtype1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereSubtype2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetEventIncidentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetEventIncidentType extends BaseModel
{
    protected $table = 'enet_event_incident_types';

    protected $fillable = [
        'id',
        'n',
        'name',
        'player1',
        'player2',
        'team',
        'comment',
        'subtype1',
        'subtype2',
        'type',
        'comment_type',
        'player2_type',
        'created_at',
        'updated_at',
        'is_deleted'
    ];
}
