<?php

namespace Api\V1\Http\Controllers\Enet;

use Illuminate\Http\Request;

class EnetEventBookmakerController  extends BaseController
{
    /**
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function bookmakers(Request $request, $event_id)
    {
        $data['where']['event_id'] = $event_id;
        $data['all'] = true;
        $data['columns']= [
            'id',
            'event_id',
            'outcome_type_id',
            'outcome_scope_id',
            'outcome_subtype_id',
            'event_participant_number',
            'iparam',
            'iparam2',
            'dparam',
            'dparam2',
            'sparam',
        ];
        $request->merge($data);
        return parent::index($request); // TODO: Change the autogenerated stub
    }
}
