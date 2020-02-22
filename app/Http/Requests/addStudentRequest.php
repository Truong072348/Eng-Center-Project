<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'date'=>'required',
            'address'=>'required',
            'email'=>'required|unique:users',
            'user'=>'required|min:3|unique:users,username',
            'pass'=>'required',
            'cfpass'=>'required|same:pass',
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
        ];
    }
}
