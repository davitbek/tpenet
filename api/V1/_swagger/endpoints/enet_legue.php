<?php
/**
 * @OA\Get(
 *     path="/enet-leagues",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Find all enetpulse leagues",
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by league name",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="sport_id",
 *          in="query",
 *          description="Filtering response by sport",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country_id",
 *          in="query",
 *          description="Filtering response by country",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="year",
 *          in="query",
 *          description="Filtering response by year",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          description="limit response",
 *          @OA\Schema(
 *              type="integer",
 *              default=100,
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="users/auth/enet-leagues",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Find all enetpulse leagues",
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by league name",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="sport_id",
 *          in="query",
 *          description="Filtering response by sport",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country_id",
 *          in="query",
 *          description="Filtering response by country",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          description="limit response",
 *          @OA\Schema(
 *              type="integer",
 *              default=100,
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          description="Get favorite legaues has event that date",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="/auth/user/enet-leagues/favorite",
 *     deprecated=true,
 *     tags={"Enentpulse", "EnetLeague"},
 *     description="Make league favorite unfavorite, now need use <a href='https://tipya.com/api/docs#/Enentpulse/getusers_auth_enet_leagues' target='_blank'>users/auth/enet-leagues</a>",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *  *@OA\Post(
 *     path="/enet-leagues/{id}/favorite",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Make league favorite unfavorite",
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 * @OA\Post(
 *     path="/enet-leagues/mass-favorite",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Make many leagues as favorite and remove many leagues in favorite list",
 *     @OA\Parameter(
 *          name="new",
 *          in="query",
 *          required=true,
 *          description="leagues ids must be make as favorite",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                  type="integer"
 *              )
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="removed",
 *          in="query",
 *          required=true,
 *          description="leagues ids must be remove in favorite list",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                  type="integer"
 *              )
 *          ),
 *     ),
 *    @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by league name",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="sport_id",
 *          in="query",
 *          description="Filtering response by sport",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country_id",
 *          in="query",
 *          description="Filtering response by country",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          description="limit response",
 *          @OA\Schema(
 *              type="integer",
 *              default=100,
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="enet-leagues/by-sport/{sport_id}/favorite/{date?}",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Find all favorite leagues by date (not user)",
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          required=false,
 *          description="Get favorite leagues. By date by default current date",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/EnetTournamentStage",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="enet-leagues/by-sport/{sport_id}/{date?}",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Find all leagues by date (not user)",
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          required=false,
 *          description="Get leagues by date. By default current date",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/EnetTournamentStage",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *  *@OA\Get(
 *     path="/enet-country-leagues/by-sport/{sport_id}/{date?}",
 *     tags={"Enentpulse", "EnetLeague"},
 *     summary="Make league favorite unfavorite",
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          required=false,
 *          description="Get leagues by date. By default current date",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="sport_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 */