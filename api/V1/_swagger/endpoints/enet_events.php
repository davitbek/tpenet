<?php
/**
 *@OA\Get(
 *     path="/auth/user/enet-events/favorite/{time}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get popular event by sport",
 *     @OA\Parameter(
 *          name="time",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              enum={"today", "next", "prev"}
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/enet-events/sports/{sport_id}/popular",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get popular event by sport",
 *     @OA\Parameter(
 *          name="sport_id",
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
 *@OA\Get(
 *     path="/enet-events/sports/{sport_id}/date/{date}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event by sport and date",
 *     @OA\Parameter(
 *          name="sport_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/enet-events/leagues/{league_id}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get events by league",
 *     @OA\Parameter(
 *          name="league_id",
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
 *@OA\Get(
 *     path="/enet-events/leagues/{league_id}/date/{date?}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event by league and date",
 *     @OA\Parameter(
 *          name="league_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="date",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/enet-events/{event_id}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event details",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/results",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event results available scores is",
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="score_types",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *              enum={"ordinary_time", "extra_time", "penalty_shootout", "final_result", "halftime", "running_score", "strokes_1st_round", "strokes_2nd_round", "strokes_3rd_round", "strokes_4th_round", "strokes_5th_round", "par", "position", "made_cut", "match_play_score", "weight", "period_1", "period_2", "period_3", "penalty_shootout_deprecated", "quarter_1", "quarter_2", "quarter_3", "quarter_4", "set_1", "set_2", "set_3", "set_4", "set_5", "won_sets", "tiebreak_1", "tiebreak_2", "tiebreak_3", "tiebreak_4", "tiebreak_5", "game_score", "set_6", "set_7", "rank", "duration", "points", "distance", "comment", "laps", "laps_behind", "pitstops", "inning_1", "inning_2", "inning_3", "inning_4", "inning_5", "inning_6", "inning_7", "inning_8", "inning_9", "extra_inning", "hits", "errors", "misses", "horse_racing_odds", "startnumber", "medal", "missed_shots", "additional_shots", "tries", "4s_points", "6s_points", "overs", "extras", "wickets", "second_points", "second_overs", "second_extra", "second_wickets", "speed", "jump_off_penalties", "jump_off_time", "net_points", "draw_number", "official_rating", "form", "age", "fastest_lap_point", "handicap", "place_win", "allowance", "strokes_points_1st_round", "strokes_points_2nd_round", "strokes_points_3rd_round", "strokes_points_4th_round", "strokes_points_5th_round", "wins", "rides", "best_time", "classification_points"}
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/enet-events/{event_id}/outcome-types",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event outcome types",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/bookmakers/{outcome_type_id}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event bookmakers",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/odds/{outcome_type_id}",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event odds",
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="outcome_type_id",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/bookmakers",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event bookmakers",
 *     deprecated=true,
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
 * @OA\Get(
 *     path="/enet-events/{event_id}/odds",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event odds",
 *     deprecated=true,
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="outcome_type_id",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/standings/participants",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event participant statistics",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/standings/teams",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event team statistics",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/overviews",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event overviews",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/overviews-extended",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event overviews",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/lineups",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event lineups",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/head-to-head",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event head-to-head",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/head-to-head-extended",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event head-to-head",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/home-team-events",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event head-to-head",
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
 *@OA\Get(
 *     path="/enet-events/{event_id}/away-team-events",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event head-to-head",
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
 *  @OA\Post(
 *     path="/enet-tips",
 *     tags={"Enentpulse", "Tip"},
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
 *          name="preodds_event_id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="odds_id",
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
 * @OA\Get(
 *     path="/enet-events/{event_id}/tips",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Get event tips",
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
 *  *@OA\Post(
 *     path="/enet-events/{id}/favorite",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="Make event favorite unfavorite",
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
 *  *@OA\Post(
 *     path="/enet-events/favorites/{id}/enable",
 *     tags={"Enentpulse", "EnetEvent"},
 *     summary="enable Desacble event sport notification",
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
 */