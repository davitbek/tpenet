<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatisticDataType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $statistic_type_id
 * @property int $statistic_data_type_category_id
 * @property string $code
 * @property string|null $description
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereStatisticDataTypeCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereStatisticTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStatisticDataType extends BaseModel
{
    protected $table = 'enet_statistic_data_types';

    public $fillable = [
        'id',
        'name',
        'statistic_type_id',
        'statistic_data_type_category_id',
        'code',
        'description',
        'is_deleted',
        'n',
        'ut',
    ];

}
