<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('question_basic')) {
            Schema::create('question_basic', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('question');
                $table->string('correct');
                $table->string('answer1');
                $table->string('answer2');
                $table->string('answer3');
                $table->unsignedBigInteger('id_category');
                $table->foreign('id_category')->references('id')->on('category');
                // $table->foreign('id_qtype')->references('id')->on('question_type');
                // $table->timestamps();
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
        Schema::dropIfExists('question_basic');
    }
}
