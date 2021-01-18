<?php
/**
 *@OA\Get(
 *     path="/iap",
 *     tags={"Iap"},
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