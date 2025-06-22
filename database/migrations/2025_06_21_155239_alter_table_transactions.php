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
        Schema::table('transactions', function (Blueprint $table) {
            // Drop 'payment_method' column if it exists
            if (Schema::hasColumn('transaction', 'payment_method')) {
                $table->dropColumn('payment_method');
            }

            // Add 'wallet_id' column
            $table->unsignedBigInteger('wallet_id')->nullable()->after('category_id');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop 'wallet_id' column if it exists
            if (Schema::hasColumn('transaction', 'wallet_id')) {
                $table->dropForeign(['wallet_id']);
                $table->dropColumn('wallet_id');
            }

            // Add 'payment_method' column back
            $table->enum('payment_method', ['cash', 'bank'])->after('category_id')->default('cash');
        });
    }
};
