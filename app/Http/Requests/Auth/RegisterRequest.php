<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'shop_name' => 'required|min:6',
            'email' => 'email|required|unique:users,email',
            'full_name' => 'required|min:6',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone', //digits:10',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => 'Tên shop/công ty là bắt buộc',
            'shop_name.min' => 'Tên shop/công ty tối thiểu 6 ký tự',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'email.email' => 'Địa chỉ Email sai định dạng',
            'email.required' => 'Địa chỉ Email là bắt buộc',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.unique' => 'Số điện thoại đã tồn tại', 
            'phone.regex' => 'Số điện thoại sai định dạng',
            'phone.min' => 'Số điện thoại tối thiểu 10 ký tự',
            'full_name.required' => 'Họ tên là bắt buộc',
            'full_name.min' => 'Họ tên tối thiểu 6 ký tự',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu sai',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự'
        ];
    }
}
