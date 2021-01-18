<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path() . '/Helpers/*.php') as $filename) {
            require_once($filename);
        }

        $apiPath = base_path('api');
        $apiProviders = glob($apiPath . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR .  'Providers' . DIRECTORY_SEPARATOR . '*.php');

        foreach ($apiProviders as $providerFilename) {
            $providerFilename = str_replace([$apiPath, '.php'], ['', ''], $providerFilename);
            $providerFilename = 'Api' . $providerFilename;
            $providerFilename = str_replace(DIRECTORY_SEPARATOR, '\\', $providerFilename);
            $this->app->register($providerFilename);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
