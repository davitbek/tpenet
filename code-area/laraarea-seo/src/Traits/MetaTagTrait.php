<?php

namespace LaraAreaSeo\Traits;

use Illuminate\Support\Str;
use LaraAreaSeo\Cache\CachedSeo;

trait MetaTagTrait
{
    protected $seoConfigLimits;
    protected $template;
    protected $tags;

    /**
     * @param $data
     * @param bool $isMinify
     * @return array
     */
    protected function getTags($data, $isMinify = false)
    {
        $content = $this->getMetaContent($data, $isMinify);
        preg_match_all('#\[(.*?)\]#', $content, $matches);
        $tags = $matches[1];
        $tags = array_unique($tags);
        $tags = array_values($tags);

        return $tags;
    }

    /**
     * @param $data
     * @param false $isMinify
     * @param array $tags
     * @param array $resources
     * @param string $template
     * @return string
     */
    protected function getMetaContent($data, $isMinify = false, $tags = null, $resources = null, $template = '[%]')
    {
        $this->seoConfigLimits = $this->seoConfigLimits();
        $this->template = $template;
        $this->tags = $this->getTagReplaces($tags, $resources);
        $content = '';


        if (!empty($data['title'])) {
            $content .= $this->processTitle($data['title']);
            if (!$isMinify) {
                $content .= PHP_EOL;
            }
        }

        foreach ($data['metas'] as $metaData) {
            if (is_string($metaData)) {
                $content .= $this->replaceTagValue($metaData);
                if (!$isMinify) {
                    $content .= PHP_EOL;
                }
                continue;
            }

            $content .= '<meta';
            $key = isset($metaData['name']) ? 'name' : 'property';
            $value = $metaData[$key] ?? '';
            $limitData = $this->seoConfigLimits['data'][$key][$value] ?? [];

            foreach ($metaData as $attribute => $value) {
                $content .= sprintf(' %s="%s"', $attribute, $this->replaceTagValue($value, $limitData));
            }

            $content .= '>';
            if (!$isMinify) {
                $content .= PHP_EOL;
            }
        }

        return $content;
    }

    protected function processTitle($title)
    {
        if (!empty($this->seoConfigLimits['config'])) {
            $config = $this->seoConfigLimits['config'];
            $limitData = [
                'max' => $config['title_max'],
                'min' => $config['title_min'],
            ];
            $title = $config['title_prepend_separator'] . $this->replaceTagValue($title, $limitData) . $config['title_append_separator'];
        } else {
            $title = $this->replaceTagValue($title);
        }

        return sprintf('<title>%s</title>', $title);
    }

    protected function getTagReplaces($tags, $resources)
    {
        if (is_null($tags)) {
            return null;
        }
        $replace = [];
        foreach ($tags as $tag) {
            $parts = explode('.', $tag);
            $source = array_shift($parts);
            $source = $resources[$source] ?? null;
            if (is_null($source)) {
                $replace[$tag] = '';
                continue;
            }

            if (empty($parts)) {
                $val = is_string($source) || is_numeric($source) || is_array($source) ? $source : '';
                $replace[$tag] = $val;
                continue;
            }
            $val = '';
            foreach ($parts as $part) {
                $source = $source->{$part};
                if (is_object($source)) {
                    continue;
                }

                if (is_string($source) || is_numeric($source)) {
                    $val .= $source;
                }
            }

            $replace[$tag] = $val;
        }

        foreach ($replace as $tag => $value) {
            $replace[$tag] = $this->cleanString($value);
        }

        return $replace;
    }

    public static function seoConfigLimits()
    {
        $seoConfig = CachedSeo::seoConfig();
        $metas = CachedSeo::metas();

        $cols = [
            'robots',
            'description',
            'keywords',
        ];

        $data = [];
        foreach ($cols as $col) {
            $data['name'][$col] = [
                'min' => $seoConfig->{$col . '_min'} ?? null,
                'max' => $seoConfig->{$col . '_max'} ?? null,
            ];
        }

        foreach ($metas as $meta) {
            if ($meta->is_required_in_group) {
                foreach ($meta->meta_groups as $metaGroup) {
                    $data[$meta->attribute][$metaGroup->starts_with . $meta->attribute_value] = $meta->only('min', 'max');
                }
            }
            $data[$meta->attribute][$meta->attribute_value] = $meta->only('min', 'max');
        }

        if ($seoConfig) {
            $config = $seoConfig->only('title_prepend_separator', 'title_append_separator', 'title_min', 'title_max');
            if (empty($seoConfig->is_prepend_title)) {
                $config['title_prepend_separator'] = '';
            }
            if (empty($seoConfig->is_append_title)) {
                $config['title_append_separator'] = '';
            }
        } else {
            $config = [
                'title_prepend_separator' => '',
                'title_append_separator' => '',
                'title_min' => null,
                'title_max' => null
            ];
        }

        return [
            'config' => $config,
            'data' => $data
        ];
    }

    /**
     * @param $value
     * @param array $limits
     * @return string|string[]
     */
    protected function replaceTagValue($value, $limits = [])
    {
        $value = $this->cleanString($value);
        if (is_null($this->tags)) {
            return $value;
        }

        $max = $limits['max'] ?? 0;
        $min = $limits['min'] ?? 0;
        $includedTags = [];
        $valueLength = strlen($value);

        foreach ($this->tags as $tag => $tagValue) {
            $tagKey = str_replace('%', $tag, $this->template);
            $occurs = substr_count($value, $tagKey);

            for ($i = 0; $i < $occurs; $i++) {
                $includedTags[$tagKey] = $tagValue;
                $valueLength += strlen($tagValue) - strlen($tagKey);
            }
        }

        $keysCount = count($includedTags);
        if (0 == $keysCount) {
            return $value;
        }

        foreach ($includedTags as $tag => $_tagValue) {
            $tagValue = $this->processDynamicData($_tagValue, $min, $max, $valueLength, $keysCount);
            $valueLength += strlen($tagValue) - strlen($_tagValue);
            $value = str_replace($tag, $tagValue, $value);
            $keysCount--;
        }

        return $value;
    }

    /**
     * @param $tagValue
     * @param $min
     * @param $max
     * @param $valueLength
     * @param $count
     * @return false|mixed|string
     */
    protected function processDynamicData($tagValue, $min, $max, $valueLength, $count)
    {
        if ($min && $min > $valueLength) {
            $missed = ceil(($min - $valueLength) / $count);
            if ($tagValue) {
                $tagValue = Str::padLeft($tagValue, strlen($tagValue) + $missed, ' ' . $tagValue);
            } else {
                $tagValue = Str::padLeft($tagValue, $missed, config('app_name') . ' ');
            }
        }

        if ($max && $max < $valueLength) {
            $over = ceil(($valueLength - $max) / $count);
            if ($tagValue) {
                $tagValue = substr($tagValue, 0, strlen($tagValue) - $over);
            }
        }

        return $tagValue;
    }

    /**
     * @param $string
     * @return string
     */
    protected function cleanString($string)
    {
        return strip_tags($string);
    }
}
