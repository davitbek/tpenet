<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Seo
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id parent id used for many languages if no records in lang that case must be show parent_id metadata
 * @property int|null $is_active
 * @property int|null $is_prepend_title
 * @property int|null $is_append_title
 * @property int|null $is_minify
 * @property string|null $lang related to parent_id if parent_id is null that case language also must be null
 * @property string|null $route_name
 * @property string|null $headline this is used for humans not for seo
 * @property string $uri route uri
 * @property string|null $title
 * @property string|null $title_prepend_separator
 * @property string|null $title_append_separator
 * @property string|null $robots
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $html
 * @property array|null $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newQuery()
 * @method static \Illuminate\Database\Query\Builder|Seo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereGeneratedMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereHeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereIsAppendTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereIsMinify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereIsPrependTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereRobots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereTitleAppendSeparator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereTitlePrependSeparator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereUri($value)
 * @method static \Illuminate\Database\Query\Builder|Seo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Seo withoutTrashed()
 * @mixin \Eloquent
 */
class Seo extends BaseModel
{
    use SoftDeletes;

    protected $table = 'seo';

    protected $casts = [
        'tags' => 'array'
    ];

    public $selectableWith = [
        'index' => [
            'parent',
        ],
        'show' => [
            'parent',
        ],
    ];

    public $passableWith = [
        'create' => [
            'parent',
        ],
        'update' => [
            'parent',
        ],
    ];

    public function parent()
    {
        return true;// @TODO fix
    }
}
