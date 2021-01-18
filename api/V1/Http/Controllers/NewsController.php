<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Models\News;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $lang = $this->getLanguage();
        $options = $this->getOptions($lang);
        $result = $this->service->index($options);
        if (0 == $result->count()) {
            $options = $this->getOptions('en');
            $result = $this->service->index($options);
        }
        $response = $this->transformer->transform($result, $request);
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
        $options = $this->getOptions($lang);
        $request->merge($options);
        return parent::show($request, $id);
    }

    /**
     * @param $lang
     * @return mixed
     */
    protected function getOptions($lang)
    {
        $options['columns'] = 'id,brand,headline,content,image_url,created_at';
        $options['where']['lang'] = $lang;
        $options['where']['active'] = \ConstYesNo::YES;
        $options['where'][] = ['expires_at', '>=', now()];
        $options['where'][] = ['started_at', '<=', now()];
        $options['latest'] = true;
        return $options;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUnreadNewsCount()
    {
        $user = $this->getAuth();
        $user->loadCount('read_news');
        $newsCount = News::count();
        $unreadCount = $newsCount - $user->read_news_count;
        if ($unreadCount < 0) {
            $unreadCount = 0;
        }
        return $this->response->success(['count' => $unreadCount]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeAllAsRead()
    {
        $user = $this->getAuth();
        $user->load('read_news:news.id');
        $readNewsIds = $user->read_news->pluck('id');
        $newsIds = News::whereNotIn('id', $readNewsIds)->pluck('id');
        foreach ($newsIds as $newsId) {
            $user->read_news()->attach($newsId, ['read_at' => now()]);
        }

        return $this->response->success(['is_updated' => true]);
    }
}
