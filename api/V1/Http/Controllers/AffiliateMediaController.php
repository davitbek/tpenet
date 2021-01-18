<?php

namespace Api\V1\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateMediaController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $lang = $this->getLanguage();
        $options = $this->getOptions($request, $lang);
        $result = $this->service->index($options);
        if (0 == $result->count()) {
            $options = $this->getOptions($request, 'en');
            $result = $this->service->index($options);
        }
        $response = $this->transformer->transformPaginator($result, $request);
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportAds(Request $request)
    {
        return $this->ads($request, ['show_sports' => \ConstYesNo::YES]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventAds(Request $request)
    {
        return $this->ads($request, ['show_event' => \ConstYesNo::YES]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventMobileAds(Request $request)
    {
        return $this->ads($request, ['show_mobile_event' => \ConstYesNo::YES]);
    }

    /**
     * @param $conditions
     * @return \Illuminate\Http\JsonResponse
     */
    public function ads($request, $conditions)
    {
        $options = [
            'columns' => [
                'image_disk',
                'image_path'
            ],
            'all' => true,
            'where' => $conditions
        ];
        $result = $this->service->index($options);
        $response = $this->transformer->transform($result, $request, 'transformAds');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $lang = $this->getLanguage();
        $options = $this->getOptions($request, $lang);
        unset($options['where']['category']);
        $request->merge($options);
        return parent::show($request, $id);
    }

    /**
     * @param $lang
     * @return mixed
     */
    protected function getOptions($request, $lang = null)
    {
        $options['columns'] ='id,odds_provider_id,is_mobile,category,product,title,description,link,image_path,image_disk,terms_and_conditions';
        $options['with'][] = 'odds_provider:id,brand';
        $category = $request->category ?? 'Welcome Bonus';

        if ($lang) {
            $options['where']['lang'] = $lang;
        }

        $options['where']['category'] = $category;
        $options['where']['active'] = \ConstYesNo::YES;
        $options['where'][] = ['expires_at', '>=', now()];
        $options['where'][] = ['started_at', '<=', now()];

        return $options;
    }
}
