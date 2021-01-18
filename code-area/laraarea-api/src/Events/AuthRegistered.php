<?php

namespace LaraAreaApi\Events;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\SerializesModels;

class AuthRegistered extends Registered
{
    use SerializesModels;
}
