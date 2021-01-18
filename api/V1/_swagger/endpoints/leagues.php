<?php
/**

 *@OA\Get(
 *     path="/leagues/by-sport/{sport_id}/{date?}",
 *     tags={"League"},
 *     summary="Find all leagues by sport by date",
 *     @OA\Parameter(
 *          description="The sport id",
 *          name="sport_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="date based must be get leagues",
 *          name="date",
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *              default="null | current date"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *  *@OA\Get(
 *     path="/leagues/by-sport/{sport_id}/favorite/{date?}",
 *     tags={"League"},
 *     summary="Find all favorite leagues by sport by date",
 *     @OA\Parameter(
 *          description="The sport id",
 *          name="sport_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="date based must be get leagues",
 *          name="date",
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *              default="null | current date"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */