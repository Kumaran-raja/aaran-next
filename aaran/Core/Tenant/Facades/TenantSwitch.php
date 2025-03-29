<?php

namespace Aaran\Core\Tenant\Facades;

use Illuminate\Support\Facades\Facade;
use Aaran\Core\Tenant\Services\TenantDatabaseService;

class TenantSwitch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TenantDatabaseService::class;
    }
}
