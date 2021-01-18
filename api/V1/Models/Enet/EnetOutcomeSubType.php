<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetOutcomeSubType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeSubType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetOutcomeSubType extends BaseModel
{

    protected $table = 'enet_outcome_subtypes';

    public $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'description',
    ];

}
