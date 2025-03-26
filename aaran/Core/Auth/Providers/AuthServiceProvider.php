<?php

namespace Aaran\Core\Auth\Providers;

use Aaran\Core\Auth\Livewire\Class\ConfirmPassword;
use Aaran\Core\Auth\Livewire\Class\ForgotPassword;
use Aaran\Core\Auth\Livewire\Class\Login;
use Aaran\Core\Auth\Livewire\Class\Register;
use Aaran\Core\Auth\Livewire\Class\ResetPassword;
use Aaran\Core\Auth\Livewire\Class\VerifyEmail;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AuthServiceProvider extends ServiceProvider
{

    protected string $moduleName = 'Auth';
    protected string $moduleNameLower = 'auth';

    public function register()
    {
//        $this->app->singleton(TenantService::class, function ($app) {
//            return new TenantService();
//        });
    }

    public function boot()
    {
//        $this->registerMiddleware();

//        $this->registerConfigs();
//        $this->registerRoutes();
//        $this->registerMigrations();
        $this->registerViews();
        $this->registerLivewireComponents();

    }


    private function registerLivewireComponents(): void
    {
        Livewire::component('auth::login', Login::class);
        Livewire::component('auth::register', Register::class);
        Livewire::component('auth::confirmPassword', ConfirmPassword::class);
        Livewire::component('auth::forgotPassword', ForgotPassword::class);
        Livewire::component('auth::resetPassword', ResetPassword::class);
        Livewire::component('auth::verifyEmail', VerifyEmail::class);
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


