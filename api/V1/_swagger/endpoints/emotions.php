<?php
/**
 *@OA\get(
 *     path="/emotions",
 *     tags={"Emotion"},
 *     summary="general all emotion",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Post(
 *     path="/emotions/{emotion_id}/{type}/{relatedId}",
 *     tags={"Emotion", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="the type",
 *          name="type",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips", "comments"},
 *          ),
 *
 *     ),
 *     @OA\Parameter(
 *          description="item id must be add emotion",
 *          name="relatedId",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Post(
 *     path="/tips/{tip_id}/emotions/{emotion_id}",
 *     tags={"Emotion", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="tip_id",
 *          name="tip_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips"},
 *          ),
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Post(
 *     path="/comments/{comment_id}/emotions/{emotion_id}",
 *     tags={"Comment", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="comment_id",
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Delete(
 *     path="/emotions/{emotion_id}/{type}/{relatedId}",
 *     tags={"Emotion", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="the type",
 *          name="type",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips",  "comments"},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="item id must be add emotion",
 *          name="relatedId",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Delete(
 *     path="/tips/{tip_id}/emotions/{emotion_id}",
 *     tags={"Emotion", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="tip_id",
 *          name="tip_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"tips"},
 *          ),
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Delete(
 *     path="/comments/{comment_id}/emotions/{emotion_id}",
 *     tags={"Emotion", "Tip"},
 *    @OA\Parameter(
 *          description="emotion_id",
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="comment_id",
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"comments"},
 *          ),
 *
 *     ),
 *     summary="general settings",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Iap",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 */