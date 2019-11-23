<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionBasic extends Model
{
    protected $table = "question_basic";
    public $timestamps = false;

    public function category(){
    	return $this->belongsTo('App\category','id_category');
    }


    public function createQuestion($qs, $cr, $a1, $a2, $a3, $idcate){
    	$question = new QuestionBasic;
    	$question->question = $qs;
    	$question->correctAnswer = $cr;
    	$question->answer1 = $a1;
    	$question->answer2 = $a2;
    	$question->answer3 = $a3;
    	$question->id_category = $idcate;
    	$question->id_qtype = 3;
    	$question->save();

    }
}
