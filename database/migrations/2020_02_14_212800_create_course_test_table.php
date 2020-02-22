<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course_test')) {
            Schema::create('course_test', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->unsignedBigInteger('id_test');
                $table->unsignedBigInteger('id_course');
                $table->foreign('id_test')->references('id')->on('test');
                $table->foreign('id_course')->references('id')->on('course');
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
        Schema::dropIfExists('course_test');
    }
}
