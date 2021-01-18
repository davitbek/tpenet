<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SeoMetaContent
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $seo_id
 * @property int|null $meta_id
 * @property int|null $meta_group_id
 * @property int|null $is_active
 * @property string|null $lang
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Meta|null $meta
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent newQuery()
 * @method static \Illuminate\Database\Query\Builder|SeoMetaContent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereMetaGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereSeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMetaContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SeoMetaContent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SeoMetaContent withoutTrashed()
 * @mixin \Eloquent
 */
class SeoMetaContent extends BaseModel
{
    use SoftDeletes;

    public $selectableWith = [
        'index' => [
            'parent',
            'seo',
            'meta',
        ],
        'show' => [
            'parent',
            'seo',
            'meta',
        ],
    ];

    public $passableWith = [
        'create' => [
            'parent',
            'seo',
            'meta',
        ],
        'update' => [
            'parent',
            'seo',
            'meta',
        ],
    ];

    public function parent()
    {
        return true;// @TODO fix
    }
    
    public function seo()
    {
        return true;// @TODO fix
    }
    
    public function meta()
    {
        return $this->belongsTo(Meta::class);
    }
}
