<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\updateTeacherRequest;
use App\Teacher;
use App\User;
use App\Course;
use App\CategoryType;
use App\Category;
use Hash;
use Cloudder;
use Validator;


class TeacherController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function getList(Request $request){
        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $teacher = Teacher::where('name', 'like', "%$keyword%")->paginate(9);
 
            return view('admin.teacher.list',['teacher'=>$teacher]);
        }

    	$teacher = Teacher::paginate(8);
    	return view('admin.teacher.list',['teacher'=>$teacher]);
    }

    public function postSearch(Request $request){
        $search = $request->search;
        return redirect()->route('listTeacher', ['keyword'=>$search]);
    }

    public function getAdd(){
    	return view('admin.teacher.add');
    }

    public function getEdit($id){
        $teacher = Teacher::find($id);
        $course = Course::where('id_teacher', $id)->get();
        $account = User::find($id);

        $type = '';
        $category = '';
        
        foreach($course as $c){
            $type = CategoryType::where('id',$c->id_ctype)->get();
        }
        if($type != '') {
            foreach($type as $t){
                $category = Category::where('id', $t->id_category)->get();
            }
        }
        
    	return view('admin.teacher.edit', ['teacher'=>$teacher, 'course'=>$course, 'account'=>$account,'type'=>$type, 'category'=>$category]);
    }


    public function postEdit(updateTeacherRequest $request, $id){
        

        $passerr = 1;
        $user = User::find($id);
        if($request->oldpass != '' || $request->pass != '' || $request->cfpass != ''){ 

            if (Hash::check($request->pass, $user->password)){
                $user->password = bcrypt($request->pass);
                $user->save();

                $teacher = Teacher::find($id);
                $teacher->name = $request->name;
                $teacher->birth = $request->birth;
                $teacher->phone = $request->tel;
                $teacher->address = $request->address;
                $teacher->slogan = $request->slogan;

                if($request->hasFile('avatar')){
                    $file = $request->file('avatar');
                    $name = $file->getClientOriginalName();
                    
                    $img = str_random(5)."_".$name;
                    while (file_exists("Images/".$img)) {
                        $img = str_random(5)."_".$name;
                    }

                    echo $file;
                    $file->move("Images", $img);

                    $teacher->avatar = $img;
                } 


                $teacher->degree = $request->degree;
                $teacher->introduction = $request->intro;
                $teacher->gender = $request->sex == 0 ? 'Nam' : 'Nữ';
                $teacher->save();

            } else {
                return redirect('admin/teacher/edit/'.$id)->with(['errorpass'=>'Mật khẩu không chính xác', 'passerr'=>true]);
            }

        }else {

            $teacher = Teacher::find($id);
            $teacher->name = $request->name;
            $teacher->birth = $request->birth;
            $teacher->phone = $request->tel;
            $teacher->address = $request->address;
            $teacher->slogan = $request->slogan;

            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $name = $file->getClientOriginalName();
                
                $img = str_random(5)."_".$name;
                while (file_exists("Images/".$img)) {
                    $img = str_random(5)."_".$name;
                }

                echo $file;
                $file->move("Images", $img);

                $teacher->avatar = $img;
            }

             

            echo $teacher->avatar;

            $teacher->degree = $request->degree;
            $teacher->introduction = $request->intro;
            $teacher->gender = $request->sex == 0 ? 'Nam' : 'Nữ';
            $teacher->save();

        }


        return redirect('admin/teacher/edit/'.$id)->with(['notify'=>'Successfully Updated']);

    }

    public function postAdd(Request $request){
        $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'tel'=>'required|min:9|max:11',
                'birth'=>'required',
                'address'=>'required',
                'email'=>'required|unique:users',
                'user'=>'required|min:3|unique:users,username',
                'pass'=>'required',
                'cfpass'=>'required|same:pass',
                'degree'=>'required' 

            ], 
            [
                'name.required'=>'Vui lòng nhập họ tên',
                'name.min'=>'Tên quá ngắn',
                'name.max'=>'Tên quá dài',
                'tel.required'=>'Vui lòng nhập số điện thoại',
                'tel.min'=>'Số điện thoại không hợp lệ',
                'tel.max'=>'Số điện thoại không hợp lệ',
                'birth.required'=>'Vui lòng nhập thông tin',
                'email.required'=>'Vui lòng nhập email',
                'email.unique'=>'Email đã tồn tại',
                'address.required'=>'Vui lòng nhập địa chỉ',
                'user.required'=>'Vui lòng nhập tên đăng nhập',
                'user.min'=>'Tên đăng nhập quá ngắn',
                'user.unique'=>'Tên tài khoản đã tồn tại',
                'pass.required'=>'Vui lòng nhập mật khẩu',
                'cfpass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'cfpass.same'=>'Xác nhận lại mật khẩu',
                'degree.required'=>'Vui lòng nhập thông tin'
            ]);

        $teacher = new Teacher;
        $teacher->id = mt_rand(100000,999999);


        while (User::where('id', $teacher->id)->exists()){
            $teacher->id = mt_rand(100000,999999);
        }

        $teacher->name = $request->name;
        $teacher->birth = $request->birth;
        $teacher->phone = $request->tel;
        $teacher->address = $request->address;
        $teacher->slogan = $request->slogan;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            while (file_exists("Images/".$img)) {
                $img = str_random(5)."_".$name;
            }

            $file->move("Images", $img);

            $teacher->avatar = $img;
        } else {
            $teacher->avatar = $request->sex == 0 ? 'male-define.jpg' : 'female-define.jpg'; 
        }
        

        $teacher->degree = $request->degree;
        $teacher->introduction = $request->intro;
        $teacher->gender = $request->sex == 0 ? 'Nam' : 'Nữ';
        
        $user = new User;
        $user->id = $teacher->id;
        $user->email = $request->email;
        $user->username = $request->user;
        $user->password = bcrypt($request->pass);
        $user->account_balance = 0;
        $user->id_utype = 2;


        $user->save();
        $teacher->save();


        return redirect('admin/teacher/add')->with('notify','Successfully Added');
    }
}
