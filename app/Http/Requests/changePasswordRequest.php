<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class changePasswordRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $page = 2;

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator)->with(['page'=>$page]);
        }
    }

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
            'pass'=>'required',
            'newpass'=>'required',
            'cfpass'=>'required|same:newpass',
        ];
    }

    public function massage()
    {
        return [
            'pass.required'=>'Vui lòng nhập mật khẩu',
            'newpass.required'=>'Vui lòng nhập mật khẩu mới',
            'cfpass.required'=>'Vui lòng xác nhận lại mật khẩu',
            'cfpass.same'=>'Mật khẩu không chính xác'
        ];
    }
}
