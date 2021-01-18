<?php
/**
 *@OA\Get(
 *     path="/news",
 *     tags={"News"},
 *     summary="Find all news",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/News",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/news/{id}",
 *     tags={"News"},
 *     summary="Find single news",
 *     @OA\Parameter(
 *         ref="$/parameters/id_in_path_required",
 *         description="The ID of the News",
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/NewsSingle",
 *     ),
 *     @OA\Response(
 *          response=404,
 *          ref="$/responses/NotFound",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="users/auth/news/unread/count",
 *     tags={"News"},
 *     summary="Get unread news count",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Put(
 *     path="/users/auth/news/make-all-as-read",
 *     tags={"News"},
 *     summary="Make all news as read",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 *
 */