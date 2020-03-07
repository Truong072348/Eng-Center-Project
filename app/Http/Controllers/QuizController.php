<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Course;
use App\CourseTest;
use App\Register;
use App\Test;
use App\TestDetail;
use App\QuestionBasic;
use App\Question;
use App\QuestionDetail;
use App\StudyTest;
use App\StudyTestDetail;
use App\Teacher;
use App\Student;
use App\Lesson;
use App\Category;
use App\CategoryType;

class QuizController extends Controller
{
    function __construct() {
    	$teacherList = Teacher::all();
    	$studentList = Student::all();
    	$testList = Test::all();
    	$lessonList = Lesson::all();
        $categoryList = Category::all();
        $typeCList = CategoryType::all();
        $courseTotal = Course::all();

    	view()->share('teacherList', $teacherList);
    	view()->share('studentList', $studentList);
    	view()->share('testList', $testList);
    	view()->share('lessonList', $lessonList);
        view()->share('categoryList', $categoryList);
        view()->share('typeCList', $typeCList);
        view()->share('courseTotal', $courseTotal);
        \Carbon\Carbon::setLocale('vi');

    	return $this->middleware('auth');
    }


    //Hien thi bai kiem tra
    function getTest($id, Request $request){

        $courseTest = CourseTest::find($id);
        $testById = Test::where('id', $courseTest->id_test)->first();
        $testDetail = TestDetail::where('id_test', $testById->id)->get();

        $questionBasic = array();
        $questionAudio = array();
        $questionPara = array();
        $detailPara = array();
        $detailAudio = array();
        $detailBasic = array();


        foreach ($testDetail as $test) {
            if(Question::where('id', $test->id_question)->where('id_qtype', 2)->exists()) {
                array_push($questionAudio, $test);

            } elseif (Question::where('id', $test->id_question)->where('id_qtype', 1)->exists()) {
                array_push($questionPara, $test);
            } else {
                array_push($questionBasic, $test);
            } 
        }

        if($request->ajax()){
            $type = $request->input('_type');

            if($type == 2) {
                foreach($questionPara as $para) {
                    $content = Question::where('id', $para->id_question)->first();
                    $para->setAttribute('content', $content);
                    array_push($detailPara, QuestionDetail::where('id_question', $para->id_question)->get());
                }

            } else {
                 foreach ($questionAudio as $audio) {
                    $content = Question::where('id', $audio->id_question)->first();
                    $audio->setAttribute('content', $content);
                    array_push($detailAudio, QuestionDetail::where('id_question', $audio->id_question)->get());
                }
            }
        
        } else {
            if(!empty($questionBasic)) {
                $type = 1;
                foreach ($questionBasic as $basic) {
                    array_push($detailBasic, QuestionBasic::where('id', $basic->id_question)->first());
                }

            } elseif (!empty($questionPara)) {
                $type = 2;
                foreach($questionPara as $para) {
                    $content = Question::where('id', $para->id_question)->first();
                    $para->setAttribute('content', $content);
                    array_push($detailPara, QuestionDetail::where('id_question', $para->id_question)->get());
                }
            }  elseif (!empty($questionAudio)){
                $type = 3;
                foreach ($questionAudio as $audio) {
                    $content = Question::where('id', $audio->id_question)->first();
                    $audio->setAttribute('content', $content);
                    array_push($detailAudio, QuestionDetail::where('id_question', $audio->id_question)->get());
                }
            } else {
                return view('pages.listnone');
            }
        }

        return view('pages.test', ['courseTest'=>$courseTest, 'test'=>$testById,'questionBasic'=>$questionBasic, 'questionPara'=>$questionPara, 'detailPara'=>$detailPara, 'detailBasic'=>$detailBasic,'questionAudio'=>$questionAudio, 'detailAudio'=>$detailAudio, 'type'=>$type]);
   
    }


    //Xem lai thong tin so cau dung sai bai kiem tra
    function getReview($id, Request $request){
        
        $courseTest = CourseTest::find($id);   
        $courseAndTest = Test::where('course_test.id', '=', $id)->join('course_test','course_test.id_test','=', 'test.id')->join('course', 'course.id', '=', 'course_test.id_course')->first();
        
        $testDetail = TestDetail::where('id_test', $courseAndTest->id_test)->get();

        $questionBasic = array();
        $questionAudio = array();
        $questionPara = array();
        $detailPara = array();
        $detailAudio = array();
        $detailBasic = array();

        foreach ($testDetail as $test) {
            if(Question::where('id', $test->id_question)->where('id_qtype', 2)->exists()) {
                array_push($questionAudio, $test);

            } elseif (Question::where('id', $test->id_question)->where('id_qtype', 1)->exists()) {
                array_push($questionPara, $test);
            } else {
                array_push($questionBasic, $test);
            } 
        }
         if($request->ajax()){
            $type = $request->input('_type');

            if($type == 2) {
                foreach($questionPara as $para) {
                    $content = Question::where('id', $para->id_question)->first();
                    $para->setAttribute('content', $content);
                    array_push($detailPara, QuestionDetail::where('id_question', $para->id_question)->get());
                }
                
            } else {
                 foreach ($questionAudio as $audio) {
                    $content = Question::where('id', $audio->id_question)->first();
                    $audio->setAttribute('content', $content);
                    array_push($detailAudio, QuestionDetail::where('id_question', $audio->id_question)->get());
                }
            }
        
        } else {
            if(!empty($questionBasic)) {
                $type = 1;
                foreach ($questionBasic as $basic) {
                    array_push($detailBasic, QuestionBasic::where('id', $basic->id_question)->first());
                }

            } elseif (!empty($questionPara)) {
                $type = 2;
                foreach($questionPara as $para) {
                    $content = Question::where('id', $para->id_question)->first();
                    $para->setAttribute('content', $content);
                    array_push($detailPara, QuestionDetail::where('id_question', $para->id_question)->get());

                }

            } elseif(!empty($questionAudio)) {
                $type = 3;
                 foreach ($questionAudio as $audio) {
                    $content = Question::where('id', $audio->id_question)->first();
                    $audio->setAttribute('content', $content);
                    array_push($detailAudio, QuestionDetail::where('id_question', $audio->id_question)->get());
                }

            } else {
                return view('pages.listnone');
            }
        }
        

        //get test list result
        $tested = false;
        $register = Register::where('id_student', Auth::user()->id)->where('id_course', $courseAndTest->id_course)->first();
        $studyTest = StudyTest::where('id_test', $courseAndTest->id_test)->first();
        $studyTestDetail = StudyTestDetail::where('id_study_test', $studyTest->id)->get();
        //get answer list
        
        $testDetail = TestDetail::where('id_test', $courseAndTest->id_test)->get();
        
       
        return view('pages.review', ['courseTest'=>$courseTest,'questionBasic'=>$questionBasic, 'questionPara'=>$questionPara, 'detailPara'=>$detailPara, 'questionAudio'=>$questionAudio, 'detailAudio'=>$detailAudio,'detailBasic'=>$detailBasic, 'type'=>$type, 'studyTestDetail'=>$studyTestDetail, 'result'=>$studyTest]);
    }

    //Xem lai diem so bai kiem tra
    function getOverview ($id){
        if(CourseTest::where('id_test', $id)->exists()) {
            
            $test = CourseTest::where('id_test', $id)->first();
            $testDetail = Test::find($test->id_test);
            $listquestion = TestDetail::where('id_test', $testDetail->id)->where('id_question', '<', 10000)->get();
            $listquestionBasic = TestDetail::where('id_test', $testDetail->id)->where('id_question', '>', 10000)->get();
            $course = Course::find($test->id_course);
            $info = Test::where('id', $test->id_test)->first();

            $register = Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->first();
            $tested = false;
            $studyTest = StudyTest::where('id_test', $id)->where('id_users', Auth::id())->first();
            if(!empty($studyTest)){
                $tested = true;
            }

            return view('pages.overview', ['test'=>$test, 'course'=>$course, 'listQuestion'=>$listquestion, 'info'=>$info, 'tested'=>$tested, 'result'=>$studyTest, 'listquestionBasic'=>$listquestionBasic]);
        } else {
            return view('pages.listnone');
        }
    }


    //Nop bai
    function postQuiz(Request $request, $id){
        $courseTest = CourseTest::find($id);
        $register = Register::where('id_student', Auth::user()->id)->where('id_course', $courseTest->id_course)->first();
        
        // Lay danh sach khoa hoc va bai kiem tra join course va test
        $courseAndTest = Test::where('course_test.id', '=', $id)->join('course_test','course_test.id_test','=', 'test.id')->join('course', 'course.id', '=', 'course_test.id_course')->first();
     
        $testDetail = TestDetail::where('id_test', $courseAndTest->id_test)->get();        
   
        // Lay danh sach dap an tu tb question
        foreach($testDetail as $test) {
            if($test->id_question > 10000) 
            {
                $arrayQuiz[] = array('answer'=>QuestionBasic::select('correct')->where('id', $test->id_question)->first(),'id'=>$test->id_question, 'type'=>'basic');
            } else{
                $array = QuestionDetail::select('id')->where('id_question', $test->id_question)->distinct('id')->get();
                foreach($array as $a)
                {
                    $arrayQuiz[] = array('answer'=>QuestionDetail::select('correct')->where('id', $a->id)->first(), 'id'=>$a->id, 'type'=>'content');
                }
            }
        }

        $scoreBasic = 0;
        $scorePara = 0;
        $totalScore = 0;

        if($request->ajax()){

            $scorePara = 0;

            $arrAnswer = $request->Input('_arrAnswer');
            $type = $request->Input('_type');
            $time = $request->Input('_time');
            
            // Tinh diem so cau dung
            if(!empty($arrAnswer)) {
            
                foreach($arrayQuiz as $quiz) {    
                    foreach ($arrAnswer as $answer) {
                        if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correct']){
                            $scorePara = $scorePara + 1;
                        }
                    }      
                }
            }

            // Luu thong tinh vao bang studyTest
            // Kiem tra bai test da duoc luu truoc do
            if(StudyTest::where('id_users', Auth::id())->where('id_course', $courseAndTest->id_course)->where('id_test', $courseAndTest->id_test)->exists()) {
                
            	$studyTest = StudyTest::where('id_users', Auth::id())->where('id_test', $courseAndTest->id_test)->first();
                $score = $studyTest->score + $scorePara;
                $studyTest->update(['time' => $time, 'score' => $score]);
              

            } else {
            	$studyTest = StudyTest::create([
                    'score' => $scorePara,
                    'id_test' => $courseAndTest->id_test,
                    'time' => $time,
                    'id_course' => $courseAndTest->id_course,
                    'id_users' => Auth::id()
                ]);

                
            }
            
            //Luu thong tin dap an vao StudyTestDetail
            foreach ($arrAnswer as $answer) {
                $sole = $request->basic == 1 ? 1 : 0;
                $stDetail = new StudyTestDetail;
                foreach($arrayQuiz as $quiz) {
                    if($answer['id'] == $quiz['id']){ 
                        $correct = $quiz['answer']['correct']; 
                        
                        $stDetail->createSTDetail($studyTest->id, $quiz['id'], $sole ,$answer['answer'], $correct);
                        break;
                    } 

                }
            }
        
        }else {  

            $question = $request->Input('question');
            $type = $request->type;
            $time = $request->time;

            foreach($question as $ques){
                $arrAnswer[] = array('answer'=>$request->Input('answer'.$ques.''), 'id'=>$ques); 
            }

            foreach($arrayQuiz as $quiz) {
                if(!empty($quiz)) {

                    foreach ($arrAnswer as $answer) {
                 
                        if($type == 2) {
                              if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correct'] && $quiz['type'] == 'basic'){
                                $scorePara = $scorePara + 1;
                            }
                        } else { 
                            if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correct'] && $quiz['type'] == 'content'){
                                $scorePara = $scorePara + 1;
                            }
                        }
                    }
                }
            }

            if(StudyTest::where('id_users', Auth::id())->where('id_course', $courseAndTest->id_course)->where('id_test', $courseAndTest->id_test)->exists()) {
            	$studyTest = StudyTest::where('id_users', Auth::id())->where('id_test', $courseAndTest->id_test)->first();
                $score = $studyTest->score + $scorePara;
                $studyTest->update(['time' => $time, 'score' => $score]);
                

            } else {
            	 $studyTest = StudyTest::create([
	                'score' => $scorePara,
	                'id_test' => $courseAndTest->id_test,
	                'time' => $request->time,
	                'id_course' => $courseAndTest->id_course,
	                'id_users' => Auth::id()
	            ]);
            }

            foreach ($arrAnswer as $answer) {
            	
               $sole = $request->basic == 1 ? 1 : 0;
               $stDetail = new StudyTestDetail;
               foreach($arrayQuiz as $quiz) {
                    if($answer['id'] == $quiz['id']){ 
                        $correct = $quiz['answer']['correct']; 
           
                        $stDetail->createSTDetail($studyTest->id, $quiz['id'], $sole ,$answer['answer'], $correct);
                        break;
                    } 
                }
            	
            }
        }
        return redirect()->route('overview', ['id' => $courseAndTest->id_test]);  
    }
}
