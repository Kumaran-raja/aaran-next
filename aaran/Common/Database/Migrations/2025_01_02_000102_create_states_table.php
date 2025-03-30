<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (Aaran\Core\Tenant\Services\FeatureManager::hasFeature('common')) {

            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('vname')->unique();
                $table->string('state_code')->unique()->nullable();
                $table->tinyInteger('active_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
