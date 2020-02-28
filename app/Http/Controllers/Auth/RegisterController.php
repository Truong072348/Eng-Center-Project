<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Student;
use App\User;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        
        $validator = \Validator::make($request->all(),[
            'user'=>['required','unique:users,username','max:191'],
            'pass'=>['required','min: 4','max:191'],
            'name'=>['required','max:191'],
            'phone'=>['required','min: 9','max: 11'],
            'address'=>['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ],
        [
            'user.unique'=>'Tên đăng nhập đã tồn tại',
            'user.required'=>'Vui lòng nhập tên tài khoản',
            'user.max'=>'Tên quá dài',
            'pass.required'=>'Vui lòng nhập mật khẩu',
            'pass.min'=>'Mật khẩu quá ngắn',
            'pass.max'=>'Mật khẩu quá dài',
            'name.required'=>'Vui lòng nhập tên',
            'name.max'=>'tên quá dài',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.min'=>'Số điện thoại không hợp lệ',
            'phone.max'=>'Số điện thoại không hợp lệ',
            'address.required'=>'Vui lòng nhập địa chỉ',
            'address.string'=>'',
            'address.max'=>'Địa chỉ quá dài',
            'email.required'=>'Vui lòng nhập email',
            'email.max'=>'Email quá dài',
            'email.string'=>'',
            'email.unique'=>'Email đã tồn tại',     
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(['openRegister'=> true, 'errors'=>$validator->errors(), 'regfail'=>true]);
        } else {

            $id = mt_rand(100000,999999);
            while (User::where('id', $id)->exists()){
                $id = mt_rand(100000,999999);
            }

            User::create([
                'email' => $request->email,
                'username' => $request->user,
                'password' => Hash::make($request->pass),
                'id_utype' => 3,
                'account_balance' => 0,
                'id' => $id,
            ]);

            Student::create([
                'name' => $request->name,
                'phone'=> $request->phone,
                'address' => $request->address,
                'id' => $id,
                'gender' => 'Nam',
                'avatar' => 'male-define_iogxda',
                'birthday' => Carbon::now(),
            ]);

            return redirect($this->redirectPath())->with(['openSuccessReg'=>true, 'regSuccess'=>'Đăng ký thành công. Đăng nhập ngay!!']);
        }
    }


}
