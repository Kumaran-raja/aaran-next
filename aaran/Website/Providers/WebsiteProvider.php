<?php

namespace Aaran\Website\Providers;

use Illuminate\Support\ServiceProvider;

class WebsiteProvider extends ServiceProvider
{
    protected string $moduleName = 'Website';
    protected string $moduleNameLower = 'website';

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerConfigs();
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerViews();
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/website.php',  $this->moduleNameLower);
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
