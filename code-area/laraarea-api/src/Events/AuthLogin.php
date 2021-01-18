<?php

namespace LaraAreaApi\Events;

use Illuminate\Queue\SerializesModels;

class AuthLogin
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * @var
     */
    public $tokens;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  []  $tokens
     * @return void
     */
    public function __construct($user, $tokens)
    {
        $this->user = $user;
        $this->tokens = $tokens;
    }
}
