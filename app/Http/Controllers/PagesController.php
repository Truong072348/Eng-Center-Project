<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\updateProfileRequest;
use App\Category;
use App\CategoryType;
use App\Course;
use App\CourseTest;
use App\Teacher;
use App\Student;
use App\Test;
use App\Lesson;
use App\User;
use App\Feedback;
use App\Comment;
use App\Discount;
use App\Register;
use App\StudyLesson;
use App\TestDetail;
use App\QuestionBasic;
use App\Question;
use App\QuestionDetail;
use App\StudyTest;
use App\StudyTestDetail;
use Carbon\Carbon;

use Hash;
use Cloudder;
use Validator;

class PagesController extends Controller
{
    function __construct(){
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
    }

    function getIndex(){
  		$courseList = Course::where('status', '=', 'opening')->paginate(6);
        if(count($courseList) > 0) {
            foreach ($courseList as $key) {
                $course = Course::find($key->id);
                $img = Cloudder::show('english-Center/course-image/'.$course->image); 
                $key->setAttribute('img', $img);
            }
        } 

    	return view('pages.index', ['courseList'=>$courseList]);
    }


    function postSearch(Request $request){
        $keyword = $request->search;
        
        return redirect()->route('list', ['keyword'=>$keyword]);
    }

    function getIntro($course){

        $courseIntro = Course::where('slug', $course)->first();
        $id = $courseIntro->id;
        // return json_encode($courseIntro->slug);
        $teacherCourse = Teacher::where('id', $courseIntro->id_teacher)->first();
        $lessonCourse = Lesson::where('id_course', $courseIntro->id)->get();
        $video = Lesson::where('id_course', $courseIntro->id)->first();
        $courseReference = Course::where('id_ctype', $courseIntro->id_ctype)->where('status', '=', 'opening')->orderBy('id', 'DESC')->paginate(5);
        $test = CourseTest::where('id_course', $courseIntro->id)->get();

        if(Count($courseReference) <= 1){
            $type = CategoryType::where('id', $courseIntro->id_ctype)->first();
            $courseCate = Category::with(array('course'=>function($q){
                $q->where('status', '=', 'opening');
            }))->orderBy('id', 'DESC')->paginate(5);

            $courseReference = $courseCate[2]['course'];
        }

        foreach ($courseReference as $key) {
            $img = Cloudder::show('english-Center/course-image/'.$key->image);
            $key->setAttribute('image', $img);    
        }

        $comment = Comment::where('id_course', $id)->where('local', 0)->orderBy('created_at', 'DESC')->paginate(5);
        
        $now = Carbon::now();

        if(!empty($comment)) {
           
            foreach ($comment as $key) {

                if(User::where('id', $key->id_user)->exists()){
                    $user = User::find($key->id_user);

                    if($user->id_utype == 3) {
                        $student = Student::find($user->id);

                        $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
                        $key->setAttribute('img', $img);
                    } else {
                        $teacher = Teacher::find($$user->id);
                        $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
                        $key->setAttribute('img', $img);
                    }
                } 
              
                $date = $key->created_at;
                $time = $date->diffForHumans($now);

                $key->setAttribute('time', $time);
                
            }
        }


        $feedback = Feedback::where('local', 0)->get();

        if(count($feedback) > 0) {

            foreach ($feedback as $f) {
                $type = User::where('id', $f->id_users)->first();
               
                if( $type->id_utype == 3) {
                    $student = Student::find($type->id);
                    $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
                    $f->setAttribute('img', $img);
                } else {
                    $teacher = Teacher::find($type->id);
                    $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
                    $f->setAttribute('img', $img);
                } 

                $date = $f->created_at;
                $time = $date->diffForHumans($now);

                $f->setAttribute('time', $time);      
            }
        }

        $register = false;

        if(Auth::check()){
            if(Register::where('id_student', Auth::user()->id)->where('id_course', $id)->exists()){
                $register = true;
            }
        }

       
        // return $courseReference;
        return view('pages.intro', ['intro'=>$courseIntro, 'teacher'=>$teacherCourse, 'lessons'=>$lessonCourse, 'video'=>$video, 'refs'=>$courseReference, 'tests'=>$test, 'comments'=>$comment, 'feedback'=>$feedback,'registered'=>$register]);
    }

    function getDesc($id){
        $lesson = Lesson::find($id);
        $course = Course::where('id', $lesson->id_course)->first();

        $lessonList = Lesson::where('id_course', $course->id)->get();
        $teacher = Teacher::where('id', $course->id_teacher)->first();
        $test = CourseTest::where('id_course', $course->id)->get();
        $comment = Comment::where('id_course', $course->id)->where('local', 1)->orderBy('created_at', 'DESC')->paginate(10);
        $feedback = Feedback::where('local', 1)->orderBy('created_at', 'DESC') ->get();
        $register = false;
        $studyTest = '';
        if(Auth::check()){
            if(Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->exists()){
                $register = true;
                $re = Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->first();
                $studyTest = StudyTest::where('id_register', $re->id)->get();

            }
        }

        $watched = StudyLesson::where('id_user', Auth::user()->id)->get();


        return view('pages.desc', ['lesson'=>$lesson, 'course'=>$course, 'teacher'=>$teacher, 'lessonList'=>$lessonList, 'test'=>$test, 'comments'=>$comment, 'feedback'=>$feedback, 'registered'=>$register, 'watched'=>$watched, 'studyTest'=>$studyTest]);
    }

    function fileDownload($filename){
        $file_path = "upload/document/".$filename;

        if (file_exists($file_path))
        {

            return Response::download($file_path, $filename, [
                'Content-Length: '. filesize($file_path)
            ]);
        }
        else
        {
            exit('File is not vaild');
        }
    }


    function getAdminIndex(){

        if(Auth::user()->id_utype == 2) {
            $account = Teacher::find(Auth::id());
            $img = Cloudder::show('english-Center/avatar/'.$account->avatar);
            // $account->setAttribute('img', $img);

            return view('admin.index', ['img'=>$img]);
        }

        return view('admin.index');
    }


    function postComment(Request $request){
        
        $validator = \Validator::make($request->all(),[
            'comment'=>'required|min:10'
          
        ], 
        [
            'comment.required'=>'Vui lòng nhập nhận xét',
            'comment.min'=>'Bình luận quá ngắn'
        ]);

        if ($validator->fails())
        {
            return redirect(url()->previous().'#comment')->with(['errors'=>$validator->errors()]);
        }

        $id =  $request->input('idcourse');
        $local = $request->local;

        $comment = new Comment;
        $comment->id = mt_rand(100000,999999);
        while (Comment::where('id', $comment->id)->exists()) {
            $comment->id = mt_rand(100000,999999);
        }

        $comment->content = $request->comment;
        $comment->id_course = $id;
        $comment->id_user = Auth::user()->id;

        $register = false;
        if(Auth::check()){
            if(Register::where('id_student', Auth::user()->id)->where('id_course', $id)->exists()){
                $register = true;
            }
        }

        $comment->local = $local;
        $comment->save();

        return redirect(url()->previous().'#comment');

    }

    function postReplay(Request $request, $id){
        
        $replay = new Feedback;
        $replay->id = mt_rand(100000,999999);
        while (Feedback::where('id', $replay->id)->exists()) {
            $replay->id = mt_rand(100000,999999);
        }

        $replay->answer = $request->replay;
        $replay->id_comment = $id;
        $replay->local = false;
        $replay->id_users = Auth::user()->id;
        $replay->save();

        return redirect(url()->previous().'#comment');
    }

     function postReplayCourse(Request $request, $id){
        
        $replay = new Feedback;
        $replay->id = mt_rand(100000,999999);
        while (Feedback::where('id', $replay->id)->exists()) {
            $replay->id = mt_rand(100000,999999);
        }

        $replay->answer = $request->replay;
        $replay->id_comment = $id;
        $replay->local = true;
        $replay->id_users = Auth::user()->id;
        $replay->save();

        return redirect(url()->previous().'#comment');
    }
    


    function postDiscount (Request $request){
        $validator = \Validator::make($request->all(),[
            'coupon'=>'required|string|min: 3|max: 191'
          
        ], 
        [
            'coupon.required'=>'Vui lòng nhập mã giảm giá',
            'coupon.string'=>'Mã giảm giá không hợp lệ',
            'coupon.min'=>'Mã giảm giá không hợp lệ',
            'coupon.max'=>'Mã giảm giá không hợp lệ'

        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['errors'=>$validator->errors()]);
        }

        $discount = Discount::where('code', $request->coupon)->first();
        $timenow = Carbon::now('Asia/Ho_Chi_Minh');

        if($discount != null){
            if($discount->date_finish < $timenow) {
                return redirect()->back()->with(['time'=>'Mã giảm giá hết hạn sử dụng']);
            }

            if($discount->quantity == 0) {
                return redirect()->back()->with(['quantity'=>'Hết lượt sử dụng']);
            }

            return redirect()->back()->with(['sale'=>$discount->reduce, 'name'=>$request->coupon]);
        } else {
            return redirect()->back()->with(['err'=>'Mã không tồn tại']);
        }
    }

    function postStudyLesson(Request $request){
        if($request->ajax()){
            if(StudyLesson::where('id_lesson',  $request->input('_id'))->where('id_user', Auth::user()->id)->exists()){
                return redirect()->back();
            } else {
                $studylesson = new StudyLesson;
                $studylesson->id_lesson = $request->input('_id');
                $studylesson->id_user = Auth::user()->id;
                $studylesson->save();
                return redirect()->back();
            }
        }
    }

    function getOverview ($id){
        $test = CourseTest::find($id);
        $testDetail = Test::find($test->id_test);
        $listquestion = TestDetail::where('id_test', $testDetail->id)->where('id_question', '>', 1000)->get();
        $listquestionBasic = TestDetail::where('id_test', $testDetail->id)->where('id_question', '<', 1000)->get();
        $course = Course::find($test->id_course);
        $info = Test::where('id', $test->id_test)->first();

        $register = Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->first();
        $tested = false;
        $studyTest = StudyTest::where('id_test', $id)->where('id_register', $register->id)->first();
        if(count($studyTest) > 0){
            $tested = true;
        }

        return view('pages.overview', ['test'=>$test, 'course'=>$course, 'listQuestion'=>$listquestion, 'info'=>$info, 'tested'=>$tested, 'result'=>$studyTest, 'listquestionBasic'=>$listquestionBasic]);
    }

    function getTest($id, Request $request){
        $courseTest = CourseTest::find($id);
        $test = Test::find($courseTest->id_test);
        $testDetail = TestDetail::where('id_test', $test->id)->get();

        $detailPara = [];
        $questionAudio = [];
        $detailAudio = [];
        $questionPara = [];
        $questionBasic = [];

        foreach ($testDetail as $value) {
            if(Question::where('id', $value->id_question)->where('id_qtype', 2)->exists()){
                $questionAudio[] = Question::where('id', $value->id_question)->where('id_qtype', 2)->get();
            }
            else if(Question::where('id', $value->id_question)->where('id_qtype', 1)->exists()){ 
                $questionPara[] = Question::where('id', $value->id_question)->where('id_qtype', 1)->get();
            } 
            else {
                $questionBasic[] = QuestionBasic::where('id', $value->id_question)->get();
            }
        }

        foreach($questionPara as $para) {
            $detailPara[] = QuestionDetail::where('id_question', $para[0]->id)->get();
        }

        foreach ($questionAudio as $audio) {
            $detailAudio[] = QuestionDetail::where('id_question', $audio[0]->id)->get();
        }

        if(count($questionBasic) > 0) {
            $type = 1;
        }else if (count($questionPara) > 0) {
            $type = 2;
        }else {
            $type = 3;
        }

        if($request->ajax()){
            $type = $request->input('_type');
        }

        return view('pages.test', ['courseTest'=>$courseTest, 'test'=>$test,'questionBasic'=>$questionBasic, 'questionPara'=>$questionPara, 'detailPara'=>$detailPara, 'questionAudio'=>$questionAudio, 'detailAudio'=>$detailAudio, 'type'=>$type]);
   
    }

    function postQuiz(Request $request, $id){

        $courseTest = CourseTest::find($id);

        $course = Course::find($courseTest->id_course)->first();
        $register = Register::where('id_student', Auth::user()->id)->where('id_course', $courseTest->id_course)->first();


        $test = Test::find($courseTest->id_test);
        $arrayQuiz = [];
        $testDetail = TestDetail::where('id_test', $test->id)->get();
        $arrayContent[] = QuestionDetail::select('id')->where('id_question', $test->id_question)->distinct('id')->get();
        
        foreach($testDetail as $test) {
            if($test->id_question < 1000) 
            {
                $arrayQuiz[] = array('answer'=>QuestionBasic::select('correctAnswer')->where('id', $test->id_question)->first(),'id'=>$test->id_question, 'type'=>'basic');
            } else 

            {
                $array = QuestionDetail::select('id')->where('id_question', $test->id_question)->distinct('id')->get();
                foreach($array as $a)
                {
                    $arrayQuiz[] = array('answer'=>QuestionDetail::select('correctAnswer')->where('id', $a->id)->first(), 'id'=>$a->id, 'type'=>'content');
                }
            }

        }

        $scoreBasic = 0;
        $scorePara = 0;
        $totalScore = 0;

        // return $register->id;

        // return $course;

        if($request->ajax()){
            $arrAnswer = $request->Input('_arrAnswer');
            $type = $request->Input('_type');
            
            $time = $request->Input('_time');

            if(count($arrAnswer) > 0){
                if($type == 2) {
                    $studyTest = new StudyTest;
                    $studyTest->id = mt_rand(100000,999999);
                        while (StudyTest::where('id', $studyTest->id)->exists()) {
                        $studyTest->id = mt_rand(100000,999999);
                    }

                    $idST = $studyTest->id;
                    $studyTest->id_test = $id;
                    $studyTest->id_register = $register->id;

                    if(count($arrAnswer) > 0){
                        
                        foreach ($arrAnswer as $answer) {
                            foreach($arrayQuiz as $quiz) {
                                if(!empty($quiz)){
                                    if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correctAnswer'] && $quiz['type'] ){
                                        $scoreBasic = $scoreBasic + 1;         
                                    }
                                }
                            }
                        }
                    }

                    $studyTest->score = $scoreBasic;
                    $studyTest->time = $time;
                    $studyTest->save();
                    foreach ($arrAnswer as $answer){
                        $studyTestDetail = new StudyTestDetail;
                        $studyTestDetail->id_study_test = $idST;
                        $studyTestDetail->answer = $answer['answer'];
                        $studyTestDetail->id_question = $answer['id'];
                        foreach($arrayQuiz as $quiz) {
                            if(!empty($quiz)) {
                                if($type == 2) {
                                    if($studyTestDetail->id_question == $quiz['id'] && $studyTestDetail->answer == $quiz['answer']['correctAnswer'] && $quiz['type'] == 'basic'){
                                            $studyTestDetail->correct = 1;
                                            break;  
                                            }
                                    $studyTestDetail->correct = 0; 
                                } else {
                                    if($studyTestDetail->id_question == $quiz['id'] && $studyTestDetail->answer == $quiz['answer']['correctAnswer'] && $quiz['type'] == 'content'){
                                        $studyTestDetail->correct = 1;
                                        break;  
                                        }
                                    $studyTestDetail->correct = 0; 
                                }
                            }
                        }

                        if($type == 2){
                            $studyTestDetail->type = 'basic';
                        } else {
                            $studyTestDetail->type = 'content';
                        }

                            $studyTestDetail->save();
                    }
                } else {

                    if(StudyTest::where('id_register', $register->id)->where('id_test', $courseTest->id)->exists())
                    {
                        $studyTest = StudyTest::where('id_register', $register->id)->where('id_test', $courseTest->id)->first();
                        foreach ($arrAnswer as $answer){
                        $studyTestDetail = new StudyTestDetail;
                        $studyTestDetail->id_study_test = $studyTest->id;
                        $studyTestDetail->answer = $answer['answer'];
                        $studyTestDetail->id_question = $answer['id'];
                        foreach($arrayQuiz as $quiz) {
                            if(!empty($quiz)) {
                               
                                if($studyTestDetail->id_question == $quiz['id'] && $studyTestDetail->answer == $quiz['answer']['correctAnswer'] && $quiz['type'] == 'content'){
                                    $studyTestDetail->correct = 1;
                                    break;  
                                    }
                                    $studyTestDetail->correct = 0; 
                                } 
                            }
               
                            $studyTestDetail->type = 'content';
                            $studyTestDetail->save();
                        } 
                    } else {
                        return 'haha';
                    }

                }
            } else {  
                foreach($arrayQuiz as $quiz) {
                    if(!empty($quiz)) {
                        if($type == 2){
                            if($quiz['type'] == 'basic'){
                                $studyTestDetail = new StudyTestDetail;
                                $studyTestDetail->id_study_test = $idST;
                                $studyTestDetail->answer = null;
                                $studyTestDetail->id_question = $quiz['id'];          
                                $studyTestDetail->correct = 0;
                                $studyTestDetail->type = 'basic';
                                $studyTestDetail->save();
                            }
                        } else {
                            if($quiz['type'] == 'content'){
                                $studyTestDetail = new StudyTestDetail;
                                $studyTestDetail->id_study_test = $idST;
                                $studyTestDetail->answer = null;
                                $studyTestDetail->id_question = $quiz['id'];          
                                $studyTestDetail->correct = 0;
                                $studyTestDetail->type = 'content';
                                $studyTestDetail->save();
                            }
                        }
                    }
                }
            }
        }

        if(!$request->ajax()){  

            $question = $request->Input('question');
            $type = $request->type;
            foreach($question as $ques){
                $arrAnswer[] = array('answer'=>$request->Input('answer'.$ques.''), 'id'=>$ques); 
            }

            foreach($arrayQuiz as $quiz) {
                if(!empty($quiz)) {
                    foreach ($arrAnswer as $answer) {
                        if($type == 2) {
                              if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correctAnswer'] && $quiz['type'] == 'basic'){
                                $scorePara = $scorePara + 1;
                            }
                        } else { 
                            if($answer['id'] == $quiz['id'] && $answer['answer'] == $quiz['answer']['correctAnswer'] && $quiz['type'] == 'content'){
                                $scorePara = $scorePara + 1;
                            }
                        }
                    }
                }
            }


            if(StudyTest::where('id_register', $register->id)->where('id_test', $id)->exists()){
                $studyTest = StudyTest::where('id_register', $register->id)->where('id_test', $id)->first();
                $idST = $studyTest->id;
                $score = $studyTest->score;
                $total = $score + $scorePara;
                $studyTest->score = $total;
                $studyTest->time = $request->time;
                $studyTest->save();
                for($i = 0; $i < count($arrAnswer); $i++) {
                    $studyTestDetail = new StudyTestDetail;
                    $studyTestDetail->id_study_test = $idST;
                    $studyTestDetail->answer = $arrAnswer[$i]['answer'];
                    $studyTestDetail->id_question = $arrAnswer[$i]['id'];
                    foreach($arrayQuiz as $quiz) {
                        if(!empty($quiz)) {        
                            if( $studyTestDetail->id_question == $quiz['id'] && $studyTestDetail->answer == $quiz['answer']['correctAnswer'] && $studyTestDetail->type == 'content'){  
                                $studyTestDetail->correct = 1; 
                                break; 
                            }
                                $studyTestDetail->correct = 0;   
                               
                        }
                    }
                    if($request->basic == 1 ) {
                        $studyTestDetail->type = 'basic';
                    } else {
                        $studyTestDetail->type = 'content';
                    }
                    
                    $studyTestDetail->save();
                }

            } else {
                $studyTest = new StudyTest;
                $studyTest->id = mt_rand(100000,999999);
                while (StudyTest::where('id', $studyTest->id)->exists()) {
                    $studyTest->id = mt_rand(100000,999999);
                }
                $idST = $studyTest->id;

                $studyTest->id_register = $register->id;
                $studyTest->score = $scorePara;
                $studyTest->id_test = $id;
                $studyTest->time = $request->time;
                $studyTest->save();

                for($i = 0; $i < count($arrAnswer); $i++) {
                    $studyTestDetail = new StudyTestDetail;
                    $studyTestDetail->id_study_test = $idST;
                    $studyTestDetail->answer = $arrAnswer[$i]['answer'];
                    $studyTestDetail->id_question = $arrAnswer[$i]['id'];
                    foreach($arrayQuiz as $quiz) {
                        if(!empty($quiz)) {          
                            if( $studyTestDetail->id_question == $quiz['id'] && $studyTestDetail->answer == $quiz['answer']['correctAnswer']){  
                                $studyTestDetail->correct = 1; 
                                break; 
                            }
                                $studyTestDetail->correct = 0;   
                               
                        }
                    }
                    
                    if($request->basic == 1 ) {
                        $studyTestDetail->type = 'basic';
                    } else {
                        $studyTestDetail->type = 'content';
                    }
                    

                    $studyTestDetail->save();
                }

            }
        }
        return redirect()->route('overview', ['id'=>$id]);  
    }


    function getReview($id, Request $request){
        $courseTest = CourseTest::find($id);
        $course = Course::find($courseTest->id_course);
        $test = Test::find($courseTest->id_test);
        $testDetail = TestDetail::where('id_test', $test->id)->get();

        $detailPara = [];
        $questionAudio = [];
        $detailAudio = [];
        $questionPara = [];
        $questionBasic = [];

        foreach ($testDetail as $value) {
            if(Question::where('id', $value->id_question)->where('id_qtype', 2)->exists()){
                $questionAudio[] = Question::where('id', $value->id_question)->where('id_qtype', 2)->get();
            }
            else if(Question::where('id', $value->id_question)->where('id_qtype', 1)->exists()){ 
                $questionPara[] = Question::where('id', $value->id_question)->where('id_qtype', 1)->get();
            } 
            else {
                $questionBasic[] = QuestionBasic::where('id', $value->id_question)->get();
            }
        }

        foreach($questionPara as $para) {
            $detailPara[] = QuestionDetail::where('id_question', $para[0]->id)->get();
        }

        foreach ($questionAudio as $audio) {
            $detailAudio[] = QuestionDetail::where('id_question', $audio[0]->id)->get();
        }

        if(count($questionBasic) > 0) {
            $type = 1;
        } else if (count($questionPara) > 0) {
            $type = 2;
        } else {
            $type = 3;
        }

        if($request->ajax()){
            $type = $request->input('_type');
        }

        //get test list result
        $register = Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->first();
        $tested = false;
        $studyTest = StudyTest::where('id_test', $id)->where('id_register', $register->id)->first();
        $studyTestDetail = StudyTestDetail::where('id_study_test', $studyTest->id)->get();

        // return $studyTestDetail;

        //get answer list
        
        $testDetail = TestDetail::where('id_test', $test->id)->get();
        
       
        return view('pages.review', ['courseTest'=>$courseTest, 'test'=>$test,'questionBasic'=>$questionBasic, 'questionPara'=>$questionPara, 'detailPara'=>$detailPara, 'questionAudio'=>$questionAudio, 'detailAudio'=>$detailAudio, 'type'=>$type, 'studyTestDetail'=>$studyTestDetail, 'result'=>$studyTest]);
    }


    function getProfile(Request $request, $id){
        
        if(Auth::check()) {
            
            

            if(Auth::id() == $id) {
            
                if(Auth::user()->id_utype == 3) {
              
                    $student = Student::find($id);

                    $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
                    $student->setAttribute('img', $img);

                } else {

                    $student = Teacher::find($id);
                    $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
                    $student->setAttribute('img', $img);
                }
              
                $page = 1;
                if($request->ajax()){
                    $page = $request->Input('_type');
                }

                return view('pages.profile', ['student'=>$student, 'page'=>$page, 'type'=>Auth::user()]);

            } else {

                return view('pages.index'); 
            }

        } else {
            return view('pages.index')->with(['openSuccessReg'=>true, 'regSuccess'=>'Vui lòng đăng nhập']);
        }
    }

    function postProfile(updateProfileRequest $request, $id){
        


        if(Student::where('id', $id)->exists()){
            $student = Student::find($id);
            $student->name = $request->name;
            $student->birthday = $request->date;
            $student->gender = $request->sex == 0 ? 'Nam' : 'Nữ';
            
            if($student->gender == 'Nữ' && $student->avatar == 'male-define_iogxda') {
                $student->avatar = 'female-define_dkudqx';
            }
            if ($student->gender == 'Nam' && $student->avatar == 'female-define_dkudqx') {
               $student->avatar = 'male-define_iogxda';
            } 

            $student->address = $request->address;
            $student->phone = $request->phone;
            $student->save();
        } else {
            $teacher = Teacher::find($id);
        }
       

        return redirect()->back()->with('openModal', true);
    }

    function getAccount(Request $request, $id){

        $user = User::find($id);
        if(Student::where('id', $id)->exists()){
            $student = Student::find($id);

            $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
            $student->setAttribute('img', $img);

        } else {
            $student = Teacher::find($id);
            $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
            $student->setAttribute('img', $img);
        }
      
        
        $register = Register::where('id_student', $student->id)->get();
        $course = Course::all();
        $page = 1;

        if($request->ajax()){
            $page = $request->Input('_type');
            
        }

        return view('pages.account', ['student'=>$student, 'page'=>$page, 'register'=>$register, 'type'=>$user]);
    }

    function postChangePass(Request $request, $id){

        $page = 2;
        
        $validator = \Validator::make($request->all(),[
            'pass'=>'required',
            'newpass'=>'required',
            'cfpass'=>'required|same:newpass',
        ], 
        [
           'pass.required'=>'Vui lòng nhập mật khẩu',
            'newpass.required'=>'Vui lòng nhập mật khẩu mới',
            'cfpass.required'=>'Vui lòng xác nhận lại mật khẩu',
            'cfpass.same'=>'Mật khẩu không chính xác'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['errors'=>$validator->errors(), 'page'=>$page]);
        }

        $user = User::find($id);
        
        if (Hash::check($request->pass, $user->password)){
            $user->password = bcrypt($request->pass);
            $user->save();
            return redirect()->back()->with(['notify'=>'Thay đổi mật khẩu thành công', 'page'=>$page]);
        } else {
            return redirect()->back()->with(['passerror'=>'Mật khẩu không đúng', 'page'=>$page]);
        }


    }

    // public function rechargeAccount($id) {
    //     if(User::find($id)->exists()) {
    //         $user = User::find($id);
    //         $user->balance_account =  $user->balance_account + 100000;
    //         $user->save();
    //     }   
        
    //     return redirect()->back();
    // }

    public function showTeacher($id) {
        $teacher = Teacher::find($id);
        $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
        $teacher->setAttribute('img', $img);

        $user = User::where('id', $id)->first();
        return view('pages.teacher', ['student'=>$teacher, 'user'=>$user]);
    }

    public function listTeacher() {
        $lsteacher = Teacher::all();
        if(count($lsteacher) > 0) {
            foreach ($lsteacher as $key) { 
                $img = Cloudder::show('english-Center/avatar/'.$key->avatar); 
                $key->setAttribute('img', $img);
            }
        }
        

        return view('pages.lsteacher',['lsteacher'=>$lsteacher]);
    }
}
