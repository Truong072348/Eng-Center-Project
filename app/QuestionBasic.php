<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionBasic extends Model
{
    protected $table = "question_basic";

    protected $fillable = ['question', 'answer1', 'answer2', 'answer3', 'correct','id_category'];

    public $timestamps = false;

    public function category(){
    	return $this->belongsTo('App\category','id_category');
    }


    public function createQuestion($question, $correct, $answer1, $answer2, $answer3, $idcate){
    	
        QuestionBasic::create([
            'question' => $question,
            'correct' => $correct,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
            'id_category' => $idcate,

        ]);
    }
}
