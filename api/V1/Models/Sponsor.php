<?php

namespace Api\V1\Models;

/**
 * Class Sponsor
 *
 * @package Api\V1\Models
 * @property int $id
 * @property string $name
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $image_url
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sponsor extends BaseModel
{
    public $fillable = [
        'name',
        'image_path',
        'image_disk',
];

    public $wrap = [
        'image_url' => [
            'image_disk',
            'image_path'
        ]
    ];

    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }
}
