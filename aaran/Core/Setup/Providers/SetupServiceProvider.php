<?php

namespace Aaran\Core\Setup\Providers;

use Aaran\Core\Setup\Console\Commands\AaranMigrateRefresh;
use Aaran\Core\Setup\Console\Commands\SetupAaranCommand;
use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            SetupAaranCommand::class,
        ]);

        $this->commands([
            AaranMigrateRefresh::class,
        ]);

    }
}
