<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Models\Enet\EnetSport;
use Api\V1\Models\User;
use Api\V1\Models\UserTipStatistic;
use Api\V1\Transformers\Enet\EnetSportTransformer;
use Illuminate\Http\Request;
use LaraAreaApi\Exceptions\ApiException;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param $tipId
     * @param $emotionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function tipReactedUsers(Request $request, $tipId, $emotionId)
    {
        $options = [
            'columns' => [
                'id',
                'name'
            ],
            'where_has' => [
                'tipEmotions' => [
                    'where' => [
                        'emotion_id' => $emotionId,
                        'emotionables.emotionable_id' => $tipId,
                    ],
                ]
            ],
        ];
        if ($this->getAuthId()) {
            $options['select_raw'] = 'exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $this->getAuthId() .') as is_follow';
        }
        $request->merge($options);
        return $this->indexTransformBy($request, 'transformReactedUser');
    }

    /**
     * @param Request $request
     * @param $commentId
     * @param $emotionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function commentReactedUsers(Request $request, $commentId, $emotionId)
    {
        $options = [
            'columns' => [
                'id',
                'name'
            ],
            'where_has' => [
                'commentEmotions' => [
                    'where' => [
                        'emotion_id' => $emotionId,
                        'emotionables.emotionable_id' => $commentId,
                    ],
                ]
            ],
        ];
        if ($this->getAuthId()) {
            $options['select_raw'] = 'exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $this->getAuthId() .') as is_follow';
        }
        $request->merge($options);
        return $this->indexTransformBy($request, 'transformReactedUser');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function thisMonthRank(Request $request)
    {
        return $this->rankByMonth($request, this_month());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function prevMonthRank(Request $request)
    {
        return $this->rankByMonth($request, prev_month());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function thisMonthPosition(Request $request)
    {
        return $this->positionByMonth($request, this_month());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prevMonthPosition(Request $request)
    {
        return $this->positionByMonth($request, prev_month());
    }

    /**
     * @param Request $request
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function positionByMonth(Request $request, $month)
    {
        $item = $this->getAuth();
        $col = 'user_profit_position';
        $statistic = UserTipStatistic::where('period', $month)->where('user_id', $this->getAuthId())->first();
        $data = [
            'pos' => $statistic->{$col} ?? UserTipStatistic::where('period', $month)->max($col) + 1,
            'all_users_pos' => $statistic->profit_position ?? UserTipStatistic::where('period', $month)->max('profit_position') + 1,
            'user_id' => $item->id,
            'name' => $item->name,
            'profile_url' => $item->profile_url,
            'profit' => number_format($statistic->profit ?? 0),
            'percent' => round($statistic->win_percent ?? 0),
            'placed_tip_count' => $statistic ? ($statistic->win_count + $statistic->lost_count) : 0,
            'loses_count' => $statistic->lost_count ?? 0,
        ];
        if ($month == this_month()) {
            $item->loadCount([
                'user_tips' => function ($q) {
                    $q->whereIn('result_validation', [
                        \ConstUserTipResultValidationStatus::NOT_VALIDATED,
                        \ConstUserTipResultValidationStatus::VALIDATION_ERROR
                    ]);
                }
            ]);
            $data['user_tips_count'] = $item->user_tips_count;
        }

        return $this->response->success($data);
    }

    /**
     * @param Request $request
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rankByMonth(Request $request, $month)
    {
        $options = [
            'columns' => [
                'user_id',
                'period',
                'profit',
                'lost_count',
                'win_count',
                'win_percent',
                'user_profit_position'
            ],
            'where' => [
                'period' => $month
            ],
            'order_by' => [
                'user_profit_position' => 'asc',
            ],
            'with' => [
                'user' => [
                    'select' => [
                        'id',
                        'name',
                        'profile_disk', 'profile_path',
                    ]
                ]
            ]
        ];

        if ($month == this_month()) {
            $options['with']['user']['with_count'] = [
                'user_tips' => function ($q) {
                    $q->whereIn('result_validation', [
                        \ConstUserTipResultValidationStatus::NOT_VALIDATED,
                        \ConstUserTipResultValidationStatus::VALIDATION_ERROR
                    ]);
                }
            ];
        }

        if ($this->getAuthId()) {
            $options['with']['user']['select_raw'] = 'exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $this->getAuthId() .') as is_follow';
        }
        $request->merge($options);
        return $this->rank($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rank(Request $request)
    {
        $model = new UserTipStatistic();
        $this->service->setModel($model);
        $result = $this->service->index($request->all());
        $response = $this->transformer->transform($result, $request, 'transformRank');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $options = [
            'with_count' => [
                'followers',
                'followings'
            ],
            'with' => [
                'user_tip_statistics' => [
                    'where' => [
                        'period' => this_month(),
                    ],
                    'columns' => [
                        'user_id',
                        'profit',
                        'win_percent'
                    ]
                ]
            ],
            'columns' => [
                'id',
                'name',
                'email',// @TODO provide or not
                'profile_disk',
                'profile_path',
                'bio',
            ]
        ];

        if ($this->getAuthId()) {
            $options['select_raw'] = 'exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $this->getAuthId() .') as is_follow';
        }
        $request->merge($options);
        $item = $this->service->findByArray($id, $request->all());
        if ($item) {
            $response = $this->transformer->transform($item, $request);
            return $this->response->success($response);
        }
        $message = sprintf('%s with this %s id not found', $this->resource_name, $id);
        return $this->response->notFoundItem($request, \ConstErrorCodes::NOT_FOUND, $message, [], 401);
    }

    /**
     * @param Request $request
     * @param null $sportKey
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function suggest(Request $request, $sportKey = null)
    {
        $user = $this->getAuth();
        $search = $request->search;
        $sport = null;
        if ($sportKey) {
            $sport = EnetSport::where('readable_id', $sportKey)->first(['id', 'image_path', 'image_disk', 'discover_disk', 'discover_path', 'readable_id', 'name']);
            if (empty($sport)) {
                throw new ApiException(\ConstErrorCodes::NOT_FOUND, 'sport key is not valid');
            }
        }
        $authId = $this->getAuthId();
        $users = User::where('id', '!=', $user->id ?? 0)
            ->when(
                $search,
                function ($q) use ($search){
                    $q->where('name', 'like',  '%' . $search . '%');
                },
                function($q) {
                    // @TODO
//                    $q->has('user_tips');
                }
            )->when($sport, function ($q) use ($sportKey) {
                $q->whereHas('user_tips', function ($q) use ($sportKey) {
                    $q->where('sport_readable_id', $sportKey);
                });
            })
            ->where('is_active', \ConstYesNo::YES)
            ->select('id', 'name', 'profile_disk', 'profile_path')
            ->when(
                $authId,
                function ($q) use ($authId) {
                    $q->selectRaw('exists(select id from `followers` where `following_user_id` = users.id and `follower_user_id` = '. $this->getAuthId() .') as is_follow');
                },
                function ($q) {
                    $q->selectRaw('0 as is_follow');
                }
            )
            ->paginate();
        $response = $this->transformer->transform($users, $request, 'transformSuggest');

        if ($sport) {
            $response['sport'] = (new EnetSportTransformer())->transform($sport);
            $response['sport']['discover_url'] = $sport->discover_url;
            $response['sport']['description'] = 'Popular users who have made tips in ' . $sport->name;
        }
        return $this->response->success($response);
    }
}
