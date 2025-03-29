<?php

namespace Aaran\Core\Setup\Console\Commands;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AaranMigrateCommand extends Command
{
    protected $signature = 'aaran:migrate {tenant} {--fresh} {--refresh} {--seed} {--force}';
    protected $description = 'Refresh migrations for a specific tenant';

    public function handle()
    {
        $arg = $this->argument('tenant');
        $seed = $this->option('seed');


        // Choose the correct migration command
        $migrationCommand = 'migrate';
        if ($this->option('fresh')) {
            $migrationCommand = 'migrate:fresh';
        } elseif ($this->option('refresh')) {
            $migrationCommand = 'migrate:refresh';
        }

        $tenant = Tenant::where('t_name', $arg)->first();

        if (!$tenant) {
            $this->error("Tenant '{$arg}' not found.");
            return;
        }

        // List of migration directories
        $paths = [
            'aaran/Common/Database/Migrations',
            'aaran/Master/Contact/Database/Migrations',
        ];

        foreach ($paths as $row) {
            $path = realpath(base_path($row));

            if (!$path || !File::exists($path)) {
                $this->error("Migration folder not found: {$path}");
                continue;
            }

            $this->info("Running migration for tenant: {$tenant->name}");

            $this->migrate($path, $tenant, $migrationCommand);
        }

        // Run seeders if requested
        if ($this->option('seed')) {
            $this->seed($tenant);
        }


    }

    private function migrate($path, $tenant, $migrationCommand)
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

            Artisan::call($migrationCommand, [
                '--database' => 'tenant',
                '--path' => $migrationFile,
                '--force' => true,
            ]);


        }

        $this->info(Artisan::output());
    }

    private function seed($tenant)
    {
        $service = new TenantDatabaseService();
        $service->setTenantConnection($tenant);

        Artisan::call('db:seed', [
            '--database' => 'tenant',
            '--class' => 'Aaran\Core\Setup\TenantDatabaseSeeder',
            '--force' => $this->option('force'),
        ]);

        $this->info(Artisan::output());
    }


}
