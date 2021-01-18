<?php

namespace Api\V1\Models;

use LaraAreaApi\Models\ApiModel;
use Traits\Models\UploadableTrait;

/**
 * Class BaseModel
 *
 * @package Api\V1\Models
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends ApiModel
{
    use UploadableTrait;

    /**
     * @return mixed|string
     */
    public function getMorphClass()
    {
        return $this->getResource();
    }

    public function mergeChanges($changes)
    {
        $this->changes = array_merge($this->changes, $changes);
    }
}
