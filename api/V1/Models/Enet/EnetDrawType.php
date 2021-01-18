<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDrawType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDrawType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetDrawType extends BaseModel
{

    protected $table = 'enet_draw_types';

    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'ut',
        'is_deleted',
    ];

}
