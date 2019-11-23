<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = "student";
    public $timestamps = false;

    public function course(){
    	return $this->hasMany('App\Course','id_course','id');
    }
}
