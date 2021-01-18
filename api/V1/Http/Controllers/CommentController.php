<?php

namespace  Api\V1\Http\Controllers;

use Traits\Controllers\Api\EmotionControllerTrait;
use Api\V1\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    use EmotionControllerTrait;

    /**
     * @var CommentService
     */
    public $service;

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function storeSubComment(Request $request, $commentId)
    {
        $result = $this->service->createSubComment($commentId, $request->all());
        return $this->sendSuccess($result);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function subComments(Request $request, $commentId)
    {
        $result = $this->service->subComments($commentId, $request->all());
        return $this->sendSuccess($result);
    }

    /**
     * @param Request $request
     * @param $commentableType
     * @param $commentableId
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function commentsByType(Request $request, $commentableType, $commentableId)
    {
        $result = $this->service->commentsByType($commentableType, $commentableId,  $request->all());
        $response = $this->transformer->transform($result, $request);
        return $this->response->success($response);
    }
}
