<?php

namespace Aaran\Core\Sys\Providers;

use Aaran\Core\Setup\Providers\SetupServiceProvider;
use Aaran\Core\Tenant\Providers\TenantServiceProvider;
use Aaran\Core\User\Providers\AuthServiceProvider;
use Aaran\Dashboard\Providers\DashboardProvider;
use Aaran\Website\Providers\WebsiteProvider;
use Illuminate\Support\ServiceProvider;

class AaranServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SetupServiceProvider::class);

        $this->app->register(WebsiteProvider::class);

        $this->app->register(DashboardProvider::class);

        $this->app->register(AuthServiceProvider::class);

        $this->app->register(TenantServiceProvider::class);
    }

    public function boot()
    {
        //
    }
}
