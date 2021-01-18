<?php

/**
 * @OA\Schema(
 *   schema="EnetTournamentTemplate",
 *   @OA\Property(
 *      property="id",
 *      type="integer",
 *      example="1"
 *   ),
 *   @OA\Property(
 *      property="name",
 *      type="string",
 *      example="AFC Champions League 1"
 *   ),
 *   @OA\Property(
 *      property="gender",
 *      type="string",
 *      example="male"
 *   ),
 *   @OA\Property(
 *      property="readable_id",
 *      type="string",
 *      example="afc-champions-league-1"
 *   ),
 *   @OA\Property(
 *      property="sport",
 *      ref="#/components/schemas/EnetSport",
 *   ),
 * )
 *
 */
