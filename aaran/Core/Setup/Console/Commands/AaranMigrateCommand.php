<?php

namespace Aaran\Core\Setup\Console\Commands;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AaranMigrateCommand extends Command
{
    protected $signature = 'aaran:refresh {tenant}';
    protected $description = 'Refresh migrations for a specific tenant';

    public function handle()
    {
        $arg = $this->argument('tenant');

        $tenant = Tenant::where('t_name', $arg)->first();

        if (!$tenant) {
            $this->error("Tenant '{$arg}' not found.");
            return;
        }

        // List of migration directories
        $paths = [
            'aaran/Master/Contact/Database/Migrations',
        ];

        foreach ($paths as $row) {
            $path = realpath(base_path($row));

            if (!$path || !File::exists($path)) {
                $this->error("Migration folder not found: {$path}");
                continue;
            }

            $this->info("Running migration for tenant: {$tenant->name}");

            $this->migrate($path, $tenant);
        }
    }

    private function migrate($path, $tenant)
    {
        $migrationFiles = File::files($path);

        if (empty($migrationFiles)) {
            $this->warn("No migrations found in folder '{$path}'.");
            return;
        }

        $service = new TenantDatabaseService();
        $service->setTenantConnection($tenant);

        foreach ($migrationFiles as $file) {
            $migrationFile = str_replace(base_path(), '', $file->getRealPath());

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => $migrationFile,
                '--force' => true,
            ]);


        }

        $this->info(Artisan::output());
    }
}
