<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetOutcomeType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetOutcomeType extends BaseModel
{

    protected $table = 'enet_outcome_types';

    public $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'description',
    ];

}
