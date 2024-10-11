<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required|unique:roles,code|regex:/^[a-zA-Z0-9]+$/',
            'permissions' => 'required|array',
            'permissions.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên quyền là bắt buộc',
            'code.required' => 'Mã quyền là bắt buộc',
            'code.regex' => 'Mã quyền yêu cầu viết liền không dấu',
            'code.unique' => 'Quyền này đã tồn tại',
            'permissions.required' => 'Quyền truy cập là bắt buộc',
            'permissions.array' => 'Quyền tru cập sai định dạng',
            'permissions.*.required' => 'Quyền truy cập là bắt buộc'
        ];
    }
}
