<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestDetail extends Model
{
    //
    protected $table = "test_detail";
    public $timestamps = false;


    public function Test(){
    	return $this->belongsTo('App\Test', 'id_test');
    }
}
