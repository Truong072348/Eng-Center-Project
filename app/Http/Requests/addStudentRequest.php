<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class addStudentRequest extends FormRequest
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
            'name'=>'required|min:2|max:100',
            'phone'=>'required|min:9|max:11',
            'birthday'=>'required',
            'address'=>'required',
            'email'=>'required|unique:users',
            'username'=>'required|min:3|unique:users,username',
            'password'=>'required',
            'cfpass'=>'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            
            'name.required'=>'Vui lòng nhập họ tên',
            'name.min'=>'Tên quá ngắn',
            'name.max'=>'Tên quá dài',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.min'=>'Số điện thoại không hợp lệ',
            'phone.max'=>'Số điện thoại không hợp lệ',
            'birthday.required'=>'Vui lòng nhập thông tin',
            'email.required'=>'Vui lòng nhập email',
            'email.unique'=>'Email đã tồn tại',
            'address.required'=>'Vui lòng nhập địa chỉ',
            'username.required'=>'Vui lòng nhập tên đăng nhập',
            'username.min'=>'Tên đăng nhập quá ngắn',
            'username.unique'=>'Tên tài khoản đã tồn tại',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'cfpass.required'=>'Vui lòng xác nhận lại mật khẩu',
            'cfpass.same'=>'Xác nhận lại mật khẩu',
        ];
    }
}
