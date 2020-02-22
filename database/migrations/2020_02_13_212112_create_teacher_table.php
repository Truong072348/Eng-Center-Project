<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('teacher')) {
            Schema::create('teacher', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('phone');
                $table->string('address')->nullable();
                $table->date('birth');
                $table->string('gender');
                $table->string('avatar')->nullable();
                $table->mediumText('slogan')->nullable();
                $table->string('degree');
                $table->mediumText('introduction')->nullable();

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
        Schema::dropIfExists('teacher');
    }
}
