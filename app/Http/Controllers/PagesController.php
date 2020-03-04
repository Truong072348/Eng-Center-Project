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
                    } elseif ($user->id_utype == 2) {
                        $teacher = Teacher::find($user->id);
                        $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
                        $key->setAttribute('img', $img);
                    } else {
                        $img = Cloudder::show('english-Center/avatar/42gkM_f0Arl_my-avatar_sfxb8c'); 
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
                } elseif ($user->id_utype == 2) {
                    $teacher = Teacher::find($type->id);
                    $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
                    $f->setAttribute('img', $img);
                } else {
                    $img = Cloudder::show('english-Center/avatar/42gkM_f0Arl_my-avatar_sfxb8c'); 
                    $key->setAttribute('img', $img);
                }

                $date = $f->created_at;
                $time = $date->diffForHumans($now);

                $f->setAttribute('time', $time);      
            }
        }

        $register = 0;

        if(Auth::check()){
            if(Register::where('id_student', Auth::user()->id)->where('id_course', $id)->exists()){
                $register = 1;
            }
        }
       
        // return $courseReference;
        return view('pages.intro', ['intro'=>$courseIntro, 'teacher'=>$teacherCourse, 'lessons'=>$lessonCourse, 'video'=>$video, 'refs'=>$courseReference, 'tests'=>$test, 'comments'=>$comment, 'feedback'=>$feedback,'registered'=>$register]);
    }

    function getDesc($lesson){

        if(Auth::check()) {
            if(Lesson::where('slug', $lesson)->exists()) {
                $lesson = Lesson::where('slug', $lesson)->firstOrFail();
                $course = Course::where('id', $lesson->id_course)->first();

                $lessonList = Lesson::where('id_course', $course->id)->get();
                $teacher = Teacher::where('id', $course->id_teacher)->first();
                $test = CourseTest::where('id_course', $course->id)->get();
                $comment = Comment::where('id_course', $course->id)->where('local', 1)->orderBy('created_at', 'DESC')->paginate(10);

                $now = Carbon::now();
                
                if(!empty($comment)) {
                    foreach ($comment as $key) {
                        if(User::where('id', $key->id_user)->exists()){
                            $user = User::find($key->id_user);

                            if($user->id_utype == 3) {
                                $student = Student::find($user->id);

                                $img = Cloudder::show('english-Center/avatar/'.$student->avatar); 
                                $key->setAttribute('img', $img);
                            } elseif ($user->id_utype == 2) {
                                $teacher = Teacher::find($user->id);
                                $img = Cloudder::show('english-Center/avatar/'.$teacher->avatar); 
                                $key->setAttribute('img', $img);
                            } else {
                                $img = Cloudder::show('english-Center/avatar/42gkM_f0Arl_my-avatar_sfxb8c'); 
                                $key->setAttribute('img', $img);
                            }
                        } 
                      
                        $date = $key->created_at;
                        $time = $date->diffForHumans($now);

                        $key->setAttribute('time', $time);        
                        }
                }


                $feedback = Feedback::where('local', 1)->orderBy('created_at', 'DESC') ->get();
                $register = false;
                $studyTest = '';
                if(Auth::check()){
                    if(Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->exists()){
                        $register = true;
                        $re = Register::where('id_student', Auth::user()->id)->where('id_course', $course->id)->first();
                        $studyTest = StudyTest::where('id', $re->id)->get();

                    }
                }

                $watched = StudyLesson::where('id_users', Auth::user()->id)->get();


                return view('pages.desc', ['lesson'=>$lesson, 'course'=>$course, 'teacher'=>$teacher, 'lessonList'=>$lessonList, 'test'=>$test, 'comments'=>$comment, 'feedback'=>$feedback, 'registered'=>$register, 'watched'=>$watched, 'studyTest'=>$studyTest]);
            } else {
                return view('pages.listnone');
            }
            
        } else {
            return view('pages.listnone');
        }
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

    //Page test (overtest, review, test work)


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
            foreach($lsteacher as $key) { 
                $img = Cloudder::show('english-Center/avatar/'.$key->avatar); 
                $key->setAttribute('img', $img);
            }
        }
        

        return view('pages.lsteacher',['lsteacher'=>$lsteacher]);
    }
}
