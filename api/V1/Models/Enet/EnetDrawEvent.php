<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawEvent
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $draw_id
 * @property int $round_type_id
 * @property int $draw_event_id
 * @property int $draw_order
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereDrawEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereDrawId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereDrawOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereRoundTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetDrawEvent extends BaseModel
{

    protected $table = 'enet_draw_events';

    public $fillable = [
        'id',
        'name',
        'draw_id',
        'round_type_id',
        'draw_event_id',
        'draw_order',
        'n',
        'is_deleted',
    ];

    public function round_type()
    {
        return $this->belongsTo(EnetRoundType::class, 'round_type_id');
    }

    public function draw_participants()
    {
        return $this->hasMany(EnetDrawEventParticipant::class, 'draw_event_id');
    }
}
