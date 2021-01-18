<?php
/**
 *@OA\Get(
 *     path="/app-versions/{version}",
 *     tags={"AppVersion"},
 *     summary="get version data",
 *     @OA\Parameter(
 *          description="version like 1.1.1",
 *          name="version",
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
 *                  property="result",
 *                  ref="$/components/schemas/AppVersion",
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