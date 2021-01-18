<?php

/**
 * @OA\Schema(
 *   schema="User",
 *   @OA\Property(
 *      property="id",
 *      type="integer",
 *      example="1"
 *   ),
 *   @OA\Property(
 *      property="name",
 *      type="string",
 *      example="User Name"
 *   ),
 *   @OA\Property(
 *      property="email",
 *      type="string",
 *      example="hello@tipyasportsapp.com"
 *   ),
 *   @OA\Property(
 *      property="profile_url",
 *      type="string",
 *      example="http://tipya.com/uploads/profile_pics/default.jpg"
 *   ),
 *   @OA\Property(
 *      property="profit",
 *      type="integer",
 *      example="100"
 *   ),
 *   @OA\Property(
 *      property="percent",
 *      type="integer",
 *      example="25"
 *   ),
 *   @OA\Property(
 *      property="bio",
 *      type="text",
 *      example="Ser frem til en masse tips herinde!"
 *   ),
 *   @OA\Property(
 *      property="followers_count",
 *      type="integer",
 *      example="104"
 *   ),
 *   @OA\Property(
 *      property="following_count",
 *      type="integer",
 *      example="104"
 *   ),
 *   @OA\Property(
 *      property="follow_status",
 *      description="this columns available when user loged and look other user",
 *      type="boolean",
 *      example="false"
 *   ),
 * )
 *
 * * @OA\Schema(
 *   schema="Rank",
 *   @OA\Property(
 *      property="user_id",
 *      type="integer",
 *      example="1"
 *   ),
 *   @OA\Property(
 *      property="name",
 *      type="string",
 *      example="User Name"
 *   ),
 *   @OA\Property(
 *      property="profile_url",
 *      type="string",
 *      example="http://tipya.com/uploads/profile_pics/default.jpg"
 *   ),
 *   @OA\Property(
 *      property="profit",
 *      type="integer",
 *      example="100"
 *   ),
 *   @OA\Property(
 *      property="percent",
 *      type="integer",
 *      example="25"
 *   ),
 *   @OA\Property(
 *      property="placed_tip_count",
 *      type="integer",
 *      example="25"
 *   ),
 *   @OA\Property(
 *      property="loses_count",
 *      type="integer",
 *      example="25"
 *   ),
 * )
 */
