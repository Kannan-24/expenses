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
        Schema::create('emi_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('emi_loan_id')->constrained('emi_loans')->onDelete('cascade');
            $table->date('due_date'); // When this EMI should be paid
            $table->decimal('principal_amount', 12, 2)->nullable();
            $table->decimal('interest_amount', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2); // principal + interest
            $table->enum('status', ['upcoming', 'paid', 'missed', 'late'])->default('upcoming');
            $table->date('paid_date')->nullable(); // When the EMI was actually paid
            $table->decimal('paid_amount', 12, 2)->nullable(); // Amount paid for this EMI
            $table->text('notes')->nullable();

            // Linking to existing transactions table (optional if tracked)
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('set null');

            // Wallet used for this specific payment (nullable to allow user selection)
            $table->foreignId('wallet_id')->nullable()->constrained('wallets')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_schedules');
    }
};
