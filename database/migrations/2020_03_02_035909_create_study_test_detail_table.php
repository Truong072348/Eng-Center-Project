<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyTestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('study_test_detail')) {
            Schema::create('study_test_detail', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_study_test');
                $table->unsignedBigInteger('id_question');
                $table->boolean('sole');
                $table->string('answer')->nullable();
                $table->string('correctAnswer');
                $table->foreign('id_study_test')->references('id')->on('study_test');  
                // $table->foreign('id_ctype')->references('id')->on('category_type');  
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
        Schema::dropIfExists('study_test_detail');
    }
}
