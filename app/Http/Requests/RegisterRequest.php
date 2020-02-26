<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class registerRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with(['openRegister'=> true, 'regfail'=>true]);
        }
    }
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
            'user'=>'required|unique:users,username',
            'pass'=>'required|min: 3',
            'name'=>'required',
            'phone'=>'required|min: 9|max: 11',
            'address'=>'required',
            'email'=>'required|unique:users,email'
        ];
    }

    public function massage()
    {
        return [
            'user.unique'=>'Tên đăng nhập đã tồn tại',
            'user.required'=>'Vui lòng nhập tên tài khoản',
            'pass.required'=>'Vui lòng nhập mật khẩu',
            'pass.min'=>'Mật khẩu quá ngắn',
            'name.required'=>'Vui lòng nhập tên',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.min'=>'Số điện thoại không hợp lệ',
            'phone.max'=>'Số điện thoại không hợp lệ',
            'address.required'=>'Vui lòng nhập địa chỉ',
            'email.required'=>'Vui lòng nhập email',
            'email.exists'=>'exists.connection.users.email'
        ];
    }
}
