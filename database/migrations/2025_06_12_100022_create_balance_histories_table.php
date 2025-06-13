<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::dropIfExists('balance_histories');
    }
};
