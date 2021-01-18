<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Models\UserTip;
use Api\V1\Models\UserTipStatistic;
use Api\V1\Models\User;
use Illuminate\Http\Request;

class UserTipStatisticController extends BaseController
{
    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function userStatistics(Request $request, $userId)
    {
        if (! User::where('id', $userId)->exists()) {
            return $this->response->notFoundItem($request, \ConstErrorCodes::NOT_FOUND, 'User not found');
        }
        $monthCount = (int)$request->month_count ?? 6;
        if (! is_int($monthCount) || $monthCount < 1 || $monthCount > 24) {
            $monthCount = 6;
        }
        $periods = last_months_periods_by($monthCount, 'M y');
        $data = [
            'where' => [
                'user_id' => $userId,
            ],
            'where_in' => [
                'period' => $periods
            ],
            'columns' => [
                'period', 'profit', 'win_percent'
            ],
            'all' => true
        ];
        $_statistics = $this->service->index($data);
        $statistics = [
            'all_time_profit' => format_number(UserTipStatistic::where('user_id', $userId)->sum('profit')),
            'all_time_avg_hitrate' => round(UserTipStatistic::where('user_id', $userId)->avg('win_percent')),
            'all_time_avg_odd' => round(UserTip::where('user_id', $userId)->avg('odds'), 2),
            'all_time_tip_count' => UserTip::where('user_id', $userId)->count(),
            'hitrate' => [],
            'profit' => [],
        ];

        foreach ($periods as $month => $period) {
            $statistic = $_statistics->where('period', $period)->first();
            $statistics['hitrate'][] = [
                'month' => $month,
                'value' => round($statistic->win_percent ?? 0)
            ];
            $statistics['profit'][] = [
                'month' => $month,
                'value' => $statistic ? round($statistic->getOriginal('profit')) : 0
            ];
        }

        $response['result'] = $statistics;
        return $this->response->success($statistics);
    }
}
