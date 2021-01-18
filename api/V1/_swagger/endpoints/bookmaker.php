<?php
/**
 *@OA\Get(
 *     path="/bookmakers",
 *     tags={"Bookmaker"},
 *     summary="Find all bookmaker",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/Bookmaker",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/bookmaker/{id}",
 *     tags={"Bookmaker"},
 *     summary="Find single bookmaker",
 *     @OA\Parameter(
 *         ref="$/parameters/id_in_path_required",
 *         description="The ID of the bookmaker ",
 *     ),
 *     @OA\Parameter(
 *         ref="$/parameters/per_page",
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/BookmakerSingle",
 *     ),
 *     @OA\Response(
 *          response=404,
 *          ref="$/responses/NotFound",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */