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
            // Change reminder_frequency to support more options
            $table->dropColumn('reminder_frequency');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('reminder_frequency', [
                'daily', 
                'every_2_days', 
                'every_3_days', 
                'every_4_days', 
                'every_5_days', 
                'every_6_days', 
                'weekly', 
                'custom_weekdays',
                'random',
                'never'
            ])->default('daily')->after('wants_reminder');
            
            // Add fields for custom scheduling
            $table->json('custom_weekdays')->nullable()->after('reminder_frequency'); // [1,2,3,4,5] for Mon-Fri
            $table->integer('random_min_days')->default(1)->after('custom_weekdays'); // For random: min days between
            $table->integer('random_max_days')->default(3)->after('random_min_days'); // For random: max days between
            $table->date('last_reminder_sent')->nullable()->after('random_max_days'); // Track last sent for intervals
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'custom_weekdays',
                'random_min_days', 
                'random_max_days',
                'last_reminder_sent'
            ]);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('reminder_frequency');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('reminder_frequency', ['daily', 'weekly', 'never'])->default('daily')->after('wants_reminder');
        });
    }
};
