<?php
/**
 *     @OA\Response(
 *          response="EnetCountry",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/EnetCountry"),
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
 *          response="EnetCountrySingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="#/components/schemas/EnetCountry",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *          )
 *     ),
 *
 */