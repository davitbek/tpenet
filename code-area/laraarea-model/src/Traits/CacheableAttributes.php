<?php

namespace LaraAreaModel\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheableAttributes
{
    /**
     * @var
     */
    protected $cachedAttributes;

    /**
     * @var int
     */
    protected $cachedSeconds = 1;

    /**
     * @var float|int
     */
    protected $hourlyCache =  60 * 60;

    /**
     * @var float|int
     */
    protected $dailyCache =  24 * 60 * 60;

    /**
     * @var float|int
     */
    protected $weeklyCache =  7 * 24 * 60 * 60;

    /**
     * @var float|int
     */
    protected $monthlyCache =  30 * 24 * 60 * 60;

    /**
     * @var float|int
     */
    protected $yearlyCache =  30 * 24 * 60 * 60;

    /**
     * @var string
     */
    private $_foreverCache = 'forever';

    /**
     * Cache attribute during script
     *
     * @param $attribute
     * @param \Closure $closure
     * @return mixed
     */
    protected function localCacheAttribute($attribute, \Closure $closure)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }

        return $this->attributes[$attribute] = $closure();
    }

    /**
     * Cache attribute in storage
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $seconds
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageCacheAttribute($attribute, \Closure $closure, $seconds = null, $cacheChangeableKey = null)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }

        if ($seconds == $this->_foreverCache) {
            $seconds = null;
        } else {
            $seconds = $seconds ?? $this->cachedSeconds;
        }

        return Cache::remember($this->cacheKey($cacheChangeableKey) . ':' . $attribute, $seconds, function () use ($closure) {
            return $closure();
        });
    }

    /**
     * Cache attribute in storage hourly
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageHourlyCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        return $this->storageCacheAttribute($attribute, $closure, $this->hourlyCache, $cacheChangeableKey);
    }

    /**
     * Cache attribute in storage daily
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageDailyCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        return $this->storageCacheAttribute($attribute, $closure, $this->dailyCache, $cacheChangeableKey);
    }

    /**
     * Cache attribute in storage weekly
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageWeeklyCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        return $this->storageCacheAttribute($attribute, $closure, $this->weeklyCache, $cacheChangeableKey);
    }

    /**
     * Cache attribute in storage monthly
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageMonthlyCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        return $this->storageCacheAttribute($attribute, $closure, $this->monthlyCache, $cacheChangeableKey);
    }

    /**
     * Cache attribute in storage yearly
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function storageYearlyCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        return $this->storageCacheAttribute($attribute, $closure, $this->yearlyCache, $cacheChangeableKey);
    }

    /**
     * Cache attribute forever
     *
     * @param $attribute
     * @param \Closure $closure
     * @param null $cacheChangeableKey
     * @return mixed
     */
    protected function foreverCacheAttribute($attribute, \Closure $closure, $cacheChangeableKey = null)
    {
        $cacheChangeableKey = $cacheChangeableKey ?? $this->getKey();
        return $this->storageCacheAttribute($attribute, $closure, $this->_foreverCache, $cacheChangeableKey);
    }

    /**
     * Get cache key where for save each model identical way
     *
     * @param null $cacheChangeableKey
     * @return string
     */
    public function cacheKey($cacheChangeableKey = null)
    {
        $changeabale = $cacheChangeableKey ?? $this->{$this->getCacheableTimeStampAttribute()}->timestamp;

        return sprintf(
            "%s-%s-%s",
            $this->getTable(),
            $this->getKey(),
            $changeabale
        );
    }

    /**
     * Get timestapms
     *
     * @return mixed
     */
    public function getCacheableTimestampAttribute()
    {
        return self::UPDATED_AT;
    }

    /**
     * Helper function to get loaded relation
     *
     * @param $relation
     * @return mixed
     */
    public function getLoadedRelation($relation)
    {
        if (!$this->relationLoaded($relation)) {
            $this->load($relation);
        }
        return $this->relations[$relation];
    }

    /**
     * Cache relation
     *
     * @param $relation
     * @return mixed
     */
    public function getCachedRelation($relation)
    {
        return $this->storageCacheAttribute($relation, function () use ($relation) {
            return $this->getLoadedRelation($relation);
        });
    }

    /**
     * Forever cache relation
     *
     * @param $relation
     * @return mixed
     */
    public function getForeverCachedRelation($relation)
    {
        return $this->foreverCacheAttribute($relation, function () use ($relation) {
            return $this->getLoadedRelation($relation);
        }, $this->getKey());
    }

    /**
     * // @TODO
     *
     * @param $id
     * @param $attribute
     * @param null $seconds
     * @return mixed
     */
    public static function cacheAttribute($id, $attribute, $seconds = null)
    {
        $item = new static();
        $seconds = $seconds ?? $item->dailyCache;
        $cacheKay = $item->getTable() . $id . $attribute;
        return Cache::remember($cacheKay, $seconds, function () use ($item, $attribute, $id) {
            return $item->where($item->getKeyName(), $id)->value($attribute);
        });
    }
}