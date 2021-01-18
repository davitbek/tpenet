<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\EmotionService;
use Api\V1\Transformers\EmotionPivotTransformer;
use Illuminate\Http\Request;

class EmotionController extends BaseController
{

    /**
     * @var EmotionService
     */
    protected $service;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index(Request $request)
    {
        $request->merge(['all' => true, 'order_by' => 'position']);
        return parent::index($request); // TODO: Change the autogenerated stub
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $itemId
     * @param EmotionPivotTransformer $emotionPivotTransformer
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function unassignItemFromEmotion($emotionId, $type, $itemId, EmotionPivotTransformer $emotionPivotTransformer)
    {
        $result = $this->service->unassignItemFromEmotion($emotionId, $type, $itemId);
        $response = $emotionPivotTransformer->transformDeletedModel($result);
        return $this->response->success($response);
    }

    /**
     * @param $emotionId
     * @param $type
     * @param $itemId
     * @param EmotionPivotTransformer $emotionPivotTransformer
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function assignItemToEmotion($emotionId, $type, $itemId, EmotionPivotTransformer $emotionPivotTransformer)
    {
        $result = $this->service->assignItemToEmotion($emotionId, $type, $itemId);
        $response = $emotionPivotTransformer->transform($result);
        return $this->response->success($response);
    }
}