<?php

namespace Aaran\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

class AaranServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerModules();
    }

    public function boot()
    {
        $this->bootModules();
    }

    protected function registerModules()
    {
        $modules = glob(base_path('aaran/*/*'), GLOB_ONLYDIR);

        foreach ($modules as $module) {
            $namespace = "Aaran\\" . str_replace('/', '\\', substr($module, 6)) . "\\Providers\\ModuleServiceProvider";
            $providerPath = $module . '/Providers/ModuleServiceProvider.php';

            if (file_exists($providerPath) && class_exists($namespace)) {
                $this->app->register($namespace);
            }
        }
    }


    protected function bootModules()
    {
        foreach (glob(base_path('Aaran/Modules/*/routes/*.php')) as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }
}
