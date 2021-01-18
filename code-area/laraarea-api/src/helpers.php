<?php

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string|null  $key
 * @param  mixed  $default
 * @return mixed|\Illuminate\Config\Repository
 */
function laraarea_api($key = null, $default = null)
{
    if (is_null($key)) {
        return config('laraarea_api', $default);
    }

    return config('laraarea_api.' . $key, $default);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string|null  $name
 * @param  mixed  $default
 * @return mixed|\Illuminate\Config\Repository
 */
function laraarea_api_error_code($name, $default = null)
{
    return laraarea_api('error_codes.' . $name, $default);
}

/**
 * Translate the given message.
 *
 * @param  string  $key
 * @param  array  $replace
 * @param  string|null  $locale
 * @return string|array|null
 */
function __laraarea_api($key, $replace = [], $locale = null)
{
    $translation = laraarea_api('translation_path');
    if (! \Illuminate\Support\Str::endsWith($translation, '.')) {
        $translation .= '.';
    }
    return __($translation . $key, $replace);
}