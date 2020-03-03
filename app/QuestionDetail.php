<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionDetail extends Model
{
    protected $table = "question_detail";

    protected $fillable = ['id', 'id_question', 'correct', 'answer1', 'answer2', 'answer3', 'question'];

    public $timestamps = false;

    public function question(){
    	return $this->belongsTo('App\Question','id_question');
    }

    public function createDetailQuestion($question, $correct, $answer1, $answer2, $answer3, $idquest){
    	
    	QuestionDetail::create([
            'question' => $question,
            'correct' => $correct,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
            'id_question' => $idquest
        ]);
    }

    public function editDetailQuestion($idquest, $id, $question, $correct, $answer1, $answer2, $answer3){
        
        if(QuestionDetail::where('id', $id)->exists()){
            $detail = QuestionDetail::find($id);
        } else {
            $detail = new QuestionDetail;
        }

        $detail->id_question = $idquest;
        $detail->question = $question;
        $detail->correct = $correct;
        $detail->answer1 = $answer1;
        $detail->answer2 = $answer2;
        $detail->answer3 = $answer3;
        $detail->save();   
    }

}
