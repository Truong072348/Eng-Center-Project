<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionDetail extends Model
{
    protected $table = "question_detail";
    public $timestamps = false;

    public function question(){
    	return $this->belongsTo('App\Question','id_question');
    }

    public function createDetailQuestion($qs, $tas, $as1, $as2, $as3, $idq){
    	
    	$table = new QuestionDetail;

        $table->question = $qs;
        $table->correctAnswer = $tas;
        $table->answer1 = $as1;
        $table->answer2 = $as2;
        $table->answer3 = $as3;
        $table->id_question = $idq;

        $table->save();
    }

    public function editDetailQuestion($idq,$id, $ques, $cr, $as1, $as2, $as3){
        if(QuestionDetail::where('id', $id)->exists()){
            $detail = QuestionDetail::find($id);
        }else {
            $detail = new QuestionDetail;
        } 

        $detail->id_question = $idq;
        $detail->question = $ques;
        $detail->correctAnswer = $cr;
        $detail->answer1 = $as1;
        $detail->answer2 = $as2;
        $detail->answer3 = $as3;
        $detail->save();   
    }

}
