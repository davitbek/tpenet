<?php
/**
 *@OA\Get(
 *     path="/competitions",
 *     tags={"Competition"},
 *     summary="Find all competitions",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Competition",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/competitions/{slug}",
 *     tags={"Competition"},
 *     summary="Find single competition",
 *     @OA\Parameter(
 *          description="slug of competition",
 *          name="slug",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="iteration of competition",
 *          name="iteration",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/CompetitionSingle",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 */