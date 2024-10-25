<?php

namespace App\Exports;

use App\Models\Config;
use App\Models\InformationVb;
use App\Models\MucLuc;
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
            $profile = Profile::find($item->profile_id );
            $config = Config::find($profile->config_id);
            $mucluc = MucLuc::find($profile->ma_muc_luc);
            Log::info($mucluc);
            $data = [
                'ma_co_quan' => $config->agency_code,
                'ma_muc_luc' => $mucluc->ma_mucluc,
                // 'hop_so' => $profile->hop_so,
                // 'ho_so_so' => $profile->ho_so_so,
            ];
            return $data;
        });
    }

    public function headings(): array
{
    // Lấy thông tin các cột trong bảng
    $columns = DB::select("SHOW FULL COLUMNS FROM information_vb");

    // Các cột cần bỏ qua
    $excludedColumns = ['id', 'created_at', 'updated_at'];

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
