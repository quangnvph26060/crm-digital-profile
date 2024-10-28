<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TemplateFormRequest extends FormRequest
{/**
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
    public function rules(Request $request)
{
    $rules = [
        'name' => 'required|string|max:255',
        'template_form' => 'required|string',
    ];

    return $rules;
}


    public function messages(){
        return __('request.messages');
    }

    public function attributes(){
        return [
            'name' => 'Tên Form',
            'template_form' => 'Template Form',
        ];
    }
}
