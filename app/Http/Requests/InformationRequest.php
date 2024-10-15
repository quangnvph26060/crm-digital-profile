<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
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
            //public static $rules = [
        'config_id' => 'required|exists:configs,id',
        'ma_phong' => 'required|integer',
        'ma_mucluc' => 'required|integer',
        'hop_so' => 'required|integer',
        'ho_so_so' => 'required|integer',
        'so_kh_vb' => 'required|string',
        'time_vb' => 'required|date',
        'tac_gia' => 'required|string',
        'author' => 'nullable|integer',
        'noi_dung' => 'required|string',
        'to_so' => 'required|string',
        'ghi_chu' => 'required|string',
        'duong_dan' => 'required|string',
        'filepdf' =>'required|string',
    ];

    }

    public function messages(){
        return __('request.messages');
    }

    public function attributes(){
        return [
            'config_id' => 'Mã cơ quan',
            'ma_phong' => 'Mã phông',
            'ma_mucluc' =>'Mã mục lục',
            'hop_so' => 'Hộp số',
            'ho_so_so' => 'Hồ sơ số',
            'so_kh_vb' => 'Số và ký hiệu văn bản',
            'time_vb' => 'Ngày tháng văn bản',
            'tac_gia' => 'Tác giả văn bản',
            'author' => 'Tác giả văn bản',
            'noi_dung' => 'Nội dung văn abnr',
            'to_so' => 'Tờ số',
            'duong_dan' => 'Đường dẫn'
        ];
    }
}
