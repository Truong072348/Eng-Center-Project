<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = "question";
    
    protected $fillable = ['id', 'content', 'id_qtype', 'id_category'];

    public $timestamps = false;


    public function questionType(){
    	return $this->belongsTo('App\QuestionType','id_qtype','id');
    }

    public function questionDetail(){
    	return $this->hasMany('App\QuestionDetail','id_question','id');
    }
}
