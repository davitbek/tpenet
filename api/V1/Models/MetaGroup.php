<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MetaGroup
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $is_active
 * @property string $starts_with values is twitter, open grapg
 * @property string $headline
 * @property string|null $comment_start
 * @property string|null $comment_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\MetaGroupMetum[] $meta_group_meta
 * @property-read int|null $meta_group_meta_count
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|MetaGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereCommentEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereCommentStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereHeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereStartsWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|MetaGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MetaGroup withoutTrashed()
 * @mixin \Eloquent
 */
class MetaGroup extends BaseModel
{
    use SoftDeletes;

    public $selectableWith = [
        'index' => [
            'meta_group_meta',
        ],
        'show' => [
            'meta_group_meta',
        ],
    ];

    public $passableWith = [
        'create' => [
            'meta_group_meta',
        ],
        'update' => [
            'meta_group_meta',
        ],
    ];

    public function meta_group_meta()
    {
        return $this->hasMany(MetaGroupMetum::class);
    }
}
