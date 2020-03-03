<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('study_test')) {
            Schema::create('study_test', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->float('score');
                $table->time('time');
                $table->unsignedBigInteger('id_users');
                $table->unsignedBigInteger('id_course');
                $table->unsignedBigInteger('id_test');
                $table->foreign('id_test')->references('id')->on('test');
                $table->foreign('id_course')->references('id')->on('course');
                $table->foreign('id_users')->references('id')->on('users');
                $table->timestamps();
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
        Schema::dropIfExists('study_test');
    }
}
