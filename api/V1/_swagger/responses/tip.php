<?php
/**
 *     @OA\Response(
 *          response="Tip",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/userTip"),
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
 *          response="TipSingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="#/components/schemas/userTip",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *          )
 *     ),
 *
 */