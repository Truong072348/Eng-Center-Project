<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addStudentRequest;
use App\Student;
use App\User;
use App\Register;
use App\CategoryType;
use App\Course;
use App\Category;
use App\Teacher;
use Validator;
use Cloudder;
use Hash;

class StudentController extends Controller
{

    function __construct(){

        $courses = Course::all();
        $types = CategoryType::all();
        $categories = Category::all();
        $registers = Register::all();
        $accounts = User::where('id_utype', 3)->join('student', 'users.id', '=', 'student.id')->get();
        foreach ($accounts as $key) {
            $img = Cloudder::show('english-Center/avatar/'.$key->avatar);
            $key->setAttribute('avatar', $img);
        }

        view()->share('course', $courses);
        view()->share('category', $categories);
        view()->share('type', $types);
        view()->share('registers', $registers);
        view()->share('account', $accounts);
    }

    public function getList(Request $request){

        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $student = Student::where('name', 'like', "%$keyword%")->paginate(10);

        } else if ($request->ajax()) {
            $record = $request->input('_record');
            $student = Student::paginate($record);

        } else {
            $student = Student::Paginate(10);
        }

    	return view('admin/student/list', ['student'=>$student]);
    }

    public function getAdd(){
    	
    	return view('admin/student/add');
    }

    public function postAdd(addStudentRequest $request){

        $id = mt_rand(100000,999999);

        while (User::where('id', $id)->exists()) {
             $id = mt_rand(100000,999999);
        }

        $input['id'] = $id;
        $input['name'] = $request->name;
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        $input['birthday'] = $request->birthday;


        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $rand_name = str_random(5)."_".$name;

            Cloudder::upload($file, 'english-Center/avatar/'.$rand_name);

            $input['avatar'] = $rand_name;

        } else {
            $input['avatar'] = $request->gender == 0 ? 'male-define_iogxda' : 'female-define_dkudqx'; 
        }

        $input['gender'] = $request->genderr == 0 ? 'Nam' : 'Nữ';
        
        Student::create($input);

        $input_user['id'] = $id; 
        $input_user['username'] = $request->username; 
        $input_user['password'] = Hash::make($request->password); 
        $input_user['account_balance'] = 100000000; 
        $input_user['email'] = $request->email; 
        $input_user['id_utype'] = 3; 

        User::create($input_user);

    	return redirect('admin/student/add')->with(['notify'=>'Thêm thành công']);
    }

    public function getProfile($id) {
        if(Student::where('id', $id)->exists()) {
            $student = Student::where('student.id', $id)->join('users', 'users.id', '=', 'student.id')->firstOrFail();

            $avatar = Cloudder::show('english-Center/avatar/'.$student->avatar);
            $student->setAttribute('avatar', $avatar);

            return view('admin/student/profile', ['student' => $student]);
        } else {
            return redirect()->route('listStudent');
        }
    }
}

