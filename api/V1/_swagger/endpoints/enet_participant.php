<?php
/**
 * @OA\Get(
 *     path="/enet-teams",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse teams",
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by team name",
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
 * @OA\Get(
 *     path="users/auth/enet-teams",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse teams",
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by team name",
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
 * @OA\Post(
 *     path="/enet-teams/{id}/favorite",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Make team favorite unfavorite",
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
 *     path="/enet-teams/mass-favorite",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Make many teams as favorite and remove many teams in favorite list",
 *     @OA\Parameter(
 *          name="new",
 *          in="query",
 *          required=true,
 *          description="teams ids must be make as favorite",
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
 *          description="teams ids must be remove in favorite list",
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
 *          description="Filtering response by team name",
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
 * @OA\Get(
 *     path="/enet-teams/{team_id}",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse sports",
 *     @OA\Parameter(
 *          name="team_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-teams/{team_id}/last-events",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse sports",
 *     @OA\Parameter(
 *          name="team_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-teams/{team_id}/next-events",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse sports",
 *     @OA\Parameter(
 *          name="team_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-teams/{team_id}/participants",
 *     tags={"Enentpulse", "EnetTeam"},
 *     summary="Find all enetpulse sports",
 *     @OA\Parameter(
 *          name="team_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-participants",
 *     tags={"Enentpulse", "EnetParticipant"},
 *     summary="Find all enetpulse participants",
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Filtering response by team name",
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
 * @OA\Get(
 *     path="/enet-participants/{participant_id}",
 *     tags={"Enentpulse", "EnetParticipant"},
 *     summary="Find enetpulse participant",
 *     @OA\Parameter(
 *          name="participant_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-participants/{participant_id}/last-events",
 *     tags={"Enentpulse", "EnetParticipant"},
 *     summary="Find enetpulse participant last events",
 *     @OA\Parameter(
 *          name="participant_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-participants/{participant_id}/next-events",
 *     tags={"Enentpulse", "EnetParticipant"},
 *     summary="Find enetpulse participant next events",
 *     @OA\Parameter(
 *          name="participant_id",
 *          in="path",
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
 * @OA\Get(
 *     path="/enet-participants/{participant_id}/teams",
 *     tags={"Enentpulse", "EnetParticipant"},
 *     summary="Find enetpulse participant teams",
 *     @OA\Parameter(
 *          name="participant_id",
 *          in="path",
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
 **/