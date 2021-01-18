<?php

namespace LaraAreaModel\Traits;

trait BaseModelTrait
{
    use ResourceTrait, ArrayToQueryTrait, CastsTrait, OldChangesAttribute, CacheableAttributes;

    /**
     * Helper function to check attribute is exists ir not
     *
     * @param $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }
}