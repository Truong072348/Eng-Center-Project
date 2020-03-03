<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('question_detail')) {
            Schema::create('question_detail', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('question');
                $table->unsignedBigInteger('id_question');
                $table->foreign('id_question')->references('id')->on('question');
                $table->string('correct');
                $table->string('answer1');
                $table->string('answer2');
                $table->string('answer3');
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
        Schema::dropIfExists('question_detail');
    }
}
