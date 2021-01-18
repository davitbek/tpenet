<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetResultType
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResultType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetResultType extends BaseModel
{

    protected $table = 'enet_result_types';

    public $fillable = [
        'id',
        'name',
        'code',
        'n',
        'ut',
        'is_deleted',
    ];

}
