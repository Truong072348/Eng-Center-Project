<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\updateProfileRequest;
use App\Http\Requests\changePasswordRequest;
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
use Carbon\Carbon;
use App\Register;
use App\StudyLesson;
use App\TestDetail;
use App\QuestionBasic;
use App\Question;
use App\QuestionDetail;
use App\StudyTest;
use App\StudyTestDetail;
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
    }

    function getIndex(){
  		$courseList = Course::where('status', '=', 'opening')->paginate(6);
    	return view('pages.index', ['courseList'=>$courseList]);
    }

    function getCourse($keyword){
        $key = $keyword;
        $courseList = null;
        if(Course::where('status' , 'opening')->where(function($q) use ($key){
            $q->where('name', 'like', "%$key%")->orWhere('description', 'like', "$key")->orWhere('short_description', 'like', "%$key%"); })->exists()) {

            $courseList = Course::where('status' , 'opening')->where(function($q) use ($key){
                $q->where('name', 'like', "%$key%")->orWhere('description', 'like', "$key")->orWhere('short_description', 'like', "%$key%");
            })->paginate(9);

        }
    	return view('pages.list', ['courseList'=>$courseList, 'key'=>$keyword]);
    }

    function postSearch(Request $request){
        $keyword = $request->search;
        
        return redirect()->route('list', ['keyword'=>$keyword]);
    }

    function getCourseType($keyword){
        $courseList = Course::where('id_ctype', $keyword)->where('status', '=', 'opening')->paginate(9);
        $cate = CategoryType::where('id', $keyword)->first();
        if(count($cate) > 0){
            $name = Category::where('id', $cate->id_category)->first();
            return view('pages.list', ['courseList'=>$courseList, 'key'=>$keyword, 'name'=>$name]);
        }
        
        return view('pages.list', ['courseList'=>$courseList, 'key'=>$keyword, 'cate'=>$cate]);
    }

    function getIntro($id){
        $courseIntro = Course::find($id);
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

        $comment = Comment::where('id_course', $id)->where('local', 0)->orderBy('created_at', 'DESC')->paginate(5);
        $feedback = Feedback::where('local', 0)->get();
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

    function payment($id){
        $course = Course::find($id);
        $teacher = Teacher::where('id', $course->id_teacher)->first();
        return view('pages.pay', ['course'=>$course, 'teacher'=>$teacher]);
    }

    function getAdminIndex(){
        return view('admin.index');
    }

    function postLogin(Request $request){
        $validator = \Validator::make($request->all(),[
            'username'=>'required',
            'password'=>'required'
        ], 
        [
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'password.required'=>'Vui lòng nhập mật khẩu'

        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['openLogin'=> true, 'errors'=>$validator->errors()]);
        }

        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password])){
            return redirect()->back();    
        } else {
            return redirect()->back()->with(['openLogin'=> true,
                'message'=>'Tên đăng nhập hoặc mật khẩu không đúng'
            ]);
        }

    }


    function getLogout(){
        Auth::logout();
        return redirect('index');
    }

    function postRegister(Request $request){
        $validator = \Validator::make($request->all(),[

            'user'=>'required|unique:users,username',
            'pass'=>'required|min: 3',
            'name'=>'required',
            'phone'=>'required|min: 9|max: 11',
            'address'=>'required',
            'email'=>'required|unique:users,email'
        ], 
        [
            'user.unique'=>'Tên đăng nhập đã tồn tại',
            'user.required'=>'Vui lòng nhập tên tài khoản',
            'pass.required'=>'Vui lòng nhập mật khẩu',
            'pass.min'=>'Mật khẩu quá ngắn',
            'name.required'=>'Vui lòng nhập tên',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.min'=>'Số điện thoại không hợp lệ',
            'phone.max'=>'Số điện thoại không hợp lệ',
            'address.required'=>'Vui lòng nhập địa chỉ',
            'email.required'=>'Vui lòng nhập email',
            'email.exists'=>'exists.connection.users.email'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['openRegister'=> true, 'errors'=>$validator->errors(), 'regfail'=>true]);
        }


        if(User::where('username', $request->user)->exists()){
             return redirect()->back()->with(['openRegister', true]);
        }

        $user = new User;
        $user->id = mt_rand(100000,999999);
        while (Hash::check($user->id, $user->password)){
            $user->id = mt_rand(100000,999999);
        }
        $iduser = $user->id;
        $user->username = $request->user;
        $user->password = bcrypt($request->pass);
        $user->email = $request->email;
        $user->account_balance = 0;
        $user->id_utype = 3;
        $user->save();

        $student = new Student;
        $student->id = $iduser;
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->birthday = '1970-01-01';
        $student->gender = 'Nam';
        $student->avatar = 'male-define.jpg';
        $student->save();

        return redirect()->back()->with(['openSuccessReg'=>true, 'regSuccess'=>'Đăng ký thành công. Đăng nhập ngay!!']);   

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
            'coupon'=>'required'
          
        ], 
        [
            'coupon.required'=>'Vui lòng nhập mã giảm giá'
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

    function postPayment(Request $request, $id){
        
        if(Auth::user()->account_balance < $request->price){
            return redirect('payment/'.$id)->with(['pushCard'=>true]);
        }


        $register = new Register;
        $register->id = mt_rand(100000,999999);
        while (Register::where('id', $register->id)->exists()) {
            $register->id = mt_rand(100000,999999);
        }
        $register->price = $request->price;
        $register->id_course = $id;

        if(Discount::where('code', $request->idcoupon)->exists()){
            $coupon = Discount::where('code', $request->idcoupon)->first();
            $register->id_discount = $coupon->id;
        }

        $register->id_student = Auth::user()->id;
        
        $user = User::find(Auth::user()->id);
        
        $cash = $user->account_balance;

        if(Discount::where('code', $request->idcoupon)->exists()){
            $coupon = Discount::where('code', $request->idcoupon)->first();
            $coupon->quantity = $coupon->quantity - 1;
            $pay = $cash - $request->price + $coupon->reduce;

            $coupon->save();
        } else {
            $pay = $cash - $request->price;  
        }

        $user->account_balance = $pay;
        $user->save();

        $register->save();

        return redirect('course/'.$id)->with(['success'=>'Đăng ký khóa học thành công']);

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
        $user = User::find($id);
        if(Student::where('id', $id)->exists()){
            $student = Student::find($id);

            $img = Cloudder::show('english-Center/avatar/'.$student->avatar, array("width" => 250, "height" => 250, "crop" => "fill")); 
            $student->setAttribute('img', $img);

        } else {
             $student = Teacher::find($id);
        }
      
        $page = 1;
        if($request->ajax()){
            $page = $request->Input('_type');
        }
        return view('pages.profile', ['student'=>$student, 'page'=>$page, 'type'=>$user]);
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

            $img = Cloudder::show('english-Center/avatar/'.$student->avatar, array("width" => 250, "height" => 250, "crop" => "fill")); 
            $student->setAttribute('img', $img);

        } else {
             // $student = Teacher::find($id);
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

    public function rechargeAccount($id) {
        if(User::find($id)->exists()) {
            $user = User::find($id);
            $user->balance_account =  $user->balance_account + 100000;
            $user->save();
        }   
        
        return redirect()->back();
    }
}
