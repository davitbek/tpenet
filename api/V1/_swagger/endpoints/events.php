<?php
/**
 *@OA\Get(
 *     path="/events/sports/{sport_id}/popular",
 *     tags={"Event", "Sport"},
 *     summary="Find all popular event data",
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
 *          description="how many events return",
 *          name="limit",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *              default=10
 *          ),
 *
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * ),
 *@OA\Get(
 *     path="/events/sports/{sport_id}/date/{year}/{month}/{day}",
 *     tags={"Event", "Sport"},
 *     summary="Find all popular event data",
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
 *          description="year",
 *          name="year",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="month",
 *          name="month",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="day",
 *          name="day",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * ),
 *@OA\Get(
 *     path="/events/leagues/{league_id}",
 *     tags={"Event", "League"},
 *     summary="Find league event data",
 *     @OA\Parameter(
 *          description="The league id",
 *          name="league_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *              default=10
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="how many events return",
 *          name="limit",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * ),
 *
 *@OA\Get(
 *     path="/events/leagues/{league_id}/date/{date?}",
 *     tags={"Event", "League"},
 *     summary="Find league events by date",
 *     @OA\Parameter(
 *          description="The league id",
 *          name="league_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *              default=10
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="date",
 *          description="get selected date events",
 *          in="path",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          description="how many events return",
 *          name="limit",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="/events/{event_id}",
 *     tags={"Event"},
 *     summary="Find single events",
 *     @OA\Parameter(
 *          name="ecent_id",
 *          description="The event id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 */