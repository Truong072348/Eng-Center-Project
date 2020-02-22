<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('answer');
                $table->integer('local');
                $table->unsignedBigInteger('id_comment');
                $table->unsignedBigInteger('id_users');
                $table->foreign('id_users')->references('id')->on('users');
                $table->foreign('id_comment')->references('id')->on('comment');
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
        Schema::dropIfExists('feedback');
    }
}
