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
        if (Schema::hasTable('balances')) {
            Schema::dropIfExists('balances');
        }

        if (Schema::hasTable('balance_histories')) {
            Schema::dropIfExists('balance_histories');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('cash', 12, 2)->default(0);
            $table->decimal('bank', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('balance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');      // Owner of balance
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade'); // Who made the change
            $table->decimal('cash_before', 12, 2);
            $table->decimal('cash_after', 12, 2);
            $table->decimal('bank_before', 12, 2);
            $table->decimal('bank_after', 12, 2);
            $table->timestamps();
        });
    }
};
