<?php

namespace Api\V1\Models;

use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package Api\V1\Models
 */
class User extends BaseModel
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $resource = 'users';

    public $hidden = [
        'password',
    ];
}
