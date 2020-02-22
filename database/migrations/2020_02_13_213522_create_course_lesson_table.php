<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course_lesson')) {
            Schema::create('course_lesson', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('lesson');
                $table->string('links_svideo');
                $table->string('links_document');
                $table->unsignedBigInteger('id_course');
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
        Schema::dropIfExists('course_lesson');
    }
}
