<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetLineupType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLineupType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetLineupType extends BaseModel
{

    protected $table = 'enet_lineup_types';

    public $fillable = [
        'id',
        'n',
        'name',
        'is_deleted',
        'ut',
    ];

}
