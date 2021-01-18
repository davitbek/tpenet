<?php
/**
 *     @OA\Response(
 *          response="EnetTournamentStage",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/EnetTournamentStage"),
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
 *          response="EnetTournamentStageSingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="#/components/schemas/EnetTournamentStage",
 *              ),
 *              @OA\Property(
 *                  property="errors",
 *                  type="object"
 *              ),
 *          )
 *     ),
 *
 */