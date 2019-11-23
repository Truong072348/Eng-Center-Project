<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Question;
use App\QuestionType;
use App\QuestionDetail;
use App\Category;
use App\QuestionBasic;

class QuestionController extends Controller
{
     public function getListBasic(Request $request){

        $idT = 1;
     	$question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/para');

     	$questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
    	$qtype = QuestionType::all();

        if($request->ajax()){

            $idT = $request->input('id');

            if($idT == 3){
                
                $basic = QuestionBasic::paginate(10)->setPath('admin/question/basic');
               
                return response(view('admin.question.list',[
                    'qtype'=>$qtype,
                    'idT' => $idT,
                    'category'=>$category,
                    'basic'=>$basic 
                ]));
            }

            if($idT == 1){
                $question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/para');
            }

            if($idT == 2){
                $question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/audio');
            }
            
            $questionDetail = QuestionDetail::with(array('question'))->get();

            return response(view('admin.question.list',[
                'question'=> $question,
                'qtype'=>$qtype,
                'idT' => $idT,
                'questionDetail' => $questionDetail,
                'category'=>$category 
            ]));
        }

    	return view('admin.question.list',[
    		'question'=> $question,
    		'qtype'=>$qtype,
    		'idT' => $idT,
    		'questionDetail' => $questionDetail,
            'category'=>$category 
    	]);
    }

    public function getAdd(){
        $qtype = QuestionType::all();
        $category = Category::all();
        return view('admin/question/add', ['type'=>$qtype,'category'=>$category]);
    }


    public function postAdd(Request $request){
        $this->validate($request,
            [
                'ques1'=>'required',
                'cransewr1'=>'required',
                'as1_1'=>'required',
                'as1_2'=>'required',
                'as1_3'=>'required'
            ],
            [
               
                'required'=>'Vui lòng nhập thông tin'
            ]);

            if($request->type == 3){
                $question = new QuestionBasic;

                if($request->ques1 != ''){
                     $question->createQuestion($request->ques1,$request->cransewr1, $request->as1_1, $request->as1_2,$request->as1_3, $request->category);
                } else {
                    return redirect('admin/question/add')->with(['error'=>'Error Added']);
                }

                if($request->ques2 != '') {
                    $question->createQuestion($request->ques2,$request->cransewr2, $request->as2_1, $request->as2_2,$request->as2_3, $request->category);
                }

                if($request->ques3 != '') {
                    $question->createQuestion($request->ques3,$request->cransewr3, $request->as3_1, $request->as3_2,$request->as3_3, $request->category);
                }
                
                if($request->ques4 != '') {
                   $question->createQuestion($request->ques4,$request->cransewr4, $request->as4_1, $request->as4_2,$request->as4_3, $request->category);
                }

            } else {

                $question = new Question;
                $question->id =  mt_rand(10000,99999);
                $idf = $question->id;

                while (Question::where('id', $question->id)->exists()) {
                     $question->id = mt_rand(10000,99999);
                }

                if($request->type == 2) {
                    if($request->hasFile('audio')){
                        $file = $request->file('audio');
                        $name = $file->getClientOriginalName();
                        
                        $audio = str_random(5)."_".$name;
                        while (file_exists("upload/audio/".$audio)) {
                            $audio = str_random(5)."_".$audio;
                        }

                        $file->move("upload/audio", $audio);
                        $question->content = $audio;
                    } 

                } else {
                    $question->content = $request->content;
                }

                $question->id_qtype = $request->type;
                $question->id_category = $request->category;

                $question->save();
                $detail = new QuestionDetail;
                if($request->ques1 != ''){
                     $detail->createDetailQuestion($request->ques1,$request->cransewr1, $request->as1_1, $request->as1_2,$request->as1_3, $idf);
                }

                if($request->ques2 != '') {
                 $detail->createDetailQuestion($request->ques2,$request->cransewr2, $request->as2_1, $request->as2_2,$request->as2_3, $idf);
                }

                if($request->ques3 != '') {
                  $detail->createDetailQuestion($request->ques3,$request->cransewr3, $request->as3_1, $request->as3_2,$request->as3_3, $idf);
                }
                
                if($request->ques4 != '') {
                   $detail->createDetailQuestion($request->ques4,$request->cransewr4, $request->as4_1, $request->as4_2,$request->as4_3, $idf);
                }
            }


        return redirect('admin/question/add')->with(['notify'=>'Successfully Added']);
    }

    // get view edit question
    public function getEdit($id){

        $question = Question::find($id);
        $qType = QuestionType::all();
        $category = Category::all();

        if($question == null){
            $question = QuestionBasic::find($id);
            
            return view('admin/question/edit', ['question'=>$question, 'type'=>$qType,'category'=>$category]);
        }

        $qDetail = QuestionDetail::where('id_question',$id)->get();

        return view('admin/question/edit', ['question'=>$question, 'qDetail'=>$qDetail, 'type'=>$qType,'category'=>$category]);
    }

    // Edit question

    public function postEdit(Request $request, $id){

         $this->validate($request,
            [
                      
            ],
            [
                
            ]);


        if ($request->type == 1 || $request->type == 2){
            $question = Question::find($id);
            $question->content = $request->content;
            $question->save();

            if($request->ques1 != ''){
               $detail = new QuestionDetail; 
               $detail->editDetailQuestion($id, $request->detail1,$request->ques1, $request->cransewr1, $request->as1_1, $request->as1_2, $request->as1_3);
            }

            if($request->ques2 != '') {
                $detail = new QuestionDetail; 
               $detail->editDetailQuestion($id, $request->detail2,$request->ques2, $request->cransewr2, $request->as2_1, $request->as2_2, $request->as2_3);
            }

            if($request->ques3 != '') {
               $detail = new QuestionDetail; 
               $detail->editDetailQuestion($id, $request->detail3,$request->ques3, $request->cransewr3, $request->as3_1, $request->as3_2, $request->as3_3);
            }
            
            if($request->ques4 != '') {
               $detail = new QuestionDetail; 
               $detail->editDetailQuestion($id, $request->detail4,$request->ques4, $request->cransewr4, $request->as4_1, $request->as4_2, $request->as4_3);
            }

            if($request->ques1 == '' && $request->ques2 == '' && $request->ques3 == '' && $request->ques4 == ''){
                 return redirect('admin/question/edit/'.$id)->with(['error'=>'Error Updated']);
            }

        } 
        
        if($request->type == 3) {
            echo $id;

            if($request->ques1 != '' && $request->cransewr1 != '' && $request->as1_1 != '' && $request->as1_2 != '' && $request->as1_3 != ''){
                $question = QuestionBasic::find($id);
                $question->correctAnswer = $request->cransewr1;
                $question->question = $request->ques1;
                $question->answer1 = $request->as1_1;
                $question->answer2 = $request->as1_2;
                $question->answer3 = $request->as1_3;
                $question->save();


            } else {
                return redirect('admin/question/edit/'.$id)->with(['error'=>'Error Updated']);
            }
        }

        return redirect('admin/question/edit/'.$id)->with(['notify'=>'Successfully Updated']);
        
    }



    //pagination

    public function getPagePara(Request $request){
        $page = $request->page;

        $question = Question::where('id_qtype','=', 1)->paginate(5, ['*'], 'page', $page);

        $questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.question.list',[
            'question'=> $question,
            'qtype'=>$qtype,
            'idT' => 1,
            'questionDetail' => $questionDetail,
            'category'=>$category 
        ]);
    }

    public function getPageAudio(Request $request){
        $page = $request->page;

        $question = Question::where('id_qtype','=', 2)->paginate(5, ['*'], 'page', $page);

        $questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.question.list',[
            'question'=> $question,
            'qtype'=>$qtype,
            'idT' => 2,
            'questionDetail' => $questionDetail,
            'category'=>$category 
        ]);
    }


    public function getPageBasic(Request $request){
        $page = $request->page;

        $basic =  QuestionBasic::paginate(10, ['*'], 'page', $page);
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.question.list',[
            'qtype'=>$qtype,
            'idT' => 3,
            'category'=>$category,
            'basic'=>$basic 
        ]);
    }
}
