<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetStanding
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $object
 * @property int $object_id
 * @property int $standing_type_id
 * @property string $name
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetProperty[] $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetStandingConfig[] $standing_configs
 * @property-read int|null $standing_configs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetStandingParticipant[] $standing_participants
 * @property-read int|null $standing_participants_count
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereStandingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetStanding whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetStanding extends BaseModel
{

    protected $table = 'enet_standings';

    public $fillable = [
        'id',
        'object',
        'object_id',
        'standing_type_id',
        'name',
        'is_deleted',
        'n',
    ];

    public function standing_participants()
    {
        return $this->hasMany(EnetStandingParticipant::class, 'standing_id');
    }

    public function standing_configs()
    {
        return $this->hasMany(EnetStandingConfig::class, 'standing_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(EnetProperty::class, 'object_id')->where('object', \ConstEnetObjectType::STANDING);
    }
}
