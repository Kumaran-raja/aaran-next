<?php

namespace Aaran\UI\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class UiServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Ui';
    protected string $moduleNameLower = 'ui';

    public function register()
    {
        $this->app->register(UiRouteServiceProvider::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources', 'Ui'); // Important: Load views from module

        // Register a default layout globally
        View::share('layout', 'Ui::layout.web');
        View::share('layout', 'Ui::layout.app');


//        $this->registerConfigs();
//        $this->registerMigrations();
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/dashboard.php',  $this->moduleNameLower);
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerViews(): void
    {
        // Register a default layout globally
        View::share('layout', 'Aaran::web');
        View::share('layout', 'Aaran::app');

        $this->loadViewsFrom(__DIR__ . '/../Layouts', 'Aaran');

        $this->loadViewsFrom(__DIR__ . '/../Components', $this->moduleNameLower);

        $this->loadViewsFrom(__DIR__ . '/../Livewire', $this->moduleNameLower);
        $this->loadViewsFrom(__DIR__ . '/../Pages', $this->moduleNameLower);


    }

}
