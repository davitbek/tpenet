<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetRoundType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $value
 * @property int $is_knockout
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereIsKnockout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetRoundType whereValue($value)
 * @mixin \Eloquent
 */
class EnetRoundType extends BaseModel
{
    protected $table = 'enet_round_types';

    public $fillable = [
        'id',
        'name',
        'value',
        'is_knockout',
        'n',
        'is_deleted',
    ];

}
