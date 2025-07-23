<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBorrowHistoriesForeign extends Migration
{
    public function up()
    {
        Schema::table('borrow_histories', function (Blueprint $table) {
            $table->dropForeign(['borrow_id']);
            $table->foreign('borrow_id')->references('id')->on('borrows')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('borrow_histories', function (Blueprint $table) {
            $table->dropForeign(['borrow_id']);
            $table->foreign('borrow_id')->references('id')->on('borrows');
        });
    }
}
