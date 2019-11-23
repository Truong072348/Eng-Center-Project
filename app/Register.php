<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //
    protected $table = "course_register";

    public function course(){
    	return $this->belongsTo('App\Course','id_course','id');
    }

    public function student(){
    	return $this->belongsTo('App\Student','id_student','id');
    }
}
