<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
    $rules = [
        'importexcel' => 'required|file|mimes:xlsx,xls',
    ];


    return $rules;
}


    public function messages(){
        return __('request.messages');
    }

    public function attributes(){
        return [
            'importexcel' => 'File'
        ];
    }
}
