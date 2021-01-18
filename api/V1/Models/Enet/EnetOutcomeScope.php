<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetOutcomeScope
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcomeScope whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetOutcomeScope extends BaseModel
{

    protected $table = 'enet_outcome_scopes';

    public $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'description',
    ];

}
