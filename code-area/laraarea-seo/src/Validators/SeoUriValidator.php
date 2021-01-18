<?php

namespace LaraAreaSeo\Validators;

use Illuminate\Support\Str;
use LaraAreaSeo\Cache\CachedSeo;

class SeoUriValidator extends BaseValidator
{
    protected $mode = 'vue';
//    protected $mode = 'laravel';

    /**
     * @return array
     */
    public function create()
    {
        return [
            'route_name' => 'bail|required',
            'uri' => [
                'required',
                'unique' => 'unique:seo_uris,uri',
                function ($attribute, $value, $fails) {
                    $seoRoutes = CachedSeo::seoRoutes()->where('name', request('route_name'))->first();
                    $uri = $seoRoutes->uri;
                    $this->validateUri($uri, [$value], $fails);
                }
            ],
            'is_active' => $this->isCheckbox(),
        ];
    }

    /**
     * @param $uri
     * @param $values
     * @param $fails
     * @return mixed
     */
    protected function validateUri($uri, $values, $fails)
    {
        $errors = [];
        if (Str::contains($uri, '*')) {
            foreach ($values as $value) {
                if ($uri == $value) {
                    $errors[] = sprintf('This [%s] uri is equal main uri', $value);
                    continue;
                }
                if (!Str::is($uri, $value)) {
                    $errors[] = sprintf('This [%s] uri is not valid', $value);
                }
            }
            if ($errors) {
                return $fails($errors);
            }
            return;
        }

        $parts = explode('/', $uri);
        // TODO check :url case
        if (count($parts) == 1) {
            return $fails('This route can not have uris');
        }

        $requiredPattern = config('laraarea_seo.parameter.required');
        $optionPattern = config('laraarea_seo.parameter.optional');
        $optionPattern = $optionPattern ?? str_replace('*', '*?', $requiredPattern);

        foreach ($values as $value) {
            if ($uri == $value) {
                $errors[] = sprintf('This [%s] uri is equal main uri', $value);
                continue;
            }

            $valueParts = explode('/', $value);
            foreach ($parts as $index => $part) {
                if (Str::is($requiredPattern, $part)) {
                    if (Str::is($optionPattern, $part)) {
                        continue 2;
                    } else {
                        if (!isset($valueParts[$index])) {
                            $errors[] = sprintf('This [%s] uri is not valid', $value);
                            continue 2;
                        }
                    }
                } else {
                    if (!isset($valueParts[$index]) || $valueParts[$index] != $part) {
                        $errors[] = sprintf('This [%s] uri is not valid', $value);
                        continue 2;
                    }
                }
            }
        }

        if ($errors) {
            return $fails($errors);
        }
    }
}
