<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Test;
use App\Question;
use App\QuestionType;
use App\QuestionDetail;
use App\Category;
use App\QuestionBasic;
use App\TestDetail;
use App\StudyTest;
use App\CourseTest;
use App\Course;

class TestController extends Controller
{
	   
    function __construct() {

        $testDetail = TestDetail::all();
        $category = Category::all();
        $studyTest = StudyTest::all();
        $courseTest = CourseTest::all();
        $qtype = QuestionType::all();
 

        view()->share('detail', $testDetail);
        view()->share('category', $category);
        view()->share('categories', $category);
        view()->share('studyTest', $studyTest);
        view()->share('courseTest', $courseTest);
        view()->share('qtype', $qtype);

    }


    public function getList(Request $request){
		
        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $test = Test::where('name', 'like', "%$keyword%")->Paginate(15); 

        } elseif($request->ajax()){
            $record = $request->input('_record');
            $test = Test::paginate($record);
        
        } else {
            $test = Test::Paginate(10);
        }

        return view('admin/test/list', ['test'=>$test]);
	}

    public function getAdd(Request $request){

        $idT = 1;
        $question = Question::where('id_qtype','=', $idT)->paginate(3);
        $questionDetail = QuestionDetail::with(array('question'))->get();
     
        if($request->ajax()){

            $idT = $request->input('id');
            if($idT == 3){
                
                $basic = QuestionBasic::paginate(3);
               
                return response(view('admin/test/add',['idT' => $idT,'basic'=>$basic]));

            } elseif($idT == 2){
                $question = Question::where('id_qtype','=', $idT)->paginate(3);
            
            } else{
                $question = Question::where('id_qtype','=', $idT)->paginate(3);
            }

        }

        $name = $request->input('name');
        
        return view('admin/test/add', ['idT' => $idT, 'questionDetail' => $questionDetail,'question'=>$question, 'name'=>$name]);

    }

    public function postAdd(Request $request){
          $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'time'=>'required'
            ], 
            [   
                'name.required'=>'Vui lòng nhập thông tin',
                'name.min'=>'Tên quá ngắn',
                'name.max'=>'Tên quá dài',
                'time.required'=>'Vui lòng nhập thông tin'
              
            ]);

            $listQs = $request->Input('question');

            if(empty($listQs)){
                return redirect('admin/test/add')->with('error','Error Added. The number of questions too little');
            }

            $id = mt_rand(100000,999999);

            while (Test::where('id', $id)->exists()) {
                 $id = mt_rand(100000,999999);
            }


            $test = Test::create([
                'time' => $request->time,
                'name' => $request->name,
                'id_category' => $request->category,
                'id' => $id

            ]);

            foreach ($listQs as $idquestion) {
                TestDetail::create([
                    'id_test' => $test->id,
                    'id_question' => $idquestion,
                ]);
            }
          
        return redirect('admin/test/add')->with('notify','Successfully Added');
    }

    public function getEdit($id, Request $request){
        
        $idT = 0;
        $question = Question::where('id_qtype','=', $id)->paginate(10);
        $questionDetail = QuestionDetail::with(array('question'))->get();
        
        $test = Test::find($id);
        

        if($request->ajax()){

            $idT = $request->input('idQ');

            if($idT == 3){
                
                $basic = QuestionBasic::paginate(10);
               
                return response(view('admin/test/add',['idT' => $idT, 'basic'=>$basic]));

            } else{

                $question = Question::where('id_qtype','=', $idT)->paginate(10);
            }

            return response(view('admin.test.add', ['question'=> $question,'idT' => $idT,'questionDetail' => $questionDetail]));

        } 

        if(TestDetail::where('id_test', $id)->exists()){
            $detail = TestDetail::where('id_test', $test->id)->get();

            foreach ($detail as $d) {
                if(Question::where('id', $d->id_question)->exists()){
                    $array[] = Question::where('id', $d->id_question)->get();
                } else {
                     $array[] = QuestionBasic::where('id', $d->id_question)->get();
                }
            }

        $questionDetail = QuestionDetail::all();

        return view('admin/test/edit', ['test'=>$test,'detail'=>$detail, 'arrayQ'=>$array, 'questionDetail'=>$questionDetail, 'idT' => $idT, 'question'=> $question]);
        }
    }

    public function postEdit(Request $request, $id){
         $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'time'=>'required'
                        
            ], 
            [   
                'name.required'=>'Vui lòng nhập thông tin',
                'name.min'=>'Tên quá ngắn',
                'name.max'=>'Tên quá dài',
                'time.required'=>'Vui lòng nhập thông tin'     
            ]);

            $listQs = $request->Input('question');
            if(empty($listQs)){
                return redirect('admin/test/add')->with('error','Error Added. The number of questions too little');
            }

            $test =  Test::find($id);
            $input_test['name'] = $request->name;
            $input_test['time'] = $request->time;
            $input_test['id_category'] = $request->category;

            $test->fill($input_test)->save();

            $listQs = $request->Input('question');

           foreach ($listQs as $listQ) {
                if(!TestDetail::where('id_question', $listQ)->where('id_test', $id)->exists()){  
                    TestDetail::create([
                        'id_test' => $id,
                        'id_question' => $listQ
                    ]);
                }
            }

            $questionList = TestDetail::where('id_test', $id)->get();
            
            foreach($questionList as $question){
                if(in_array($question->id_question, $listQs)){

                } else {
                    $questionRemove = TestDetail::where('id_question', $question->id_question)->where('id_test', $id)->first();
                    $questionRemove->delete();
                }
            }

            return redirect('admin/test/edit/'.$id)->with('notify', 'Successfully Edited');
    }


    public function deleteTestList($id){

        $test = Test::paginate(5);

        $testDelete = Test::find($id);

        if(StudyTest::where('id_test', $id)->exists() || CourseTest::where('id_test', $id)->exists()){
            return redirect('admin/test/list')->with(['deleteTestFail'=>true]);
        }

        $listTestDetail = TestDetail::where('id_test', $id)->get();
        foreach ($listTestDetail as $value) {
            $value->delete();
        }

        $testDelete->delete();
        return redirect('admin/test/list')->with(['deleteTestSuccess'=>true]);
    }


	public function getPagePara(Request $request){
        $page = $request->page;

        $question = Question::where('id_qtype','=', 1)->paginate(3, ['*'], 'page', $page);

        $questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.test.add',[
            'question'=> $question,
            'qtype'=>$qtype,
            'idT' => 1,
            'questionDetail' => $questionDetail,
            'category'=>$category 
        ]);
    }

    public function getPageAudio(Request $request){
        $page = $request->page;

        $question = Question::where('id_qtype','=', 2)->paginate(3, ['*'], 'page', $page);

        $questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.tes.add',[
            'question'=> $question,
            'qtype'=>$qtype,
            'idT' => 2,
            'questionDetail' => $questionDetail,
            'category'=>$category 
        ]);
    }

    public function getPageBasic(Request $request){
        $page = $request->page;

        $basic =  QuestionBasic::paginate(3, ['*'], 'page', $page);
        $category = Category::all();
        $qtype = QuestionType::all();

        return view('admin.test.add',[
            'qtype'=>$qtype,
            'idT' => 3,
            'category'=>$category,
            'basic'=>$basic 
        ]);
    }


    public function getAddTestToCourse($id, Request $request){

        $course = Course::find($id);
        $testList = Test::paginate(5);
        $test = CourseTest::where('id_course', $course->id)->paginate(10);

         if($request->ajax()){
            $record = $request->input('_record');
            $testList = Test::paginate($record);
        }

        return view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test]);
    }



    public function postAddTestToCourse($id, Request $request){
        $this->validate($request, 
        [
            'name'=>'required|max: 191|string',
            'idtest'=>'required'
        ], 
        [   
            'name.required'=>'Vui lòng nhập tên bài kiểm tra',
            'idtest.required'=>'Vui lòng chọn bài kiểm tra'
        ]);

        if(CourseTest::where('id_course', $request->idcourse)->where('id_test', $request->idtest)->exists()) {
            return redirect('admin/course/test/'.$id)->with('notify', 'Bai kiem tra da co san');
        } else {
            CourseTest::create([
                'name' => $request->name,
                'id_course' => $request->idcourse,
                'id_test' => $request->idtest

            ]);

            return redirect('admin/course/test/'.$id)->with('notify', 'Them thanh cong');
        }
        
    }


    public function deleteTest($id){
        $courseTest = CourseTest::find($id);
        $course = Course::where('id', $courseTest->id_course)->first();
        if(StudyTest::where('id_test', $courseTest->id)->exists()){
    
            return redirect('admin/course/test/'.$course->id)->with('deleteLessonTestFail', true);
        } else {

            $courseTest->delete();
        }

        return redirect('admin/course/test/'.$course->id)->with('notify', 'Successfully Deleted');
    }


}

