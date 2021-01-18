<?php
/**
 *  @OA\Response(
 *      response="Rank",
 *      description="Example extended response",
 *      @OA\Schema(
 *          @OA\Property(
 *              property="result",
 *              @OA\Items(ref="#/components/schemas/Rank"),
 *          ),
 *          @OA\Property(
 *              property="errors",
 *              type="object"
 *          ),
 *      )
 *  ),
 */