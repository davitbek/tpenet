<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawConfig
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $draw_id
 * @property string $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereDrawId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawConfig whereValue($value)
 * @mixin \Eloquent
 */
class EnetDrawConfig extends BaseModel
{

    protected $table = 'enet_draw_configs';

    public $fillable = [
        'id',
        'name',
        'draw_id',
        'value',
        'n',
        'is_deleted',
    ];

}
