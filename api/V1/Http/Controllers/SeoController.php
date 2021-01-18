<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\SeoService;
use Illuminate\Http\Request;
use LaraAreaSeo\Cache\CachedSeo;

class SeoController extends BaseController
{
    /**
     * @var SeoService
     */
    protected $service;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSeoList(Request $request)
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
                'min' => $seoConfig->{$col . '_min'},
                'max' => $seoConfig->{$col . '_max'},
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

        $config = [
            'config' => $seoConfig->only('title_prepend_separator', 'title_append_separator', 'is_prepend_title', 'is_append_title', 'title_min', 'title_max'),
            'data' => $data
        ];
        return $this->response->success(['config' => $config, 'en' => CachedSeo::seoList()]);
    }
}
