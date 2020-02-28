<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyLesson extends Model
{
    protected $table = "study_lesson";

    protected $primaryKey = ['id_users', 'id_lesson', 'id_course'];

    protected $fillable = ['id_users', 'id_lesson', 'id_course'];

    public $timestamps = true;

    public function register(){
    	return $this->belongsTo('App\Register','id_study');
    }

    public function lesson(){
    	return $this->belongsTo('App\Lesson','id_lesson');
    }

}
