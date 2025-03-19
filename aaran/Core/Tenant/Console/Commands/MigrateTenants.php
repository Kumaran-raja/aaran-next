<?php

namespace Aaran\Core\Tenant\Console\Commands;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateTenants extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Run migrations for all tenants';

    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            TenantManager::setTenant($tenant);
            Artisan::call('migrate', ['--database' => 'tenant', '--path' => 'database/migrations/tenant']);
        }

        $this->info('All tenant migrations completed!');
    }
}

