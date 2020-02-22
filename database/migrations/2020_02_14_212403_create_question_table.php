<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('question')) {
            Schema::create('question', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->mediumText('content');
                $table->unsignedBigInteger('id_qtype');
                $table->unsignedBigInteger('id_category');
                $table->foreign('id_qtype')->references('id')->on('question_type');
                $table->foreign('id_category')->references('id')->on('category');
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
        Schema::dropIfExists('question');
    }
}
