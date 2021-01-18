<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\BettingDictionaryService;
use Api\V1\Transformers\BettingDictionaryTransformer;

class BettingDictionaryController extends BaseController
{
    /**
     * @var BettingDictionaryService
     */
    protected $service;

    /**
     * @var BettingDictionaryTransformer
     */
    protected $transformer;

    /**
     *
     */
    public function all()
    {
        $data = $this->service->all();
        $response = $this->transformer->transformAll($data);
        return $this->response->success($response);
    }

    /**
     *
     */
    public function bySlug($slug)
    {
        $data = $this->service->findBySlug($slug);
        $response = $this->transformer->transform($data);
        return $this->response->success($response);
    }
}
