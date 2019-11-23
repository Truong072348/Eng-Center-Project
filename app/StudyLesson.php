<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyLesson extends Model
{
    protected $table = "study_lesson";
    public $timestamps = false;

    public function register(){
    	return $this->belongsTo('App\Register','id_study');
    }

    public function lesson(){
    	return $this->belongsTo('App\Lesson','id_lesson');
    }

}
