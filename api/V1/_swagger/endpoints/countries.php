<?php
/**
 *@OA\Get(
 *     path="/countries",
 *     deprecated=true,
 *     tags={"Country"},
 *     summary="Find all countries with iso2 => country",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/countries/list",
 *     tags={"Country"},
 *     summary="Find all countries with id => country",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/countries/all",
 *     tags={"Country"},
 *     summary="Find all countries",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/countries/get",
 *     deprecated=true,
 *     tags={"Country"},
 *     summary="Find country based user ip",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/countries/default",
 *     tags={"Country"},
 *     summary="Find country based request ip(user deveult country)",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/countries/{id}",
 *     tags={"Country"},
 *     summary="Find country based country id",
 *     @OA\Parameter(
 *          description="id of counry",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/countries/by-ip/{ip}",
 *     tags={"Country"},
 *     summary="Find country based ip address",
 *     @OA\Parameter(
 *          description="ip of request",
 *          name="ip",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/languages",
 *     tags={"Language"},
 *     summary="Find all languages",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/languages/by-country/{id}",
 *     tags={"Language"},
 *     summary="Find all languages and sorted country related languages firstly",
 *     @OA\Parameter(
 *          description="id of counry",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/timezones",
 *     tags={"Timezone"},
 *     summary="Find all timezones",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 * @OA\Get(
 *     path="/timezones/by-country/{id}",
 *     tags={"Timezone"},
 *     summary="Find all timezones and sorted country related timezones firstly",
 *     @OA\Parameter(
 *          description="id of counry",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Get(
 *     path="/odd-types",
 *     tags={"OddType"},
 *     summary="Find all odd types",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */