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
            $table->boolean('wants_reminder')->default(true)->after('email_verified_at');
            $table->timestamp('last_login_at')->nullable()->after('wants_reminder');

            $table->integer('streak_days')->default(0);
            $table->date('last_transaction_date')->nullable();
            $table->date('streak_start_date')->nullable();
            $table->integer('longest_streak')->default(0);
            $table->decimal('monthly_savings_goal', 10, 2)->default(1000.00);
            $table->decimal('current_month_savings', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('wants_reminder');
            $table->dropColumn('last_login_at');

            $table->dropColumn('streak_days');
            $table->dropColumn('last_transaction_date');
            $table->dropColumn('streak_start_date');
            $table->dropColumn('longest_streak');
            $table->dropColumn('monthly_savings_goal');
            $table->dropColumn('current_month_savings');
        });
    }
};
