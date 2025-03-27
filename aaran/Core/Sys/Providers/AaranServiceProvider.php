<?php

namespace Aaran\Core\Sys\Providers;

use Aaran\Assets\Providers\AssetsServiceProvider;
use Aaran\Common\Providers\CommonServiceProvider;
use Aaran\Core\Auth\Providers\AuthServiceProvider;
use Aaran\Core\RBAC\Providers\RbacServiceProvider;
use Aaran\Core\Setup\Providers\SetupServiceProvider;
use Aaran\Core\Tenant\Providers\TenantServiceProvider;
use Aaran\Core\User\Providers\UserServiceProvider;
use Aaran\Dashboard\Providers\DashboardProvider;
use Aaran\UI\Providers\UiServiceProvider;
use Aaran\Website\Providers\WebsiteProvider;
use Illuminate\Support\ServiceProvider;

class AaranServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AssetsServiceProvider::class);

        $this->app->register(UiServiceProvider::class);

        $this->app->register(SetupServiceProvider::class);

        $this->app->register(WebsiteProvider::class);

        $this->app->register(DashboardProvider::class);

        $this->app->register(AuthServiceProvider::class);

        $this->app->register(TenantServiceProvider::class);

        $this->app->register(UserServiceProvider::class);

        $this->app->register(RbacServiceProvider::class);

        $this->app->register(CommonServiceProvider::class);
    }

    public function boot()
    {
        //
    }
}
