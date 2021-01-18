<?php

namespace Api\V1\Providers;

use Api\V1\Http\Middleware\ApiAuthHeader;
use App\Http\Middleware\ApiLocalization;
use LaraAreaApi\Providers\RouteServiceProvider as ApiRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ApiRouteServiceProvider
{
    /**
     * @var array
     */
    protected $includeMiddlewares = [
        ApiLocalization::class
    ];

    /**
     * @var array
     */
    protected $defaultMiddlewares = [
        'api',
        ApiAuthHeader::class
    ];

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

        $middlewares = array_merge($this->defaultMiddlewares, $this->includeMiddlewares);

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
                ->middleware($middlewares)
                ->namespace($namespace)
                ->group($routePath);
        }
    }
}
