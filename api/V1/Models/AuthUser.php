<?php

namespace Api\V1\Models;

use LaraAreaApi\Models\ApiAuth;

/**
 * Class AuthUser
 * @package Api\V1\Models
 */
class AuthUser extends ApiAuth
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $resource = 'users';

    /**
     * @return mixed|string
     */
    public function getMorphClass()
    {
        return $this->getResource();
    }

    public $hidden = [
        'password',
    ];


    /**
     * @param $changes
     */
    public function mergeChanges($changes)
    {
        $this->changes = array_merge($this->changes, $changes);
    }

}
