<?php

namespace Api\V1\Models;

use LaraAreaApi\Models\ApiModel;
use Traits\Models\UploadableTrait;

/**
 * Class BaseModel
 * @package Api\V1\Models
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
