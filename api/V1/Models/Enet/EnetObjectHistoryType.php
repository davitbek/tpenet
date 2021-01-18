<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetObjectHistoryType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectHistoryType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetObjectHistoryType extends BaseModel
{

    protected $table = 'enet_object_history_types';

    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'is_deleted',
    ];

}
