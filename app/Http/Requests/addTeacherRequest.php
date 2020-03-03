<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class addTeacherRequest extends FormRequest
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
            'tel'=>'required|min:9|max:11',
            'birth'=>'required',
            'address'=>'required',
            'email'=>'required|unique:users',
            'user'=>'required|min:3|unique:users,username',
            'pass'=>'required',
            'cfpass'=>'required|same:pass',
            'degree'=>'required',
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
        ];
    }
}
