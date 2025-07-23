<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('borrow_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained();
            $table->foreignId('wallet_id')->constrained();
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrow_histories');
    }
}
