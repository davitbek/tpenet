<?php

namespace LaraAreaUpload\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use LaraAreaUpload\Rules\UniqueUploadRule;

class AreaUploadServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $rule = new UniqueUploadRule();
        Validator::extend($rule->getRule(), UniqueUploadRule::class, $rule->message());
    }

    /**
     * @throws \Exception
     */
    public function register()
    {

    }
}
