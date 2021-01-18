<?php

/**
 * @OA\Schema(
 *      schema="PaginationAdditional",
 *      @OA\Property(
 *          property="links",
 *          type="object",
 *          @OA\Property(
 *              property="first",
 *              type="url",
 *              example="http://tipya.com/api/v1/users/201/tips/ended?page=1"
 *          ),
 *          @OA\Property(
 *              property="last",
 *              type="url",
 *              example="http://tipya.com/api/v1/users/201/tips/ended?page=27"
 *          ),
 *          @OA\Property(
 *              property="prev",
 *              type="url",
 *              example="http://tipya.com/api/v1/users/201/tips/ended?page=10"
 *          ),
 *          @OA\Property(
 *              property="next",
 *              type="url",
 *              example="http://tipya.com/api/v1/users/201/tips/ended?page=12"
 *          ),
 *      ),
 *      @OA\Property(
 *          property="meta",
 *          ref="$/components/schemas/meta",
 *      )
 * )
 */
