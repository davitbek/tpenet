<?php

namespace LaraAreaApi\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use LaraAreaApi\Http\Middleware\ApiAuthHeader;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $namespace = str_replace($this->basename(), '', get_class($this));
        $namespace = str_replace('Providers\\', 'Http\Controllers', $namespace);

        $apiPath = base_path('api'). DIRECTORY_SEPARATOR ;
        $routePaths = glob($apiPath . '*' . DIRECTORY_SEPARATOR .  'routes' . DIRECTORY_SEPARATOR . '*.php');
        $isPlain = true;

        foreach($routePaths as $routePath) {
            if ($isPlain) {
                $prefix = str_replace($apiPath, '', $routePath);
                $prefix = head(explode(DIRECTORY_SEPARATOR, $prefix));
            } else {
                $prefix = str_replace([$apiPath, '.php', DIRECTORY_SEPARATOR, 'routes'], ['', '', '', '.'], $routePath);
            }
            $prefix = strtolower($prefix);

            Route::prefix('api/' . $prefix)
                ->as($prefix . '.')
                 ->middleware(['api', ApiAuthHeader::class])
                 ->namespace($namespace)
                 ->group($routePath);
        }
    }

    protected function basename()
    {
        $className = get_class($this);
        $parts = explode('\\', $className);
        return array_pop($parts);
    }
}
