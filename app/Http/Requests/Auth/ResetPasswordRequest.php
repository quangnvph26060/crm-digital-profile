<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu tối thiểu là 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu sai'
        ];
    }
}
