<?php
// Create migration: php artisan make:migration create_user_activities_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('activity_type'); // login, logout, profile_update, password_change, etc.
            $table->string('description');
            $table->json('metadata')->nullable(); // Store additional data like IP, user agent, etc.
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('success'); // success, failed, pending
            $table->timestamp('created_at');
            $table->index(['user_id', 'created_at']);
            $table->index(['activity_type', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
};