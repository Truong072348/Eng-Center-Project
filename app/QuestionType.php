<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    //
    protected $table = "question_type";


    public function question (){
    	return $this->hasMany('App\Question','id_qtype','id');
    }
}
