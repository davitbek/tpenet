<?php

namespace LaraAreaSupport;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaraAreaServiceProvider extends ServiceProvider
{
    /**
     * @param $rootPath
     * @param $config
     * @param bool $isPublish
     */
    protected function mergeConfig($rootPath, $config = '', $isPublish = true)
    {
        $config = $config ? $config : str_replace('-', '_', $this->getPackage($rootPath));
        $configPath = $this->getConfigPath($rootPath) . $config . '.php';
        $packageConfig = require $configPath;

        $this->app['config']->set($config, array_replace_recursive($packageConfig, config($config, [])));
        if ($isPublish) {
            $this->publishes([
                $configPath => config_path($config . '.php')
            ]);
        }
    }

    /**
     * @param $rootPath
     * @param string $path
     * @param bool $isPublish
     */
    protected function loadViews($rootPath, $path = '', $isPublish = true)
    {
        $viewPath = $this->getViewPath($rootPath);
        $path = $path ? $path : $this->getPackage($rootPath);
        $this->loadViewsFrom($viewPath, $path);

        if ($isPublish) {
            $viewVendorPath = $this->getViewVendorPath($path);
            $this->publishes([
                $viewPath => $viewVendorPath,
            ]);
        }
    }

    /**
     * @param $rootPath
     * @param string $path
     */
    protected function loadRoutes ($rootPath, $path = 'routes.php')
    {
        $this->loadRoutesFrom($this->getRoutePath($rootPath, $path));
    }

    /**
     * @param $commands
     */
    protected function runningInConsole($commands)
    {
        if (!is_array($commands)) {
            $commands = [$commands];
        }

        if ($this->app->runningInConsole()) {
            $this->commands($commands);
        }

    }

    /**
     * @param $singletons
     * @throws \Exception
     */
    protected function registerSingletons($singletons)
    {
        if (!is_array($singletons)) {
            throw new \Exception('Alias parameter must me associative array [alias => instance]');
        }

        foreach ($singletons as $singleton => $class) {
            $this->registerSingleton($singleton, $class);
        }
    }

    /**
     * @param $singleton
     * @param $class
     */
    protected function registerSingleton($singleton, $class)
    {
        $this->app->singleton($singleton, function ($app) use ($class) {
            return app($class);
        });
    }

    /**
     * Register the Debugbar Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', $middleware);
    }

    /**
     * @param $aliases
     * @throws \Exception
     */
    protected function registerAliases($aliases)
    {
        if (!is_array($aliases)) {
            throw new \Exception('Alias parameter must me associative array [alias => instance]');
        }

        foreach ($aliases as $alias => $class) {
            $this->registerAlias($alias, $class);
        }
    }

    /**
     * @param $alias
     * @param $class
     */
    protected function registerAlias($alias, $class)
    {
        $aliases = config('app.aliases');
        $aliases[$alias] = $class;
        AliasLoader::getInstance($aliases)->register();
    }

    /**
     * @param $providers
     */
    protected function registerProviders($providers)
    {
        if (!is_array($providers)) {
            $providers = [$providers];
        }
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * @param $rootPath
     * @param string $path
     */
    protected function registerFunctions($rootPath, $path = 'helpers.php')
    {
        require_once($this->getSrcPath($rootPath) . $path);
    }

    /**
     * @param $rootPath
     * @param string $path
     */
    protected function registerConstants($rootPath, $path = 'constants.php')
    {
        require_once($this->getSrcPath($rootPath) . $path);
    }

    /**
     * @param $rootPath
     * @return string
     */
    protected function getConfigPath($rootPath)
    {
        return $this->getPackagePath($rootPath) . 'config' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $rootPath
     * @param string $view
     * @return string
     */
    protected function getViewPath($rootPath, $view = 'views')
    {
        return $this->getResourcePath($rootPath). $view;
    }

    /**
     * @param $path
     * @return string
     */
    protected function getViewVendorPath($path)
    {
        return resource_path('views' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * @param $rootPath
     * @return string
     */
    protected function getResourcePath($rootPath)
    {
        return $this->getPackagePath($rootPath) . 'resources' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $rootPath
     * @return mixed
     */
    protected function getPackage($rootPath)
    {
        $path = Str::replaceLast(DIRECTORY_SEPARATOR, '', $this->getPackagePath($rootPath));
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        return last($parts);
    }

    /**
     * @param $rootPath
     * @return bool|string
     */
    protected function getPackagePath($rootPath)
    {
        return Str::before($rootPath, 'src');
    }

    /**
     * @param $rootPath
     * @return string
     */
    protected function getSrcPath($rootPath)
    {
        return $this->getPackagePath($rootPath) . 'src' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $rootPath
     * @param string $path
     * @return string
     */
    protected function getRoutePath($rootPath, $path = 'routes.php')
    {
        return $this->getSrcPath($rootPath) . $path;
    }
}
