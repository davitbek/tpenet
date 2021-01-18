<?php
/**
 *@OA\Get(
 *     path="/bookmaker-offers",
 *     tags={"Bookmaker Offer"},
 *     summary="Find all bookmaker offers",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/BookmakerOffer",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/bookmaker-offers/{id}",
 *     tags={"Bookmaker Offer"},
 *     summary="Find single bookmaker offer",
 *     @OA\Parameter(
 *         ref="$/parameters/id_in_path_required",
 *         description="The ID of the bookmaker offers",
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          ref="$/responses/BookmakerOfferSingle",
 *     ),
 *     @OA\Response(
 *          response=404,
 *          ref="$/responses/NotFound",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */