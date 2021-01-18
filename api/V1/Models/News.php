<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $active
 * @property string|null $brand
 * @property string|null $lang
 * @property string|null $headline
 * @property string|null $content
 * @property string|null $image_path
 * @property string|null $image_disk
 * @property string|null $started_at
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $image_url
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\MetaGroupMetum[] $meta_group_meta
 * @property-read int|null $meta_group_meta_count
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Query\Builder|News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImageDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|News withTrashed()
 * @method static \Illuminate\Database\Query\Builder|News withoutTrashed()
 * @mixin \Eloquent
 */
class News extends BaseModel
{
    use SoftDeletes;

    public $fillable = [
        'active',
        'brand',
        'lang',
        'headline',
        'content',
        'image_path',
        'image_disk',
        'started_at',
        'expires_at',
];

    public $wrap = [
        'image_url' => [
            'image_path',
            'image_disk',
        ]
    ];

    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }

    public function meta_group_meta()
    {
        return $this->hasMany(MetaGroupMetum::class);
    }
}
