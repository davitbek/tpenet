<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetReference
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $object
 * @property int $object_id
 * @property int $refers_to
 * @property string $name
 * @property int $is_deleted
 * @property int $n
 * @property int $reference_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereReferenceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereRefersTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReference whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetReference extends BaseModel
{
    protected $table = 'enet_references';

    public $fillable = [
        'id',
        'object',
        'object_id',
        'refers_to',
        'name',
        'is_deleted',
        'n',
        'ut',
        'reference_type_id',
    ];

}
