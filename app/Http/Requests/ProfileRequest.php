<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'config_id' => 'required',
            'ma_mucluc' => 'required',
            'ma_phong' => 'required',
            'hop_so' => 'required',
            'ho_so_so' => 'required',
            'tieu_de_ho_so' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'so_to' => 'required',
            'thbq' => 'required',
            'ghi_chu' => 'nullable',
        ];
    }
    public function messages()
    {
        return __('request.messages');
    }
    public function attributes()
    {
        return [
            'config_id' => 'Mã cơ quan',
            'ma_phong' => 'Mã phông',
            'ma_mucluc' => 'Mã mục lục',
            'hop_so' => 'Hộp số',
            'ho_so_so' => 'Hồ sơ số',
            'so_to' => 'Sồ tờ',
            'thbq' => 'THBQ',
            'tieu_de_ho_so' => "Tiêu đề hồ sơ",
            'date_start' => 'Ngày bắt đầu',
            'date_end' => 'Ngày kết thúc',
            'ghi_chu' => "Ghi chú"
        ];
    }
}
