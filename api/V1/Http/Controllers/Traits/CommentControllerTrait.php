<?php

namespace Api\V1\Http\Controllers\Traits;

use Api\V1\Services\CommentService;
use Api\V1\Transformers\CommentTransformer;
use Illuminate\Http\Request;

trait CommentControllerTrait
{
    /**
     * @param CommentService $commentService
     * @param CommentTransformer $commentTransformer
     * @param $itemId
     * @param Request $request
     * @return mixed
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function storeComment(CommentService $commentService, CommentTransformer $commentTransformer, Request $request, $itemId)
    {
        $type = $this->getResourceName();
        $result = $commentService->create([
            'comment' => $request->comment,
            'commentable_type' => $type,
            'commentable_id' => $itemId
        ]);
        return $this->sendSuccess($result, null, null, $commentTransformer);
    }

    /**
     * @param CommentService $commentService
     * @param CommentTransformer $commentTransformer
     * @param Request $request
     * @param $itemId
     * @return mixed
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function getComments(CommentService $commentService, CommentTransformer $commentTransformer, Request $request, $itemId)
    {
        $type = $this->getResourceName();
        $result = $commentService->commentsByType($type, $itemId, $data = $request->all());
        return $this->sendSuccess($result, null, null, $commentTransformer);
    }
}
