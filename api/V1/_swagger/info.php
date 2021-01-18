<?php

/**
 * @OA\Swagger(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Tipya Api",
 *         @OA\License(name="MIT")
 *     ),
 *     host="tipya.com/api",
 *     basePath="/v1",
 *     schemes={"https"},
 *     consumes={"application/json"},
 *     produces={"application/json"},
 * )
 *
 * @OA\Response(
 *      response="NotFound",
 *      description="Not found Item",
 *      @OA\Schema(
 *          @OA\Property(
 *              property="result",
 *              type="string",
 *              example="null"
 *          ),
 *          @OA\Property(
 *              property="error",
 *              type="object",
 *              example={"message"="item with id not found"}
 *          )
 *     ),
 * ),
 */
