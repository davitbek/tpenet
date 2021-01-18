<?php

namespace LaraAreaApi\Providers;

use LaraAreaSupport\LaraAreaServiceProvider;

class ServiceProvider extends LaraAreaServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->mergeConfig(__DIR__);
    }

    /**
     *
     */
    public function register()
    {
        $this->registerFunctions(__DIR__);
    }
}

