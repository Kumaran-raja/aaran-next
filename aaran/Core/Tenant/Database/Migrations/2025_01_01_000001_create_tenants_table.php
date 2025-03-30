<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('b_name'); // business name
            $table->string('t_name')->unique(); // tenant name
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            // Database Details
            $table->string('db_name')->unique();
            $table->string('db_host')->default('127.0.0.1');
            $table->string('db_port')->default('3306');
            $table->string('db_user');
            $table->string('db_pass');
            // Subscription & Limits
            $table->string('plan')->default('free');
            $table->date('subscription_start')->nullable();
            $table->date('subscription_end')->nullable();
            $table->decimal('storage_limit', 13, 2)->default(10);
            $table->integer('user_limit')->default(5);
            $table->boolean('is_active')->default(true);
            // Multi-Tenant Features
            $table->string('industry_code')->nullable();
            $table->json('settings')->nullable();
            $table->json('enabled_features')->nullable();
            // Security
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('api_key')->nullable();
            $table->string('whitelisted_ips')->nullable();
            $table->boolean('allow_sso')->default(false);
            // Performance & Usage
            $table->integer('active_users')->default(0);
            $table->integer('requests_count')->default(0);
            $table->decimal('disk_usage', 10, 2)->default(0);
            // Lifecycle
            $table->timestamp('last_active_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
