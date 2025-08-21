<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('two_factor_secret', 128)->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->json('two_factor_recovery_codes')->nullable();
            $table->string('last_login_ip', 64)->nullable();
            $table->text('last_login_user_agent')->nullable();
        });

        Schema::create('trusted_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('device_key', 64)->unique();
            $table->string('device_name')->nullable();
            $table->string('ip', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trusted_devices');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['two_factor_secret','two_factor_enabled','two_factor_recovery_codes','last_login_ip','last_login_user_agent']);
        });
    }
};
