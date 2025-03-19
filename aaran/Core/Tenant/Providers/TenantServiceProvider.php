<?php

namespace Aaran\Core\Tenant\Providers;

use Aaran\Core\Tenant\Http\Middleware\TenantMiddleware;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('tenant', TenantMiddleware::class);
    }
}
