<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('mfa_enabled')->default(false);
            $table->string('mfa_method')->nullable(); // 'email' or 'authenticator_app'
            $table->string('mfa_secret')->nullable(); // Used for authenticator app
            $table->text('mfa_backup_codes')->nullable(); // Stores encrypted JSON array
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mfa_enabled', 'mfa_method', 'mfa_secret']);
        });
    }
};
