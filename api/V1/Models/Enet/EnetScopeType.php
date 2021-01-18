<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetScopeType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetScopeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetScopeType extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'enet_scope_types';

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
