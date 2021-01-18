<?php
/**
 *@OA\Post(
 *     path="/users/{user_id}/follow",
 *     tags={"Follow", "User", "Auth"},
 *     summary="Folow(Unfollow) user",
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
 *@OA\Get(
 *     path="/users/{user_id}/followers",
 *     tags={"Follow", "User", "Auth"},
 *     summary="User Followers",
 *     @OA\Parameter(
 *          description="search user",
 *          name="search",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *      ),
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
 *@OA\Get(
 *     path="/users/{user_id}/followings",
 *     tags={"Follow", "User", "Auth"},
 *     summary="User followings",
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
 */