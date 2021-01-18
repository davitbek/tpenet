<?php
/**
 *     @OA\Response(
 *          response="EnetSport",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/EnetSport"),
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *              @OA\Property(
 *                  property="additional",
 *                  ref="$/components/schemas/PaginationAdditional",
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response="EnetSportSingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="#/components/schemas/EnetSport",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *          )
 *     ),
 *
 */