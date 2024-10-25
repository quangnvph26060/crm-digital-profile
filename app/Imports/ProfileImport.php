<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\Phong;
use App\Models\Profile;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ProfileImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            //  \Log::info($row);
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
                //    \Log::info('mã cơ quan chưa tồn tại');
                }
            } else {
              //  \Log::info('mã cơ quan tồn tại');
                $phongFind = Phong::where('coquan_id', $existingCoQuan->id)->where('ma_phong', $row['ma_phong'])->first();
                // \Log::info($row['ma_phong']);
                if (!$phongFind) {
                  //  \Log::info('mã cơ quan tồn tại nhưng mã phông không tồn tại');
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
                Profile::unguard();
                $data = [
                    'config_id' => $existingCoQuan->id,
                    'ma_phong' => $existingPhong->id ?? $phongFind->ma_phong,
                    'ma_muc_luc' => $row['ma_muc_luc'] ?? null,
                    'hop_so' => $row['hop_so'] ?? null,
                    'ho_so_so' => $row['ho_so_so'] ?? null,
                    'tieu_de_ho_so' => $row['tieu_de_ho_so'] ?? null,
                    'ngay_bat_dau' => $ngay_bat_dau ? $ngay_bat_dau->format('Y-m-d') : null,
                    'ngay_ket_thuc' => $ngay_ket_thuc ? $ngay_ket_thuc->format('Y-m-d') : null,
                    'so_to' => $row['so_to'] ?? null,
                    'thbq' => $row['thbq'] ?? null,
                    'ghi_chu' => $row['ghi_chu'] ?? null,
                ];
             
                $collection1 = collect($data);
                $collection2 = collect($row);

              
                $mergedArray = $collection1->merge($collection2);
             
                $arrayData = json_decode($mergedArray, true);
               
               $fillableFields = (new \App\Models\Profile())->getFillable();

               $filteredData = array_intersect_key($arrayData, array_flip($fillableFields));

                
                $result = new Profile();
                $result->fill($filteredData);
                $result->save();
               
                return $result;
            }
        } catch (\Exception $e) {
            // Bắt lỗi và ghi log dòng gây ra lỗi
            \Log::error('Lỗi trong hàm model: ' . $e->getMessage() . ' at line ' . $e->getLine());
        }
    }
}
