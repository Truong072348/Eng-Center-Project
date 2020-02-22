<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('student')) {
            Schema::create('student', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('phone');
                $table->string('address')->nullable();
                $table->date('birthday');
                $table->string('gender');
                $table->string('avatar')->nullable();
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
        Schema::dropIfExists('student');
    }
}
