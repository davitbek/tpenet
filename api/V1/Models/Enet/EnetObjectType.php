<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetObjectType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetObjectType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetObjectType extends BaseModel
{

    protected $table = 'enet_object_types';

    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'ut',
        'is_deleted',
    ];

}
