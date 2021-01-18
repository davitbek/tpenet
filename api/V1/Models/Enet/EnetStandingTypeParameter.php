<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStandingTypeParameter
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $standing_type_id
 * @property string $code
 * @property string $name
 * @property int $is_deleted
 * @property string $type
 * @property string $value
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetStandingType $standing_type
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereStandingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingTypeParameter whereValue($value)
 * @mixin \Eloquent
 */
class EnetStandingTypeParameter extends BaseModel
{
    protected $table = 'enet_standing_type_parameters';

    public $fillable = [
        'id',
        'standing_type_id',
        'order',
        'is_active',
        'code',
        'name',
        'is_deleted',
        'type',
        'value',
        'n',
    ];

    public function standing_type()
    {
        return $this->belongsTo(EnetStandingType::class, 'standing_type_id');
    }
}
