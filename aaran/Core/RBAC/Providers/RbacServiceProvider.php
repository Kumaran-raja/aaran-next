<?php

namespace Aaran\Core\RBAC\Providers;

use Aaran\Core\RBAC\Http\Middleware\AdminMiddleware;
use Aaran\Core\RBAC\Http\Middleware\RoleMiddleware;
use Aaran\Core\RBAC\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RbacServiceProvider extends ServiceProvider
{

    protected string $moduleName = 'Rbac';
    protected string $moduleNameLower = 'rbac';

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerMiddleware();
        $this->registerConfigs();
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerViews();
    }

    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // Apply Tenant Middleware to the "web" group
//        $router->pushMiddlewareToGroup('web', RoleMiddleware::class);

//        $router->pushMiddlewareToGroup('web', AdminMiddleware::class);
//
//        $router->pushMiddlewareToGroup('web', SuperAdminMiddleware::class);
    }


    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/rbac.php', 'rbac');
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


