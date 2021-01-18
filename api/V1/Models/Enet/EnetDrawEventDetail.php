<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawEventDetail
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $draw_event_id
 * @property int $object_type_id
 * @property int $object_id
 * @property string|null $start_date
 * @property int $rank
 * @property int $draw_event_detail_id
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereDrawEventDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereDrawEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereObjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawEventDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetDrawEventDetail extends BaseModel
{

    protected $table = 'enet_draw_event_details';

    public $fillable = [
        'id',
        'draw_event_id',
        'object_type_id',
        'object_id',
        'start_date',
        'rank',
        'draw_event_detail_id',
        'n',
        'is_deleted',
    ];

}
