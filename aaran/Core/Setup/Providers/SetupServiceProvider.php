<?php

namespace Aaran\Core\Setup\Providers;

use Aaran\Core\Setup\Console\Commands\AaranMigrateCommand;
use Aaran\Core\Setup\Console\Commands\AaranSetupCommand;
use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            AaranSetupCommand::class,
            AaranMigrateCommand::class,
        ]);
    }

    public function boot()
    {

    }
}
