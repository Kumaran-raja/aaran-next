<?php

namespace Aaran\Core\Setup\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AaranSetupCommand extends command
{

    protected $signature = 'aaran:migrate:refresh {--seed}';
    protected $description = 'Refresh migrations including core and industry-specific ones in a predefined order';
}
