<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Meta
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $is_active
 * @property int|null $only_in_groups
 * @property string $attribute values is property, name
 * @property string|null $attribute_value
 * @property string|null $default_content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\MetaGroupMetum[] $meta_group_meta
 * @property-read int|null $meta_group_meta_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\SeoMetaContent[] $seo_meta_contents
 * @property-read int|null $seo_meta_contents_count
 * @method static \Illuminate\Database\Eloquent\Builder|Meta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta newQuery()
 * @method static \Illuminate\Database\Query\Builder|Meta onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereAttributeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereDefaultContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereOnlyInGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Meta withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Meta withoutTrashed()
 * @mixin \Eloquent
 */
class Meta extends BaseModel
{
    use SoftDeletes;

    public $selectableWith = [
        'index' => [
            'meta_group_meta',
            'seo_meta_contents',
        ],
        'show' => [
            'meta_group_meta',
            'seo_meta_contents',
        ],
    ];

    public $passableWith = [
        'create' => [
            'meta_group_meta',
            'seo_meta_contents',
        ],
        'update' => [
            'meta_group_meta',
            'seo_meta_contents',
        ],
    ];

    public function meta_group_meta()
    {
        return $this->hasMany(MetaGroupMetum::class);
    }
    
    public function seo_meta_contents()
    {
        return $this->hasMany(SeoMetaContent::class);
    }
}
