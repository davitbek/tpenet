<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetOffenceType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOffenceType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetOffenceType extends BaseModel
{
    protected $table = 'enet_offence_types';

    protected $fillable = [
        'id',
        'name',
        'n',
        'ut',
        'is_deleted',
    ];

}
