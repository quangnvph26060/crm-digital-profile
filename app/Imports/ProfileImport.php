<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\Phong;
use App\Models\Profile;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class ProfileImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // \Log::info($row);
            $existingCoQuan = Config::where('agency_code', $row['ma_co_quan'])->first();
            
            if (!$existingCoQuan) {
                if (!empty($row['ma_co_quan'])) {
                    $existingCoQuan = new Config();
                    $existingCoQuan->agency_name = $row['ma_co_quan'];
                    $existingCoQuan->agency_code = $row['ma_co_quan'];
                    $existingCoQuan->save();
    
                    $existingPhong = new Phong();
                    $existingPhong->ten_phong = $row['ma_phong'];
                    $existingPhong->ma_phong = $row['ma_phong'];
                    $existingPhong->coquan_id = $existingCoQuan->id;
                    $existingPhong->save();
                    // \Log::info('mã cơ quan chưa tồn tại');
    
                }
               
            } else {
                // \Log::info('mã cơ quan tồn tại');
                $phongFind = Phong::where('coquan_id', $existingCoQuan->id)->where('ma_phong', $row['ma_phong'])->first();
                // \Log::info($row['ma_phong']);
                if (!$phongFind) {
                    // \Log::info('mã cơ quan tồn tại nhưng mã phông không tồn tại');
                    $existingPhong = new Phong();
                    $existingPhong->ten_phong = $row['ma_phong'];
                    $existingPhong->ma_phong = $row['ma_phong'];
                    $existingPhong->coquan_id = $existingCoQuan->id;
                    $existingPhong->save();
                   
                }
              
            }
            $ngay_thang_arr = explode('-', $row['ngay_thang_bd_kt']);
            if (count($ngay_thang_arr) === 2) {
                $ngay_bat_dau = date_create_from_format('d/m/Y', trim($ngay_thang_arr[0]));
                $ngay_ket_thuc = date_create_from_format('d/m/Y', trim($ngay_thang_arr[1]));
                return new Profile([
                    'config_id' => $existingCoQuan->id,
                    'ma_phong' => $existingPhong->id ?? $phongFind->ma_phong,
                    'ma_muc_luc' => $row['ma_muc_luc'],
                    'hop_so' => $row['hop_so'],
                    'ho_so_so' => $row['ho_so_so'],
                    'tieu_de_ho_so' => $row['tieu_de_ho_so'],
                    'ngay_bat_dau' => $ngay_bat_dau->format('Y-m-d'),
                    'ngay_ket_thuc' => $ngay_ket_thuc->format('Y-m-d'),
                    'so_to' => $row['so_to'],
                    'thbq' => $row['thbq'],
                    'ghi_chu' => $row['ghi_chu'],
                ]);
            }
        } catch (\Exception $e) {
            // Bắt lỗi và ghi log dòng gây ra lỗi
            \Log::error('Lỗi trong hàm model: ' . $e->getMessage() . ' at line ' . $e->getLine());
        }
    }
}