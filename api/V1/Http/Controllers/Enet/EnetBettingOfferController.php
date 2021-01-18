<?php

namespace Api\V1\Http\Controllers\Enet;

use Api\V1\Models\Enet\EnetBettingOffer;
use Illuminate\Http\Request;

class EnetBettingOfferController extends BaseController
{

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $columns = [
            'id',
            'odds',
            'outcome_id',
            'is_active',
            'odds_provider_id',
            'betting_offer_status_id'
        ];
        $item = EnetBettingOffer::select($columns)
            ->with([
                'outcome' => function ($q) {
                    $q->with('event');
                }
            ])->find($id);
        if ($item) {
            $response = $item->only(['id', 'is_active', 'betting_offer_status_id', 'odds', 'odds_provider_id', 'outcome_id']);
            $response['outcome'] = $item->outcome
                ? $item->outcome->only(['object', 'object_id', 'id', 'outcome_sub_type_full_name', 'odds_name'])
                : [];
            return $this->response->success($response);
        } else {
            $message = $this->message('not_found', ['item' => $this->resource_name, 'id' => $id]);
            $code = laraarea_api_error_code('not_found');
            return $this->response->notFoundItem($request, $code, $message);
        }
    }
}
