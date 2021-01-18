<?php

namespace Api\V1\Validators;

class UserTipValidator extends BaseValidator
{
    /**
     * @return array
     */
    public function create()
    {
        return [
            'amount' => 'required|numeric|max:2500|min:10',
            'event_id' => 'required|numeric',
            'market_id' => 'required|numeric',
            'odd_id' => 'required|numeric',
            'odd_price' => 'required|numeric',
        ];
    }
}
