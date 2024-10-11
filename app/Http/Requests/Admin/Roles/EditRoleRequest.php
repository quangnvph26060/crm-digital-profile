<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class EditRoleRequest extends FormRequest
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
            'permissions' => 'required|array',
            'permissions.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên quyền là bắt buộc',
            'permissions.required' => 'Quyền truy cập là bắt buộc',
            'permissions.array' => 'Quyền tru cập sai định dạng',
            'permissions.*.required' => 'Quyền truy cập là bắt buộc'
        ];
    }
}
