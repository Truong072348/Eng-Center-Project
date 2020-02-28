<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class addCourseRequest extends FormRequest
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
            'name'=>'required|min:2|max:191',
            'shortdesc'=>'required',
            'txtContent'=>'required',
            'price'=>'required|numeric',
            'avatar'=>'required',
            'date_start'=>'required',
            'idteacher'=>'required' 
        ];
    }

    public function messages()
    {
        return [
            
            'name.required'=>'Vui lòng nhập tên khóa học',
            'name.min'=>'Tên khóa học quá ngắn',
            'name.max'=>'Tên khóa học quá dài',
            'shortdesc.required'=>'Vui lòng nhập thông tin',
            'txtContent.required'=>'Vui lòng nhập thông tin',
            'price.required'=>'Vui lòng nhập học phí',
            'price.numeric'=>'Học phí phải là số',
            'avatar.required' => 'Chon hinh anh',
            'date_start.required'=>'Vui lòng chọn ngày bắt đầu',
            'idteacher'=>'Vui lòng chọn giáo viên'
        ];
    }
}
