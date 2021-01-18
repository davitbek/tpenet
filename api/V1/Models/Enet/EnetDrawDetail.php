<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawDetail
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $draw_id
 * @property int $participant_id
 * @property string $rank
 * @property string $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereDrawId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawDetail whereValue($value)
 * @mixin \Eloquent
 */
class EnetDrawDetail extends BaseModel
{

    protected $table = 'enet_draw_details';

    public $fillable = [
        'id',
        'draw_id',
        'participant_id',
        'rank',
        'value',
        'n',
        'is_deleted',
    ];

}
