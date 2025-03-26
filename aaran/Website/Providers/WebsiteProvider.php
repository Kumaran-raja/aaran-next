<?php

namespace Aaran\Website\Providers;

use Aaran\Website\Http\Middleware\WebsiteMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class WebsiteProvider extends ServiceProvider
{
    protected string $moduleName = 'Website';
    protected string $moduleNameLower = 'website';

    public function register()
    {
        $this->app->register(WebsiteRouteServiceProvider::class);
    }

    public function boot()
    {
        $this->registerMiddleware();

//        $this->registerConfigs();
        $this->registerRoutes();
//        $this->registerMigrations();
        $this->registerViews();

    }


    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // Register 'tenant' as a standalone middleware key
        $router->aliasMiddleware('website', WebsiteMiddleware::class);
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/website.php', $this->moduleNameLower);
    }

    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
//        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

}
