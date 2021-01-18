<?php

namespace Api\V1\Validators;

class AuthValidator extends BaseValidator
{
    /**
     * @return array
     */
    public function register()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            'country' => ['string', 'max:100']
        ];
    }
}
