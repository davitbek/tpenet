<?php

namespace LaraAreaSupport\Providers;

use LaraAreaSupport\LaraAreaServiceProvider;
use LaraAreaSupport\LaraAreaDB;
use LaraAreaSupport\LaraPassword;

class LaraAreaSupportServiceProvider extends LaraAreaServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->mergeConfig(__DIR__);
    }

    /**
     * @throws \Exception
     */
    public function register()
    {
        $this->registerFunctions(__DIR__);
        $this->registerAliases(
            [
                'LaraDB' => \LaraAreaSupport\Facades\LaraAreaDB::class,
                'LaraPassword' => \LaraAreaSupport\Facades\LaraPassword::class,
            ]
        );
        $this->registerSingletons([
            'laraarea-db' => LaraAreaDB::class,
            'laraarea-password' => LaraPassword::class,
        ]);
    }
}
