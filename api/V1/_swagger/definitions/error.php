<?php

/**
 * @OA\Schema(
 *      schema="GeneralError",
 *      @OA\Property(
 *          property="errorCode",
 *          description="Values
 *     const UN_CATEGORIZED = 1;
 *     const VALIDATION = 11;
 *     const HEADER_MISSED = 12;
 *     const NOT_FOUND = 13;
 *     const EMAIL_ALREADY_USED = 14;
 *     const ACCESS_TOKEN_INVALID = 15;
 *     const ACCESS_TOKEN_EXPIRED = 16;",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *      ),
 * )
 * @OA\Schema(
 *      schema="ValidationError",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="attributes",
 *          ref="$/components/schemas/ValidationAttributesError"
 *      ),
 * )
 *
 *  @OA\Schema(
 *      schema="ValidationAttributesError",
 *      type="object",
 *      @OA\Property(
 *          property="attribute1",
 *          type="array",
 *          items={"type"="string"}
 *      ),
 *      @OA\Property(
 *          property="attribute2",
 *          type="array",
 *          items={"type"="string"}
 *      ),
 *      @OA\Property(
 *          property="attributeName",
 *          type="array",
 *          items={"type"="string"}
 *      ),
 *  ),
 */
