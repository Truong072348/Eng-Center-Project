<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course')) {
            Schema::create('course', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->float('price');
                $table->date('date_start');
                $table->date('date_finish');
                $table->mediumText('short_description')->nullable();
                $table->mediumText('description')->nullable();
                $table->string('image')->nullable();
                $table->string('status');
                $table->string('slug');
                $table->unsignedBigInteger('id_ctype');
                $table->unsignedBigInteger('id_teacher');
                $table->foreign('id_ctype')->references('id')->on('category_type');
                $table->foreign('id_teacher')->references('id')->on('teacher');
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
        Schema::dropIfExists('course');
    }
}
