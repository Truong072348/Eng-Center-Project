<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('test')) {
            Schema::create('test', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->float('time');
                $table->unsignedBigInteger('id_category');
                $table->foreign('id_category')->references('id')->on('category');
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
        Schema::dropIfExists('test');
    }
}
