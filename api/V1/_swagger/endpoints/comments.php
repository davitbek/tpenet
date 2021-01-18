<?php
/**
 * @OA\Get(
 *     path="/comments/{commentable_type}/{commentable_id}",
 *     tags={"Comment"},
 *     summary="get Comments",
 *     @OA\Parameter(
 *          description="the object id must be add comment",
 *          name="commentable_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="the object must be add comment",
 *          name="commentable_type",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips"},
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *
 *      ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="tips/{tip_id}/comments",
 *     tags={"Comment", "Tip"},
 *     summary="get Comments of tip",
 *     @OA\Parameter(
 *          description="the tip id must be get comment",
 *          name="tip_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *
 *      ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="comments/{comment_id}/sub-comments",
 *     tags={"Comment"},
 *     summary="get sub comments of comment",
 *     @OA\Parameter(
 *          description="the comment id must be get sub comment",
 *          name="comment_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *
 *      ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/comments",
 *     tags={"Comment"},
 *     summary="Add new Comments",
 *     @OA\Parameter(
 *          description="the object id must be add comment",
 *          name="commentable_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="the object must be add comment",
 *          name="commentable_type",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips"},
 *          ),
 *
 *     ),
 *     @OA\Parameter(
 *          description="comment",
 *          name="comment",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/tips/{tip_id}/comments",
 *     tags={"Comment", "UserTip"},
 *     summary="Add new Comments",
 *     @OA\Parameter(
 *          description="the tip id must be add comment",
 *          name="tip_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="comment",
 *          name="comment",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/comments/{comment_id}/sub-comments",
 *     tags={"Comment"},
 *     summary="Add new sub comments",
 *     @OA\Parameter(
 *          description="the comment id must be add sub comment",
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="comment",
 *          name="comment",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Put(
 *     path="/comments/{comment_id}/update",
 *     tags={"Comment"},
 *     summary="Update own comment",
 *     @OA\Parameter(
 *          description="the comment id must be update",
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="comment",
 *          name="comment",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *     ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Delete(
 *     path="/comments/{comment_id}",
 *     tags={"Comment"},
 *     summary="Delete own comment",
 *     @OA\Parameter(
 *          description="the comment id must be delete",
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          ) *     ),
 *     security={{"Bearer":{}}}
 * )
 */