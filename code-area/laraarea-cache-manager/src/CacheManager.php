<?php

namespace LaraAreaCacheManager;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class CachedItems
 * @package App\Helpers
 *
 */
class CacheManager
{
    /**
     * @var float|int
     */
    protected static $daily = 24 * 60 * 60;

    /**
     * @var array
     */
    protected static $_cache = [];

    /**
     * @var array
     */
    protected static $_cacheSingle = [
    ];

    /**
     * @param $class
     * @param array $columns
     * @param null $cacheKey
     * @param callable|null $callback
     * @return mixed
     */
    public static function cachedModelClassDetails($class, $columns = ['*'], $cacheKey = null, callable $callback = null)
    {
        $cacheKey = $cacheKey ?? $class . '_' . implode('_', $columns);
        return self::cache($cacheKey, 365 * self::$daily, function () use ($class, $columns, $callback) {
            if ($callback) {
                $query = $class::select($columns);
                $callback($query);
                return $query->get();
            }
            return $class::get($columns);
        });
    }

    /**
     * @param $class
     * @param string $column
     * @param null $key
     * @return mixed
     */
    public static function cachedModelPluck($class, $column = 'id', $key = null)
    {
        return self::cache($class . '_pluck_' . implode('_', [$column, $key]), 365 * self::$daily, function () use ($class, $column, $key) {
            return $class::pluck($column, $key);
        });
    }

    /**
     * @param $class
     * @param $id
     * @param string $key
     * @param array $columns
     * @param null $cacheKey
     * @return mixed
     */
    public static function cachedModel($class, $id, $key = 'id', $columns = ['*'], $cacheKey = null)
    {
        if (in_array($class, self::$_cacheSingle)) {
            $cacheKey = $cacheKey ?? $class . '_single_' . $key . $id . implode('_', $columns);
            return self::cache($cacheKey, self::$daily, function () use ($class, $columns, $key, $id) {
                return $class::select($columns)->where($key, $id)->first();
            });
        }

        $items = self::cachedModelClassDetails($class, $columns);
        return $items->where($key, $id)->first();
    }

    /**
     * @param $cacheMethod
     * @param $id
     * @param string $key
     * @return mixed
     */
    public static function findInCache($cacheMethod, $id, $key = 'id')
    {
        return self::{$cacheMethod}()->where($key, '=', $id)->first();
    }

    /**
     * @param $class
     * @param $id
     * @param $column
     * @param string $key
     * @param null $cacheKey
     * @return mixed
     */
    public static function cachedModelAttribute($class, $id, $column, $key = 'id', $cacheKey = null)
    {
        $cacheKey = $cacheKey ?? $class . '_single_' . $id . '_' . $column;
        return self::cache($cacheKey, self::$daily, function () use ($class, $column, $key, $id) {
            return $class::where($key, $id)->value($column);
        });
    }

    /**
     * @param $class
     * @param $value
     * @param $key
     * @return mixed
     */
    public static function cachedModelList($class, $value, $key)
    {
        return self::cachedModelClassDetails($class, [$value, $key])->pluck($value, $key);
    }

    /**
     * @param $key
     * @param $ttl
     * @param $callback
     * @return mixed
     */
    private static function cache($key, $ttl, $callback)
    {
        if (!isset(self::$_cache[$key])) {
            self::$_cache[$key] = Cache::remember($key, $ttl, $callback);
        }

        return self::$_cache[$key];
    }

    /**
     * Used for cache forever any data
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function __callStatic($name, $arguments)
    {
        if (Str::startsWith($name, 'update')) {
            $name = Str::replaceFirst('update', '', $name);
            $dataMethod = $name . 'Data';
            $isUpdate = true;
        } else {
            $dataMethod = $name . 'Data';
            $isUpdate = false;
        }

        $cacheKey = 'cached_items_' . Str::snake($name);

        if (!method_exists(static::class, $dataMethod)) {
            throw new \Exception(sprintf('Please define [%s] method in [%s]', $dataMethod, static::class));
        }

        if ($isUpdate) {
            $data = static::{$dataMethod}(...$arguments);
            Cache::set($cacheKey, $data, 24 * 60 * 60);
        } else {
            $data = Cache::remember($cacheKey, null, function () use ($dataMethod, $arguments) {
                return static::{$dataMethod}(...$arguments);
            });
        }

        static::$_cache[$cacheKey] = $data;
        return static::$_cache[$cacheKey];

    }

}
