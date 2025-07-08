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
        Schema::create('report_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('report_type'); // e.g., transactions, budgets, tickets
            $table->string('report_format'); // e.g., pdf, html, csv, xlsx
            $table->string('date_range'); // e.g., all, today, yesterday, this_week, last_week, this_month, last_month, custom
            $table->date('start_date')->nullable(); // For custom date ranges
            $table->date('end_date')->nullable(); // For custom date ranges
            $table->json('filters')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_histories');
    }
};
