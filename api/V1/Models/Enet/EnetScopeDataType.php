<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetScopeDataType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeDataType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetScopeDataType extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'enet_scope_data_types';

    /**
     * @var array
     */
    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'ut',
        'is_deleted',
    ];

}
