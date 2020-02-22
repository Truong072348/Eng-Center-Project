    <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\User;
use App\Register;
use App\CategoryType;
use App\Course;
use App\Category;
use Validator;
use Cloudder;

class StudentController extends Controller
{

    function __construct(){
        $teacherList = Teacher::all();
        $course = Course::all();
        $type = CategoryType::all();
        $category = Category::all();

        view()->share('course', $course);
        view()->share('category', $category);
        view()->share('type', $type);
    }

    public function getList(Request $request){

        $register = Register::all();
        $account = User::all();

        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $student = Student::where('name', 'like', "%$keyword%")->paginate(15);
 
            return view('admin/student/list', ['student'=>$student, 'register'=>$register, 'account'=>$account, 'course'=>$course, 'account'=>$account]);
        }


    	$student = Student::Paginate(5);

        if($request->ajax()){
            $record = $request->input('_record');

            $student = Student::paginate($record);
        
            return response(view('admin/student/list', ['student'=>$student, 'register'=>$register, 'account'=>$account, 'course'=>$course, 'account'=>$account]));
        }

    	

    	return view('admin/student/list', ['student'=>$student, 'register'=>$register, 'account'=>$account, 'course'=>$course, 'account'=>$account]);
    }

    public function postSearch(Request $request){
        $search = $request->search;
        return redirect()->route('listStudent', ['keyword'=>$search]);

    }

    public function getAdd(){
    	
    	return view('admin/student/add');
    }

    public function postAdd(Request $request){
    	
        Validator::addStudentRequest($request);

    	$student = new Student;

        $student->id = mt_rand(100000,999999);
        $request->gender = 1;

        while (User::where('id', $student->id)->exists()) {
             $student->id = mt_rand(100000,999999);
        }

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;

            Cloudder::upload($file, 'english-Center/avatar/'.$img);

            $file->move("Images", $img);

            $student->avatar = $img;
        } else {
            $student->avatar = $request->gender == 0 ? 'male-define_iogxda' : 'female-define_dkudqx'; 
        }

        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->birthday = $request->date;
        $student->gender = $request->gender == 0 ? 'Nam' : 'Nữ';
        $student->address = $request->address;

        $user = new User;
        $user->id = $student->id;
        $user->username = $request->user;
        $user->password = $request->pass;
        $user->account_balance = 0;
        $user->id_utype = 3;
        $user->email = $request->email;

        $user->save();
        $student->save();

    	return redirect('admin/student/add')->with(['notify'=>'Thêm thành công']);
    }


