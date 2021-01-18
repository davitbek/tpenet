<?php
/**
 *     @OA\Response(
 *          response="BookmakerOffer",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/BookmakerOffer"),
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="object"
 *              ),
 *              @OA\Property(
 *                  property="additional",
 *                  ref="$/components/schemas/PaginationAdditional",
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response="BookmakerOfferSingle",
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  @OA\Items(ref="#/components/schemas/BookmakerOffer"),
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              ),
 *          )
 *     ),
 *
 */