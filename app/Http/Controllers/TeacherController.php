<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\updateTeacherRequest;
use App\Http\Requests\addTeacherRequest;
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
        } else {
    	   $teacher = Teacher::paginate(8);
        }
    	   
        if(!empty($teacher)) {
            foreach ($teacher as $key) {
                $img = Cloudder::show('english-Center/avatar/'.$key->avatar);
                $key->setAttribute('avatar', $img);
            }
        }

        return view('admin.teacher.list',['teacher'=>$teacher]);
    }

    public function getAdd(){
    	return view('admin.teacher.add');
    }

    public function postAdd(addTeacherRequest $request){
        
        $id = mt_rand(100000,999999);
        while (User::where('id', $id)->exists()){
            $id = mt_rand(100000,999999);
        }

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            Cloudder::upload($file, 'english-Center/avatar/'.$img);
        } else {
            $img = $request->sex == 0 ? 'male-define.jpg' : 'female-define.jpg'; 
        }

        Teacher::create([
            'id' => $id,
            'name' => $request->name,
            'birth' => $request->birth,
            'phone' => $request->tel,
            'address' => $request->address,
            'slogan' => $request->slogan,
            'degree' => $request->degree,
            'introduction' => $request->intro,
            'avatar' => $img,
            'gender' => $request->sex == 0 ? 'Nam' : 'Nữ'
        ]);
        
        User::create([
            'id'=> $id,
            'email' => $request->email,
            'username' => $request->user,
            'password' => Hash::make($request->pass),
            'account_balance' => 100000000,
            'id_utype' => 2
        ]);

        return redirect('admin/teacher/add')->with('notify','Successfully Added');
    }

    public function getEdit($id){

        $teacher = Teacher::where('teacher.id', $id)->join('users', 'users.id', '=', 'teacher.id')->firstOrFail();
        $teacher->setAttribute('avatar', Cloudder::show('english-Center/avatar/'.$teacher->avatar));

        $course = Course::where('id_teacher', $id)->get();
        
        if(!empty($course)) {
            foreach ($course as $key) {
                $level = Course::select('category.name', 'category_type.level')->where('course.id', $key->id)->join('category_type', 'category_type.id', '=', 'course.id_ctype')->join('category', 'category.id', '=', 'category_type.id_category')->groupBy('category.name', 'category_type.level')->get();
                $key->setAttribute('level', $level);
            }
            
        }

    	return view('admin.teacher.edit', ['teacher'=>$teacher, 'course'=>$course]);
    }


    public function postEdit(updateTeacherRequest $request, $id){
        
        $user = User::find($id);
        if(!empty($request->oldpass) || !empty($request->pass) || !empty($request->cfpass)){ 

            if (Hash::check($request->oldpass, $user->password)){
                
                $user->password = Hash::make($request->pass);
                $user->save();

            } else {
                return redirect('admin/teacher/edit/'.$id)->with(['errorpass'=>'Mật khẩu không chính xác', 'passerr'=>true]);
            }

        } 

        $teacher = Teacher::find($id);

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            Cloudder::upload($file, 'english-Center/avatar/'.$img);
            $request->avatar = $img;
        }

        $request->gender = $request->gender == 0 ? 'Nam' : 'Nữ';
        $teacher->fill($request->all())->save();
        
        return redirect('admin/teacher/edit/'.$id)->with(['notify'=>'Successfully Updated']);

    }
}
