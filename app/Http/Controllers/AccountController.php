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
use Cloudder;


class AccountController extends Controller
{
    
    // FUNCTION ACCOUNT ADMIN
    public function getList(Request $request){

       if ($request->ajax()) {

            $record = $request->input('_record');
            $accounts = User::paginate($record);
        
        } else {
        	$account = User::select('users.*','student.avatar as st_ava','teacher.avatar as t_ava', 'student.name as st_name', 'teacher.name as t_name')->leftJoin('student','student.id','=','users.id')->leftJoin('teacher','teacher.id','=','users.id')->paginate(10);
        	$tAcc = UserType::all();

        }

        if(!empty($account)) {
            foreach ($account as $key) {
                if($key->id_utype == 2) {
                    $img = Cloudder::show('english-Center/avatar/'.$key->t_ava);
                } elseif ($key->id_utype == 3) {
                    $img = Cloudder::show('english-Center/avatar/'.$key->st_ava);
                } else {
                    $img = Cloudder::show('english-Center/avatar/42gkM_f0Arl_my-avatar_sfxb8c');
                }

                $key->setAttribute('avatar', $img);
            }
        }

    	return view('admin/account/list',['account'=>$account, 'type'=>$tAcc]);
    }

    // FUNCTION ACCOUNT USERS
    
    

}
