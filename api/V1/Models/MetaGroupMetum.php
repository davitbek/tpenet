<?php

namespace Api\V1\Models;

/**
 * Class MetaGroupMetum
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $meta_id
 * @property int|null $meta_group_id
 * @property string|null $default_content
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Meta|null $meta
 * @property-read \Api\V1\Models\MetaGroup|null $meta_group
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum whereDefaultContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum whereMetaGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaGroupMetum whereMetaId($value)
 * @mixin \Eloquent
 */
class MetaGroupMetum extends BaseModel
{
    protected $table = 'meta_group_meta';

    public $timestamps = false;

    public $selectableWith = [
        'index' => [
            'meta',
            'meta_group',
        ],
        'show' => [
            'meta',
            'meta_group',
        ],
    ];

    public $passableWith = [
        'create' => [
            'meta',
            'meta_group',
        ],
        'update' => [
            'meta',
            'meta_group',
        ],
    ];

    public function meta()
    {
        return $this->belongsTo(Meta::class);
    }
    
    public function meta_group()
    {
        return $this->belongsTo(MetaGroup::class);
    }
}
