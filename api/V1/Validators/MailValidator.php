<?php

namespace Api\V1\Validators;

class MailValidator extends BaseValidator
{
    /**
     * @return array
     */
    public function sendContactMessage()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string',
            'message' => 'required|string'
        ];
    }
}
