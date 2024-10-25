<?php

namespace App\Exports;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProfileExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $profiles = Profile::with('config')->get();

        $profiles->transform(function ($profile) {
            $profile->config_id = $profile->config->agency_code;
            $profile->ngay_bat_dau = date('d/m/Y', strtotime($profile->ngay_bat_dau)) . ' - ' . date('d/m/Y', strtotime($profile->ngay_ket_thuc));
            unset($profile->ngay_ket_thuc); 
            return $profile;
        });

        return $profiles->makeHidden(['id', 'created_at', 'updated_at']);
    }

    public function headings(): array
    {
        // Lấy thông tin các cột trong bảng
        $columns = DB::select("SHOW FULL COLUMNS FROM profiles");
    
        // Các cột cần bỏ qua
        $excludedColumns = ['id', 'created_at', 'updated_at'];
    
        $headings = [];
        $seenHeadings = []; // Mảng để lưu trữ các tiêu đề đã xuất hiện
    
        foreach ($columns as $column) {
            // Bỏ qua các cột không cần thiết
            if (!in_array($column->Field, $excludedColumns)) {
                $heading = $column->Comment ?: $column->Field;
                
                // Kiểm tra xem tiêu đề đã xuất hiện chưa
                if (!in_array($heading, $seenHeadings)) {
                    $headings[] = $heading;
                    $seenHeadings[] = $heading; // Đánh dấu tiêu đề đã xuất hiện
                }
            }
        }
    
        return $headings;
    }
}
