<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreatePutMoneyRequest extends FormRequest
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
            'money' => 'required',
            'image' => 'nullable|image|mimes:png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'money.required' => 'Số tiền cần nạp không được bỏ trống',
            'image.image' => 'Bill sai định dạng',
            'image.mimes' => 'Bill yêu cầu định dạng png, jpg',
            'image.max' => 'Bull yêu cầu tối đa 2M'
        ];
    }
}
