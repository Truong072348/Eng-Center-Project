<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\User;
use App\Register;
use App\CategoryType;
use App\Course;
use App\Category;

class StudentController extends Controller
{
    public function getList(Request $request){

        $register = Register::all();
        $account = User::all();
        $course = Course::all();

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
    	 $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'phone'=>'required|min:9|max:11',
                'date'=>'required',
                'address'=>'required',
                'email'=>'required|unique:users',
                'user'=>'required|min:3|unique:users,username',
                'pass'=>'required',
                'cfpass'=>'required|same:pass',
          		

            ], 
            [
                'name.required'=>'Vui lòng nhập họ tên',
                'name.min'=>'Tên quá ngắn',
                'name.max'=>'Tên quá dài',
                'phone.required'=>'Vui lòng nhập số điện thoại',
                'phone.min'=>'Số điện thoại không hợp lệ',
                'phone.max'=>'Số điện thoại không hợp lệ',
                'date.required'=>'Vui lòng nhập thông tin',
                'email.required'=>'Vui lòng nhập email',
                'email.unique'=>'Email đã tồn tại',
                'address.required'=>'Vui lòng nhập địa chỉ',
                'user.required'=>'Vui lòng nhập tên đăng nhập',
                'user.min'=>'Tên đăng nhập quá ngắn',
                'user.unique'=>'Tên tài khoản đã tồn tại',
                'pass.required'=>'Vui lòng nhập mật khẩu',
                'cfpass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'cfpass.same'=>'Xác nhận lại mật khẩu',
              
            ]);

    	$student = new Student;

        $student->id = mt_rand(100000,999999);

        while (User::where('id', $student->id)->exists()) {
             $student->id = mt_rand(100000,999999);
        }

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            while (file_exists("Images/".$img)) {
                $img = str_random(5)."_".$name;
            }

            $file->move("Images", $img);

            $student->avatar = $img;
        } else {
            $student->avatar = $request->sex == 0 ? 'male-define.jpg' : 'female-define.jpg'; 
        }

        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->birthday = $request->date;
        $student->gender = $request->sex == 0 ? 'Nam' : 'Nữ';
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

    	return redirect('admin/student/add')->with(['notify'=>'Successfully Added']);
    }

    public function getProfile($id){

        $student = Student::find($id);
        $registerCourse = Register::where('id_student', $id)->get();
        $user = User::find($id);
        $course = Course::all();

        $type = CategoryType::all();
        $category = Category::all();
        
       

    	return view('admin/student/profile',['student'=>$student, 'course'=>$course, 'user'=>$user, 'category'=>$category, 'type'=>$type, 'regcourse'=>$registerCourse]);
    }
}
