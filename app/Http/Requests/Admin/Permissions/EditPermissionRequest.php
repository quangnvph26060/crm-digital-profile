<?php

namespace App\Http\Requests\Admin\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class EditPermissionRequest extends FormRequest
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
            'code' => 'required|regex:/^[ a-zA-Z0-9]+$/'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên quyền truy cập là bắt buộc',
            'code.required' => 'Mã quyền truy cập là bắt buộc',
            'code.regex' => 'Mã quyền truy cập yêu cầu không dấu, chữ cái từ a-z 0-9 và chứa dấu -',
        ];
    }
}
