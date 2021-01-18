<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetSport
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int|null $position
 * @property int $is_active
 * @property int $is_mobile
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string|null $discover_path
 * @property string|null $discover_disk
 * @property string|null $readable_id added manually
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read string $discover_url
 * @property-read string $icon_url
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereDiscoverDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereDiscoverPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereIsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereReadableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetSport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetSport extends BaseModel
{
    protected $table = 'enet_sports';

    protected $fillable = [
        'id',
        'position',
        'is_active',
        'is_mobile',
        'n',
        'is_deleted',
        'name',
        'readable_id',
        'created_at',
        'updated_at',
        'image_path',
        'image_disk',
        'discover_path',
        'discover_disk'
    ];

    /**
     * @return string
     */
    public function getIconUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }

    /**
     * @return string
     */
    public function getDiscoverUrlAttribute()
    {
        return $this->getUrlByAttribute('discover_path');
    }

//    public function getNameAttribute()
//    {
//        if ($this->id == 1) {
//            return 'Football';
//        }
//
//        return 'Football';
//        return $this->attributes['name'];
//    }
}
