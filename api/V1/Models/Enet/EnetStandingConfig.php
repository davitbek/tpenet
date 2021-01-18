<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStandingConfig
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $standing_id
 * @property int $standing_type_param_id
 * @property int $is_deleted
 * @property string $value
 * @property int $n
 * @property string $sub_param
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetStandingTypeParameter $standing_type_parameter
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereStandingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereStandingTypeParamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereSubParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingConfig whereValue($value)
 * @mixin \Eloquent
 */
class EnetStandingConfig extends BaseModel
{
    protected $table = 'enet_standing_configs';

    public $fillable = [
        'id',
        'standing_id',
        'standing_type_param_id',
        'is_deleted',
        'value',
        'n',
        'ut',
        'sub_param',
    ];

    public function standing_type_parameter()
    {
        return $this->belongsTo(EnetStandingTypeParameter::class, 'standing_type_param_id');
    }

}
