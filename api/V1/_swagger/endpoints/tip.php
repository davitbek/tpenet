<?php
/**
 *@OA\Get(
 *     path="/tips",
 *     tags={"Tip"},
 *     summary="Find all tips",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Tip",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/tips/{tip_id}",
 *     tags={"Tip"},
 *     summary="Find single tips",
 *     @OA\Parameter(
 *          name="tip_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/TipSingle",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *  @OA\Post(
 *     path="/tips",
 *     tags={"Tip"},
 *     summary="Create new tip",
 *     @OA\Parameter(
 *          name="amount",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="event_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="market_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="odd_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="odd_price",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="comment",
 *          in="path",
 *          @OA\Schema(
 *              type="string"
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
 *     @OA\Response(
 *          response=401,
 *          description="validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  ref="$/components/schemas/ValidationError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )

 *@OA\Get(
 *     path="/users/{id}/tips/active",
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
 *  @OA\Get(
 *     path="/users/{id}/tips/ended",
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
 *@OA\Get(
 *     path="/users/{id}/followers/tips/active",
 *     tags={"Tip", "User"},
 *     summary="Find user follower current tips old",
 *      @OA\Parameter(
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
 *@OA\Get(
 *     path="/users/{id}/followers/tips/ended",
 *     tags={"Tip", "User"},
 *     summary="Find user follower ended tips old",
 *      @OA\Parameter(
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
 *@OA\Get(
 *     path="/users/auth/followers/tips/active",
 *     tags={"Tip", "User", "Auth"},
 *     summary="Find auth user follower current tips old",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Tip",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/users/auth/followers/tips/ended",
 *     tags={"Tip", "User", "Auth"},
 *     summary="Find auth user follower ended tips old",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Tip",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 * @OA\Get(
 *     path="/events/{event_id}/tips",
 *     tags={"Tip", "Event"},
 *     summary="Find all event tips",
 *     @OA\Parameter(
 *          name="event_id",
 *          description="event id",
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
 */