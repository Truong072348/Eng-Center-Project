<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('discount')) {
            Schema::create('discount', function (Blueprint $table) {
                $table->string('code');
                $table->integer('reduce');
                $table->integer('quantity');
                $table->date('date_start');
                $table->date('date_finish');
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
        Schema::dropIfExists('discount');
    }
}
