<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('reminder_frequency', ['daily', 'weekly', 'never'])->default('daily')->after('wants_reminder');
            $table->time('reminder_time')->default('20:30:00')->after('reminder_frequency');
            $table->string('timezone')->default('UTC')->after('reminder_time');
            $table->boolean('email_reminders')->default(true)->after('timezone');
            $table->boolean('push_reminders')->default(true)->after('email_reminders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_frequency',
                'reminder_time',
                'timezone',
                'email_reminders',
                'push_reminders'
            ]);
        });
    }
};
