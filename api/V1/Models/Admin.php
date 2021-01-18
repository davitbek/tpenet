<?php

namespace Api\V1\Models;

/**
 * Class Admin
 *
 * @package Api\V1\Models
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @mixin \Eloquent
 */
class Admin extends BaseModel
{
    protected $table = 'admin';

    public $hidden = [
        'password',
    ];
}
