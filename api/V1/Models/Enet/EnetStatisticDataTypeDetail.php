<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatisticDataTypeDetail
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $statistic_data_type_id
 * @property string $name
 * @property string|null $description
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereStatisticDataTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStatisticDataTypeDetail extends BaseModel
{
    protected $table = 'enet_statistic_data_type_details';

    public $fillable = [
        'id',
        'statistic_data_type_id',
        'name',
        'description',
        'is_deleted',
        'n',
    ];

}
