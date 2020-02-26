<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('comment')) {
            Schema::create('comment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->mediumText('content');
                $table->integer('local');
                $table->unsignedBigInteger('id_user');
                $table->unsignedBigInteger('id_course');
                $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('comment');
    }
}
