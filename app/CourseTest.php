<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTest extends Model
{
    //
    protected $table = "course_test";

    protected $fillable = ['name', 'id_course', 'id_test'];

    public $timestamps = false;

    public function test(){
    	return $this->hasMany('App\Test','id_test','id');
    }

    public function course(){
    	return $this->belongsTo('App\Course','id_course','id');
    }
}
