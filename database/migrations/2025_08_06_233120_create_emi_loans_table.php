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
        Schema::create('emi_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('interest_rate', 5, 2)->default(0.00); // annual interest
            $table->date('start_date');
            $table->integer('tenure_months');
            $table->decimal('monthly_emi', 12, 2)->nullable();
            $table->boolean('is_auto_deduct')->default(false);
            $table->enum('loan_type', ['fixed', 'reducing_balance'])->default('fixed');
            $table->enum('status', ['active', 'closed', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_loans');
    }
};
