<?php

namespace Aaran\Core\Tenant\Providers;

use Aaran\Core\Tenant\Http\Middleware\TenantMiddleware;
use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{

    protected string $moduleName = 'Tenant';
    protected string $moduleNameLower = 'tenant';

    public function register()
    {
        $this->app->singleton(TenantDatabaseService::class, function ($app) {
            return new TenantDatabaseService();
        });
    }

    public function boot()
    {
        $this->registerMiddleware();
        $this->registerMigrations();

//        $this->registerConfigs();
//        $this->registerRoutes();
//        $this->registerViews();
    }

    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // Register 'tenant' as a standalone middleware key
        $router->aliasMiddleware('tenant', TenantMiddleware::class);
    }


    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/tenant.php', 'tenant');
    }

    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
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


