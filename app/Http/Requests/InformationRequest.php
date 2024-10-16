<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
{
    $rules = [
        'config_id' => 'required|integer',
        'ma_phong' => 'required|integer',
        'ma_mucluc' => 'required|integer',
        'hop_so' => 'required|string',
        'ho_so_so' => 'required|string',
        'so_kh_vb' => 'required|string',
        'time_vb' => 'required|date',
        'tac_gia' => 'required|string',
        'noi_dung' => 'required|string',
        'to_so' => 'required|string',
        'ghi_chu' => 'required|string',
    ];


    if ($request->isMethod('post')) {
        $rules['duong_dan'] = 'required|mimes:pdf';
    } else {
        $rules['duong_dan'] = 'mimes:pdf';
    }

    return $rules;
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
            'noi_dung' => 'Nội dung văn bản',
            'to_so' => 'Tờ số',
            'duong_dan' => 'Đường dẫn',
            // 'ghi_chu' => "Ghi chú"
        ];
    }
}
