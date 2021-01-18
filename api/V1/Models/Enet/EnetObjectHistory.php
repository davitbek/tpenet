<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetObjectHistory
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $object_type_id
 * @property int $object_id
 * @property int $object_history_type_id
 * @property string $value
 * @property string|null $date_from
 * @property string|null $date_to
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereObjectHistoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereObjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistory whereValue($value)
 * @mixin \Eloquent
 */
class EnetObjectHistory extends BaseModel
{

    protected $table = 'enet_object_histories';

    public $fillable = [
        'id',
        'object_type_id',
        'object_id',
        'object_history_type_id',
        'value',
        'date_from',
        'date_to',
        'n',
        'is_deleted',
    ];

}
