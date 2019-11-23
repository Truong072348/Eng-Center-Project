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

class TestController extends Controller
{
	public function getList(Request $request){
		$testDetail = TestDetail::all();
        $category = Category::all();
        $studyTest = StudyTest::all();
        $courseTest = CourseTest::all();

        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $test = Test::where('name', 'like', "%$keyword%")->Paginate(15);     
            return view('admin/test/list', ['test'=>$test, 'detail'=>$testDetail, 'category'=>$category, 'studyTest'=>$studyTest, 'courseTest'=>$courseTest]);
        }

        $test = Test::Paginate(5);
        

        if($request->ajax()){
            $record = $request->input('_record');

            $test = Test::paginate($record);
        
            return response(view('admin/test/list', ['test'=>$test,'category'=>$category,'detail'=>$testDetail, 'studyTest'=>$studyTest, 'courseTest'=>$courseTest]));
        }

        return view('admin/test/list', ['test'=>$test, 'detail'=>$testDetail, 'category'=>$category, 'studyTest'=>$studyTest, 'courseTest'=>$courseTest]);
	}

    public function searchTest(Request $request){
        $keyword = $request->search;
        return redirect()->route('listTest', ['keyword'=>$keyword]);
    }

    public function deleteTestList($id){
        $testDetail = TestDetail::all();
        $category = Category::all();

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

	public function getAdd(Request $request){
		$qtype = QuestionType::all();
		$category = Category::all();


		$idT = 1;
     	$question = Question::where('id_qtype','=', $idT)->paginate(3);

     	$questionDetail = QuestionDetail::with(array('question'))->get();
        $category = Category::all();
    	$qtype = QuestionType::all();

        if($request->ajax()){

            $idT = $request->input('id');

            if($idT == 3){
                
                $basic = QuestionBasic::paginate(3);
               
                return response(view('admin/test/add',[
                    'qtype'=>$qtype,
                    'idT' => $idT,
                    'category'=>$category,
                    'basic'=>$basic 
                ]));
            }

            if($idT == 1){
                $question = Question::where('id_qtype','=', $idT)->paginate(3);
            }

            if($idT == 2){
                $question = Question::where('id_qtype','=', $idT)->paginate(3);
            }
            
            $questionDetail = QuestionDetail::with(array('question'))->get();

            return response(view('admin.test.add',[
                'question'=> $question,
                'qtype'=>$qtype,
                'idT' => $idT,
                'questionDetail' => $questionDetail,
                'category'=>$category 
            ]));

        }

        $name = $request->input('name');
        

		return view('admin/test/add', ['qtype'=>$qtype, 'category'=>$category,'idT' => $idT,
                'questionDetail' => $questionDetail,'question'=>$question, 'name'=>$name]);

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

            $list = $request->list;
            if($list == 0){
                return redirect('admin/test/add')->with('error','Error Added. The number of questions too little');
            }

            $test = new Test;
            $test->id = mt_rand(100000,999999);

            while (Test::where('id', $test->id)->exists()) {
                 $test->id = mt_rand(100000,999999);
            }

            $idTest = $test->id;

            $test->name = $request->name;
            $test->time = $request->time;
            $test->id_category = $request->category;
            $test->save();

            $listQs = $request->Input('question');
            foreach ($listQs as $listQ) {
                $detailTest = new TestDetail;
                $detailTest->id_test =  $idTest;
                $detailTest->id_question = $listQ;
                $detailTest->save();

            }
          
		return redirect('admin/test/add')->with('notify','Successfully Added');
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


    public function getEdit($id_T, Request $request){
        $idT = 0;
        $qtype = QuestionType::all();
        $category = Category::all();
        
        $question = Question::where('id_qtype','=', $id_T)->paginate(10);
        $questionDetail = QuestionDetail::with(array('question'))->get();
        $qtype = QuestionType::all();
        
        $test = Test::find($id_T);
        

         if($request->ajax()){

            $idT = $request->input('idQ');

            if($idT == 3){
                
                $basic = QuestionBasic::paginate(10);
               
                return response(view('admin/test/add',[
                    'qtype'=>$qtype,
                    'idT' => $idT,
                    'category'=>$category,
                    'basic'=>$basic 
                ]));
            }

            if($idT == 1){
                $question = Question::where('id_qtype','=', $idT)->paginate(10);
            }

            if($idT == 2){
                $question = Question::where('id_qtype','=', $idT)->paginate(10);
            }
            
            $questionDetail = QuestionDetail::with(array('question'))->get();

            return response(view('admin.test.add',[
                'question'=> $question,
                'qtype'=>$qtype,
                'idT' => $idT,
                'questionDetail' => $questionDetail,
                'category'=>$category 
            ]));

        } 
        $question = Question::where('id_qtype','=', $idT)->paginate(10);
        if(TestDetail::where('id_test', $id_T)->exists()){
        $detail = TestDetail::where('id_test', $test->id)->get();

        foreach ($detail as $d) {
            if(Question::where('id', $d->id_question)->exists()){
                $array[] = Question::where('id', $d->id_question)->get();
            } else {
                 $array[] = QuestionBasic::where('id', $d->id_question)->get();
            }
        }

        $questionDetail = QuestionDetail::all();

        // return $questionDetail;
        return view('admin/test/edit', ['test'=>$test,'detail'=>$detail,'qtype'=>$qtype, 'category'=>$category, 'arrayQ'=>$array, 'questionDetail'=>$questionDetail, 'idT' => $idT, 'question'=> $question]);
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

            $list = $request->list;
            $test =  Test::find($id);

            $test->name = $request->name;
            $test->time = $request->time;
            $test->id_category = $request->category;
            $test->save();

            $listQs = $request->Input('question');

            if($listQs == null || $list == 0){
                return redirect('admin/test/edit/'.$id)->with('error','Error Edited. The number of questions too little');
           }

           foreach ($listQs as $listQ) {
                if(TestDetail::where('id_question', $listQ)->where('id_test', $id)->exists()){  
                
                } else {
                    $detailTest = new TestDetail;
                    $detailTest->id_test =  $id;
                    $detailTest->id_question = $listQ;
                    $detailTest->save();
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
}

