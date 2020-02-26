<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function postLogin(Request $request){
        $validator = \Validator::make($request->all(),[
            'username'=>'required|string|max: 191',
            'password'=>'required|string|max: 191'
        ], 
        [
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'password.required'=>'Vui lòng nhập mật khẩu'

        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['openLogin'=> true, 'errors'=>$validator->errors()]);
        } else {

            if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password])){
                return redirect()->back();    
            } else {
                return redirect()->back()->with(['openLogin'=> true,
                    'message'=>'Tên đăng nhập hoặc mật khẩu không đúng'
                ]);
            }
        }

    }

    public function getLoginAdmin(){
        return view('admin/login');
    }

    public function postLoginAdmin(Request $request){

         $validator = \Validator::make($request->all(),[
                'username'=>'required|string|max: 191',
                'password'=>'required|string|max: 191',
            ], 
            [
                'username.required'=>'Vui lòng nhập thông tin',      
                'password.required'=>'Vui lòng nhập mật khẩu',
            ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['errors'=>$validator->errors()]);

        }

        $credentials = $request->only('username', 'password');
        
        if(Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard');
        }

    }
}
