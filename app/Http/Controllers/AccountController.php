<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserType;
use App\Teacher;
use App\Student;
use Validator;


class AccountController extends Controller
{
    public function getList(Request $request){

        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            $account = User::paginate(25);
            $tAcc = UserType::all();
            $student = Student::where('name', 'like', "%$keyword%")->get();
            $teacher = Teacher::where('name', 'like', "%$keyword%")->get();
            $s = 1;
           
            return view('admin/account/list',['account'=>$account, 'type'=>$tAcc, 'teacher'=>$teacher, 'student'=>$student, 's'=>$s]);
        }

        $s = 0;
    	$account = User::paginate(5);
    	$tAcc = UserType::all();
    	$student = Student::all();
    	$teacher = Teacher::all();

    	if($request->ajax()){
    		$record = $request->input('_record');

    		$accounts = User::paginate($record);
        
            return response(view('admin/account/list',['account'=>$accounts, 'type'=>$tAcc, 'teacher'=>$teacher, 'student'=>$student, 's'=>$s]));
    	} else {

    	   return view('admin/account/list',['account'=>$account, 'type'=>$tAcc, 'teacher'=>$teacher, 'student'=>$student, 's'=>$s]);
        }
    }

    public function getLoginAdmin(){
        return view('admin.login');
    }

    public function postLoginAdmin(Request $request){
        
        Validator::SignupRequest($request)
        
        $user = User::where('username', $request->username)->first();

        if($user->id_utype == 2 || $user->id_utype == 1){
            if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password])){
                return redirect('admin/index');    
            } else {
                return redirect('admin/login')->with('error', 'Đăng nhập không thành công. Tên hoặc mật khẩu không đúng');
            }
        } else {
            return redirect('admin/login')->with('error', 'Đăng nhập không thành công. Tên hoặc mật khẩu không đúng');
        }

    }

    public function postSearch(Request $request){
        $search = $request->search;
        return redirect()->route('listUser', ['keyword'=>$search]);
    }

}
