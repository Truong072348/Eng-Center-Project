<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class updateProfileRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException(response()->json($validator->errors(), 422));
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
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
            'name'=>'required|min:2|max:100',
            'phone'=>'required|min:9|max:11',
            'date'=>'required',            
        ];
    }

    public function messages()
    {
        return [
            
            'name.required'=>'Họ tên không được để trống',
            'name.min'=>'Tên quá ngắn',
            'name.max'=>'Tên quá dài',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.min'=>'Số điện thoại không hợp lệ',
            'phone.max'=>'Số điện thoại không hợp lệ',
            'date.required'=>'Vui lòng nhập thông tin',
        ];
    }
}
