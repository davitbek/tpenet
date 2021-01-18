<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetReferenceType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetReferenceType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetReferenceType extends BaseModel
{

    protected $table = 'enet_reference_types';

    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'ut',
        'is_deleted',
    ];

}
