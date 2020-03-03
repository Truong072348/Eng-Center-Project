<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('test_detail')) {
            Schema::create('test_detail', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_test');
                $table->unsignedBigInteger('id_question');
                $table->foreign('id_test')->references('id')->on('test');
                // $table->foreign('id_question')->references('id')->on('question');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_detail');
    }
}
