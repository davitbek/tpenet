<?php

namespace Api\V1\Models\Enet;

use Api\V1\Models\BaseModel as Model;

/**
 * Class BaseModel
 *
 * @package Api\V1\Models\Enet
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    /**
     * @return mixed
     */
    public function getResource()
    {
        $resource = parent::getResource();
        return str_replace('enet_', '', $resource);
    }

    public function showClass()
    {
        dd(get_class($this));
    }

    public function getClass()
    {
        dd(get_class($this));
    }
}
