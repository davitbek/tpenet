<?php
/**
 *     @OA\Response(
 *          response="EnetTournamentTemplate",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/EnetTournamentTemplate"),
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
 *          response="EnetTournamentTemplateSingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="#/components/schemas/EnetTournamentTemplate",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *          )
 *     ),
 *
 */