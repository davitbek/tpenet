<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStatisticDataTypeCategory
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStatisticDataTypeCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStatisticDataTypeCategory extends BaseModel
{
    protected $table = 'enet_statistic_data_type_categories';

    public $fillable = [
        'id',
        'name',
        'description',
        'is_deleted',
        'n',
        'ut',
    ];

}
