<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $table = "course";
    public $timestamps = false;

    public function comment(){
    	return $this->hasMany('App\Comment','id_course','id');
    }

    public function student(){
    	return $this->hasManyThrough('App\Register','App\Student','id_course','id_student','id');
    }

    public function teacher(){
        return $this->belongsTo('App\Teacher');
    } 

    public function test(){
    	return $this->hasMany('App\CourseTest','id_course','id');
    }

    public function Lesson(){
    	return $this->hasMany('App\Lesson','id_course','id');
    }

    public function type(){
    	return $this->belongsTo('App\CategoryType','id_ctype');
    }
    
}
