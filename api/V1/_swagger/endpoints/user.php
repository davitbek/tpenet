<?php
/**
 *@OA\Get(
 *     path="/users/{id}",
 *     tags={"User"},
 *     summary="Find user",
 *     description="Find user. If you are logged and find other user also show follow that user or not follow_status:true,false",
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/User",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/auth",
 *     tags={"Auth", "User"},
 *     summary="Retrive logged user",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *                  ref="$/components/schemas/User",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/GeneralError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/suggest/{?sport_key}",
 *     tags={"User"},
 *     summary="User suggestion",
 *     @OA\Parameter(
 *          description="sport_key like football, tennis",
 *          name="sport_key",
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="search user",
 *          name="search",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
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
 *
 *@OA\Get(
 *     path="/users/{id}/tips",
 *     tags={"User", "Tip"},
 *     summary="user all tips",
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Tip",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 *@OA\Get(
 *     path="/users/{id}/statistics/monthly",
 *     tags={"User", "Statistic"},
 *     summary="user last year statistic",
 *     @OA\Parameter(
 *          ref="$/parameters/id_in_path_required",
 *          description="The ID of the User",
 *      ),
 *     @OA\Parameter(
 *          name="month_count",
 *          in="query",
 *          description="count of months for get statistics",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *      ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/StatisticGraph",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/rank/month/this",
 *     tags={"User", "Rank"},
 *     summary="this month user rank",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/rank/month/prev",
 *     tags={"User", "Rank"},
 *     summary="prev month user rank",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/rank/month/{month}",
 *     tags={"User", "Rank"},
 *     summary="any month user rank",
 *     @OA\Parameter(
 *          name="month",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              format="2019-06"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/auth/position/rank/month/this",
 *     tags={"User", "Rank"},
 *     summary="this month user rank position",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/auth/position/rank/month/prev",
 *     tags={"User", "Rank"},
 *     summary="prev month user rank position",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/users/auth/position/rank/month/{month}",
 *     tags={"User", "Rank"},
 *     summary="any month user rank position",
 *     @OA\Parameter(
 *          name="month",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              format="2019-06"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/tips/{tip_id}/emotions/{emotion_id}/users",
 *     tags={"User", "Emotion", "Tip"},
 *     summary="get tip reacted with certain emotion users",
 *     @OA\Parameter(
 *          name="tip_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/comments/{comment_id}/emotions/{emotion_id}/users",
 *     tags={"User", "Emotion", "Tip"},
 *     summary="get comment reacted with certain emotion users",
 *     @OA\Parameter(
 *          name="comment_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="emotion_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Rank",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */