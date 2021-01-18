<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStandingType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStandingType extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'enet_standing_types';

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
