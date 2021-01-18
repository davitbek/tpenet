<?php

namespace LaraAreaModel\Traits;

use Illuminate\Support\Facades\App;
use LaraAreaModel\Exceptions\CastException;
use LaraAreaModel\Interfaces\CastInterface;
use Illuminate\Support\Str;

trait CastsTrait
{
    /**
     * @var bool
     */
    protected $useCastClass = false;

    /**
     * The attributes that should be cast to callback or Castable interface.
     *
     * @return array
     */
    protected function casts()
    {
        return [];
    }

    /**
     * Determine if the cast type is a callback cast.
     *
     * @param  string  $cast
     * @return bool
     */
    protected function isCallableCast($cast)
    {
        return is_callable($cast);
    }

    /**
     * Determine if the cast type is a cast object.
     *
     * @param $cast
     * @param null $key
     * @return bool
     */
    protected function isCastObject($cast, $key = null)
    {
        if (! is_object($cast)) {
            return false;
        }

        if (is_a($cast, CastInterface::class)) {
            return true;
        }

        throw new CastException($key);
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        $castType = $this->getCastType($key);
        $cast = $this->getCasts()[$key];

        if ('function' == $castType) {
            return $cast($value);
        }

        if ('callback' == $castType) {
            /** @var $cast \Closure */
            return $cast($value);
        }

        if ('cast_object' == $castType) {
            /** @var $cast CastInterface */
            return $cast->handle($value);
        }

        if ('cast_class' == $castType) {
            /** @var $cast CastInterface */
            $cast = App::make($cast);
            return $cast->handle($value);
        }


        // @TODO use class constant and other

        return parent::castAttribute($key, $value);
    }

    /**
     * Get the type of cast for a model attribute.
     *
     * @param  string  $key
     * @return string
     */
    protected function getCastType($key)
    {
        $cast = $this->getCasts()[$key];

        if ($this->isFunctionCast($cast)) {
            return 'function';
        }

        if ($this->isCallableCast($cast)) {
            return 'callback';
        }

        if (is_subclass_of($cast, CastInterface::class)) {
            return 'cast_class';
        }

        if ($this->isCastObject($cast, $key)) {
            return 'cast_object';
        }

        if ($this->isCustomDateTimeCast($cast)) {
            return 'custom_datetime';
        }

        if ($this->isDecimalCast($cast)) {
            return 'decimal';
        }



        return trim(strtolower($cast));
    }

    /**
     * Determine if the cast type is a custom date time cast.
     *
     * @param  string  $cast
     * @return bool
     */
    protected function isCustomDateTimeCast($cast)
    {
        if (! is_string($cast)) {
            return false;
        }
        return strncmp($cast, 'date:', 5) === 0 ||
            strncmp($cast, 'datetime:', 9) === 0;
    }

    /**
     * Determine if the cast type is a decimal cast.
     *
     * @param  string  $cast
     * @return bool
     */
    protected function isFunctionCast($cast)
    {
        if (! is_string($cast)) {
            return false;
        }

        return function_exists($cast);
    }

    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        $casts = $this->getIncrementing()
            ? array_merge([$this->getKeyName() => $this->getKeyType()], $this->casts)
            : $this->casts;
        $casts = array_merge($casts, $this->casts());

        return $this->useCastClass ? $this->includeClassCasts($casts) : $casts;
    }

    /**
     * @param $casts
     * @return mixed
     */
    protected function includeClassCasts($casts)
    {
        $castClassAttributes = array_diff_key($this->attributes, $casts);
        $namespace = Str::after(get_class($this), '\\', 'Casts') . '\\'; // TODO check
        $namespace = str_replace('Models' . '\\', '', $namespace);

        foreach (array_keys($castClassAttributes) as $attribute) {
            $className = $namespace . ucfirst(Str::camel($attribute)) . 'Cast';
            if (class_exists($className)) {
                $casts[$attribute] = $className;
            }
        }

        return $casts;
    }
}