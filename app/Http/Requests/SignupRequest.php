<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'=> [
              'required',
              'regex:/^[a-z][a-z0-9_\.]{4,20}$/'
            ],

            'password'=>'required',
        ];
    }

    public function messages() 
    {
        'username.required'=>'Vui lòng nhập tên tài khoản',
        'username.regex'=>'Tên đăng nhập không hợp lệ',
        'password.required'=>'Vui lòng nhập mật khẩu'
    }

}
