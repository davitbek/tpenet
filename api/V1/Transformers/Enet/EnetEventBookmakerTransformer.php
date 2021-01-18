<?php

namespace Api\V1\Transformers\Enet;

use Illuminate\Http\Request;

class EnetEventBookmakerTransformer extends BaseTransformer
{
    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $response = [
            'id' => (integer) $model->id,
            'event_id' => (integer) $model->event_id,
            'outcome_type_id' => (integer) $model->outcome_type_id,
            'outcome_scope_id' => (integer) $model->outcome_scope_id,
            'outcome_subtype_id' => (integer) $model->outcome_subtype_id,
            'event_participant_number' => (integer) $model->event_participant_number,
            'iparam' => (integer) $model->iparam,
            'iparam2' => (integer) $model->iparam2,
            'dparam' => (integer) $model->dparam,
            'dparam2' => (integer) $model->dparam2,
            'sparam' => (integer) $model->sparam,

        ];

        return $response;
    }
}
