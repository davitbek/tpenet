<?php

namespace LaraAreaApi\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Hashing\HashManager;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaraAreaModel\Traits\BaseModelTrait;
use Laravel\Passport\HasApiTokens;

class ApiAuth extends Authenticatable implements MustVerifyEmail
{
    use BaseModelTrait, HasApiTokens, Notifiable;

    /**
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }

    /**
     * @param $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        if ($password == $this->email . $this->getAuthPassword()) {
            return true;
        }

        $hasher = \App::make(HashManager::class);
        return $hasher->check($password, $this->getAuthPassword());
    }

}