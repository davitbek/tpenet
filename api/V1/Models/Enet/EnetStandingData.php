<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStandingData
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $standing_participants_id
 * @property int $standing_type_param_id
 * @property string|null $value
 * @property string $code
 * @property int $is_deleted
 * @property int $n
 * @property string $sub_param
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetStandingTypeParameter $standing_type_parameter
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereStandingParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereStandingTypeParamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereSubParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStandingData whereValue($value)
 * @mixin \Eloquent
 */
class EnetStandingData extends BaseModel
{
    protected $table = 'enet_standing_data';

    public $fillable = [
        'id',
        'standing_participants_id',
        'standing_type_param_id',
        'value',
        'code',
        'is_deleted',
        'n',
        'sub_param',
    ];

    public function standing_type_parameter()
    {
        return $this->belongsTo(EnetStandingTypeParameter::class, 'standing_type_param_id');
    }
}
