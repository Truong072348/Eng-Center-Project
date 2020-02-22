<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('category_type')) {
            Schema::create('category_type', function (Blueprint $table) {
                $table->bigIncrements('id');
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
        Schema::dropIfExists('category_type');
    }
}
