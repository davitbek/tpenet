<?php

namespace Api\V1\Http\Controllers;

class PageController extends BaseController
{
    /**
     * @var bool
     */
    protected $makeDynamic = false;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function bettingInformation()
    {
        $data = [
            'play_responsible' => __('gambling_aware.play_responsible'),
            'local' => __('gambling_aware.local'),
            'disclaimer' => __('gambling_aware.disclaimer'),
        ];
        return $this->response->success($data);
    }
}
