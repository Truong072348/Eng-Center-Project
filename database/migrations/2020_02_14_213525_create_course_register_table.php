<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course_register')) {
            Schema::create('course_register', function (Blueprint $table) {
                $table->float('price');
                $table->unsignedBigInteger('id_student');
                $table->unsignedBigInteger('id_course');
                $table->unsignedBigInteger('id_discount');
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
        Schema::dropIfExists('course_register');
    }
}
