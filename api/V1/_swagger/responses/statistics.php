<?php
/**
 *  @OA\Response(
 *      response="StatisticGraph",
 *      description="Example extended response",
 *      @OA\Schema(
 *          @OA\Property(
 *              property="result",
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/Statistic"),
 *              example={
 *                  "September-2018": {
 *                      "win_percent": 54,
 *                      "profit": 3085
 *                  },
 *                  "October-2018": {
 *                      "win_percent": 55,
 *                      "profit": 6416
 *                  },
 *                  "other-month-name": {"..."},
 *                  "August-2019": {
 *                      "win_percent": 0,
 *                      "profit": 0
 *                  }
 *              }
 *          ),
 *          @OA\Property(
 *              property="errors",
 *              type="object"
 *          ),
 *      )
 *  ),
 *
 */