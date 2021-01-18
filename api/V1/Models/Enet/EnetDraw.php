<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetDraw
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $name
 * @property int $object_type_id
 * @property int $object_id
 * @property int $draw_type_id
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereDrawTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereObjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetDraw whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetDraw extends BaseModel
{

    protected $table = 'enet_draws';

    public $fillable = [
        'id',
        'name',
        'object_type_id',
        'object_id',
        'draw_type_id',
        'n',
        'is_deleted',
    ];

    public function draw_configs()
    {
        return $this->hasMany(EnetDrawConfig::class, 'draw_id');
    }

    public function draw_events()
    {
        return $this->hasMany(EnetDrawEvent::class, 'draw_id');
    }

    public function draw_details()
    {
        return $this->hasMany(EnetDrawDetail::class, 'draw_id');
    }
}
