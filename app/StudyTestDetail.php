<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyTestDetail extends Model
{
    protected $table = "study_test_detail";

    protected $fillable = ['id_study_test', 'id_question', 'sole', 'answer', 'correctAnswer'];

    public $timestamps = false;

    public function createSTDetail($id_study_test, $id_question, $sole, $answer, $correctAnswer) {

    	StudyTestDetail::create([
    		'id_study_test' => $id_study_test,
    		'id_question' => $id_question,
    		'sole' => $sole,
    		'answer' => $answer,
    		'correctAnswer' => $correctAnswer
    	]);
    }
}
