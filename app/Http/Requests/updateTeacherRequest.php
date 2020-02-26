<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class updateTeacherRequest extends FormRequest
{
    
    protected function failedValidation(Validator $validator)
    {
        if($this->input('pass') != '' || $this->input('pass') != '' || $this->input('cfpass') != ''){
            return redirect()->back()->with(['errors'=>$validator->errors(), 'passerr'=>true]);
        } else {
             return redirect()->back()->with(['errors'=>$validator->errors()]);
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
            'name'=>'required|min:2|max:191',
            'tel'=>'required|min:9|max:11',
            'birth'=>'required|date',
            'address'=>'required|max: 191|string',
            'cfpass'=>'same:pass|max: 191',
            'degree'=>'required|max: 191|string', 
        ];
    }

    public function messages()
    {
        return [
            
            'name.required'=>'Vui lòng nhập thông tin',
            'name.min'=>'Tên quá ngắn',
            'name.max'=>'Tên quá dài',
            'tel.required'=>'Vui lòng nhập số điện thoại',
            'tel.min'=>'Số điện thoại không hợp lệ',
            'tel.max'=>'Số điện thoại không hợp lệ',
            'birth.required'=>'Vui lòng nhập thông tin',
            'address.required'=>'Vui lòng nhập địa chỉ',
            'cfpass.same'=>'Xác nhận lại mật khẩu',
            'degree.required'=>'Vui lòng nhập thông tin'
        ];
    }
}
