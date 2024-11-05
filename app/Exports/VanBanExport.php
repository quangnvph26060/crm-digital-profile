<?php

namespace App\Exports;

use App\Models\Config;
use App\Models\HopSoModel;
use App\Models\InformationVb;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VanBanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InformationVb::all()->map(function ($item) {
            $profile = Profile::find($item->profile_id);
            $config = Config::find($profile->config_id);
            $mucluc = MucLuc::find($profile->ma_muc_luc);
            $phong = Phong::find($profile->ma_phong);
            $hopso = HopSoModel::find($profile->hop_so);
            Log::info($phong);
            $data = [
                'ma_co_quan' => $config->agency_code,
                'ma_phong' => $phong->ten_phong,
                'ma_mucluc' => $mucluc->ma_mucluc,
                'hop_so' => $hopso->hop_so,
                'ho_so_so' => $profile->ho_so_so,

            ];

            $attributes = $item->getAttributes();

            $excludedFields = ['id', 'ma_co_quan', 'ma_mucluc', 'hop_so', 'ho_so_so', 'ma_phong', 'profile_id', 'status', 'created_at', 'updated_at'];

            foreach ($attributes as $key => $value) {

                if (!in_array($key, $excludedFields)) {
                    $text = strip_tags($value);
                    $text = html_entity_decode($text);
                    $data[$key] = $text;
                    if($key == 'duong_dan'){
                        $data[$key] = asset('storage/'.$value);
                    }
                }

            }

            return $data;
        });
    }


    public function headings(): array
    {
        // Lấy thông tin các cột trong bảng
        $columns = DB::select("SHOW FULL COLUMNS FROM information_vb");

        // Các cột cần bỏ qua
        $excludedColumns = ['id', 'created_at', 'updated_at', 'profile_id', 'status'];

        // Lấy ghi chú (comment) cho từng cột nếu có, hoặc sử dụng tên cột làm tiêu đề mặc định
        $headings = [];
        foreach ($columns as $column) {
            // Bỏ qua các cột không cần thiết
            if (!in_array($column->Field, $excludedColumns)) {
                $headings[] = $column->Comment ?: $column->Field;
            }
        }

        return $headings;
    }
}
