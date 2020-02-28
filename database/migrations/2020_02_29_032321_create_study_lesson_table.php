<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('study_lesson')) {
            Schema::create('study_lesson', function (Blueprint $table) {
                $table->unsignedBigInteger('id_lesson');
                $table->unsignedBigInteger('id_users');
                $table->unsignedBigInteger('id_course');
                $table->foreign('id_users')->references('id')->on('users');
                $table->foreign('id_lesson')->references('id')->on('course_lesson');
                $table->foreign('id_course')->references('id')->on('course');
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
        Schema::dropIfExists('study_lesson');
    }
}
