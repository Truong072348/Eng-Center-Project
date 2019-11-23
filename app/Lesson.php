<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $table = "course_lesson";
    public $timestamps = false;
    
    public function course(){
    	return $this->belongsTo('App\Course','id_course','id');
    }
}
