<?php

namespace Aaran\Core\Tenant\Facades;

use Illuminate\Support\Facades\Facade;
use Aaran\Core\Tenant\Services\TenantManagerService;

class TenantManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TenantManagerService::class;
    }
}

