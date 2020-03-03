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
use Cloudder;

class QuestionController extends Controller
{
    
    function __construct() {

        $category = Category::all();
        $qtype = QuestionType::all();

        view()->share('category', $category);
        view()->share('qtype', $qtype);
    }


    public function getListBasic(Request $request){

        $idT = 1;

     	$question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/para');
     	$questionDetail = QuestionDetail::with(array('question'))->get();
      
        if($request->ajax()){

            $idT = $request->input('id');

            if($idT == 3){
                
                $basic = QuestionBasic::paginate(10)->setPath('admin/question/basic');
               
                return response(view('admin.question.list',[
                    'idT' => $idT,
                    'basic'=>$basic 
                ]));
            } elseif($idT == 2) {
                $question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/audio');
            
            } else {
                $question = Question::where('id_qtype','=', $idT)->paginate(5)->setPath('admin/question/para');
            }
        }

    	return view('admin.question.list',['question'=> $question, 'idT' => $idT,'questionDetail' => $questionDetail ]);
    }

    public function getAdd(){
        return view('admin/question/add');
    }


    public function postAdd(Request $request){
        
        $page = $request->type;

        $validator = \Validator::make($request->all(), [
            'ques1'=>'required|max:191',
            'cransewr1'=>'required|max: 191',
            'as1_1'=>'required|max: 191',
            'as1_2'=>'required|max: 191',
            'as1_3'=>'required|max: 191,'
        ],
        [
            'required'=>'Vui lòng nhập thông tin',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['page'=>$page, 'errors'=>$validator->errors()]);
        }

        if($request->type == 3){

            $question = new QuestionBasic;
            if(!empty($request->ques1)){
                 $question->createQuestion(
                    $request->ques1,$request->cransewr1, $request->as1_1, $request->as1_2,$request->as1_3, $request->category);
            } 

            if(!empty($request->ques2) && !empty($request->as2_1) && !empty($request->cransewr2) && !empty($request->s2_2) && !empty($request->as2_3)) {

                $question->createQuestion($request->ques2,$request->cransewr2, $request->as2_1, $request->as2_2,$request->as2_3, $request->category);
            }

            if(!empty($request->ques3) && !empty($request->as3_1) && !empty($request->cransewr3) && !empty($request->s3_2) && !empty($request->as3_3)) {

                $question->createQuestion($request->ques3,$request->cransewr3, $request->as3_1, $request->as3_2,$request->as3_3, $request->category);
            }
            
            if(!empty($request->ques4) && !empty($request->as4_1) && !empty($request->cransewr4) && !empty($request->s4_2) && !empty($request->as4_3)) {

               $question->createQuestion($request->ques4,$request->cransewr4, $request->as4_1, $request->as4_2,$request->as4_3, $request->category);
            }

        } else {

            if($request->type == 2) {
                if($request->hasFile('audio')){
                    $file = $request->file('audio');
                    $name = $file->getClientOriginalName();
 
                    $audioUpload = Cloudder::uploadVideo($file, 'english-Center/course-audio/'.str_random(5)."_".$name, ['resource_type' => 'video']);

                    $audio_url = Cloudder::secureShow(Cloudder::getPublicId(), ['resource_type' => 'video', 'format' => 'mp4']);
                    
                    $content = $audio_url;
                } 

            } else {
                $content = $request->content;
            }

            $question = Question::create([
                'id_qtype' => $request->type,
                'id_category' => $request->category,
                'content' => $content
            ]);

            $detail = new QuestionDetail;
            if(!empty($request->ques1)){
                 $detail->createDetailQuestion($request->ques1,$request->cransewr1, $request->as1_1, $request->as1_2,$request->as1_3, $question->id);
            }

            if(!empty($request->ques2) && !empty($request->as2_1) && !empty($request->cransewr2) && !empty($request->s2_2)) {
                $detail->createDetailQuestion($request->ques2,$request->cransewr2, $request->as2_1, $request->as2_2,$request->as2_3, $question->id);
            }

            if(!empty($request->ques3) && !empty($request->as3_1) && !empty($request->cransewr3) && !empty($request->s3_2)) {
              $detail->createDetailQuestion($request->ques3,$request->cransewr3, $request->as3_1, $request->as3_2,$request->as3_3, $question->id);
            }
            
            if(!empty($request->ques4) && !empty($request->as4_1) && !empty($request->cransewr4) && !empty($request->s4_2)) {
               $detail->createDetailQuestion($request->ques4,$request->cransewr4, $request->as4_1, $request->as4_2,$request->as4_3, $question->id);
            }
        }

        return redirect('admin/question/add')->with(['notify'=>'Successfully Added']);
    }

    // get view edit question
    public function getEdit($id){

        if(Question::where('id', $id)->exists()){
            $question = Question::find($id);
            $qDetail = QuestionDetail::where('id_question',$id)->get();
            return view('admin/question/edit', ['question'=>$question, 'qDetail'=>$qDetail]);

        } else {
            $question = QuestionBasic::find($id);
            return view('admin/question/edit', ['question'=>$question]);
        }
    }

    // Edit question

    public function postEdit(Request $request, $id){

        if ($request->type < 3){
            
            if(!empty($request->content)) {
                $question = Question::find($id);
                $question->content = $request->content;
                $question->save();
            }

            $detail = new QuestionDetail; 

            // return $request;
            if(!empty($request->ques1) && !empty($request->as1_1) && !empty($request->cransewr1) && !empty($request->as1_2) && !empty($request->as1_3)){
               $detail->editDetailQuestion($id, $request->detail1 ,$request->ques1, $request->cransewr1, $request->as1_1, $request->as1_2, $request->as1_3);
            }

            if(!empty($request->ques2) && !empty($request->as2_1) && !empty($request->cransewr2) && !empty($request->as2_2) && !empty($request->as2_3)) {
          
               $detail->editDetailQuestion($id, $request->detail2,$request->ques2, $request->cransewr2, $request->as2_1, $request->as2_2, $request->as2_3);
            }

            if(!empty($request->ques3) && !empty($request->as3_1) && !empty($request->cransewr3) && !empty($request->as3_2) && !empty($request->as3_3)) {
           
               $detail->editDetailQuestion($id, $request->detail3,$request->ques3, $request->cransewr3, $request->as3_1, $request->as3_2, $request->as3_3);
            }
            
            if(!empty($request->ques4) && !empty($request->as4_1) && !empty($request->cransewr4) && !empty($request->as4_2) && !empty($request->as4_3)) {
               
               $detail->editDetailQuestion($id, $request->detail4,$request->ques4, $request->cransewr4, $request->as4_1, $request->as4_2, $request->as4_3);
            }

        } else { 
            
            if(!empty($request->ques1) && !empty($request->as1_1) && !empty($request->cransewr1) && !empty($request->s1_2)){

                    $question = QuestionBasic::find($id);
                    $question->correct = $request->cransewr1;
                    $question->question = $request->ques1;
                    $question->answer1 = $request->as1_1;
                    $question->answer2 = $request->as1_2;
                    $question->answer3 = $request->as1_3;
                    $question->save();
            } 
        }

        return redirect('admin/question/edit/'.$id)->with(['notify'=>'Updated']);
        
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
