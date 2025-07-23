<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('person_id')->constrained('expense_people');
            $table->decimal('amount', 12, 2);
            $table->decimal('returned_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'partial', 'returned'])->default('pending');
            $table->enum('borrow_type', ['borrowed', 'lent']);
            $table->foreignId('wallet_id')->constrained();
            $table->date('date');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrows');
    }
}
