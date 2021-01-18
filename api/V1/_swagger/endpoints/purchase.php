<?php
/**
 *@OA\Post(
 *     path="/Purchase",
 *     tags={"Purchase"},
 *     summary="new purchase",
 *     @OA\Parameter(
 *          name="type",
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
 *                  ref="$/components/schemas/Purchase",
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
 */