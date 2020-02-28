<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class addLessonRequest extends FormRequest
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
            'name'=>'required|min:2|max:100|string',
            'video'=>'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
            'document'=>'required|mimes:jpeg,png,jpg,zip,pdf|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Vui lòng nhập tên bài giảng',
            'name.max'=>'Tên quá dài',
            'name.min'=>'Tên quá ngắn',
            'video.required'=>'Vui lòng thêm video',
            'video.mimes' => 'File không hợp lệ (mp4,ogx,oga,ogv,ogg,webm)',
            'document.required'=>'Vui lòng thêm tài liệu',
            'document.mimes' => 'File không hợp lệ (.doc, .docx, jpeg, png, jpg, zip, pdf)'
        ];
    }
}
