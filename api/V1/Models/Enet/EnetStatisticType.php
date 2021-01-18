<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatisticType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStatisticType extends BaseModel
{
    protected $table = 'enet_statistic_types';

    public $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'description',
        'ut',
    ];

}
