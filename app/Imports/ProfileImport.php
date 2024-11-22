<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\HopSoModel;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProfileImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row)
    {
        try {
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

                    $existingMucLuc = new MucLuc();
                    $existingMucLuc->ten_mucluc   = $row['ma_muc_luc'];
                    $existingMucLuc->ma_mucluc    = $row['ma_muc_luc'];
                    $existingMucLuc->phong_id    = $existingPhong->id;
                    $existingMucLuc->save();

                    $existingHopSo = new HopSoModel();
                    $existingHopSo->coquan_id   =  $existingCoQuan->id;
                    $existingHopSo->phong_id    =  $existingPhong->id;
                    $existingHopSo->mucluc_id    = $existingMucLuc->id;
                    $existingHopSo->hop_so    = (substr($row['hop_so'], 0, 1) === '=') ? "'" . $row['hop_so'] : $row['hop_so'];
                    $existingHopSo->save();

                    //    \Log::info('mã cơ quan chưa tồn tại');
                }
            } else {
                  //Log::info('mã cơ quan tồn tại');
                $phongFind = Phong::where('coquan_id', $existingCoQuan->id)->where('ma_phong', $row['ma_phong'])->first();
                // \Log::info($row['ma_phong']);
                if (!$phongFind) {
                      //Log::info('mã cơ quan tồn tại nhưng mã phông không tồn tại');
                    $existingPhong = new Phong();
                    $existingPhong->ten_phong   = $row['ma_phong'];
                    $existingPhong->ma_phong    = $row['ma_phong'];
                    $existingPhong->coquan_id   = $existingCoQuan->id;
                    $existingPhong->save();

                    $existingMucLuc = new MucLuc();
                    $existingMucLuc->ten_mucluc     = $row['ma_muc_luc'];
                    $existingMucLuc->ma_mucluc      = $row['ma_muc_luc'];
                    $existingMucLuc->phong_id       = $existingPhong->id;
                    $existingMucLuc->save();

                    $existingHopSo = new HopSoModel();
                    $existingHopSo->coquan_id   =  $existingCoQuan->id;
                    $existingHopSo->phong_id    =  $existingPhong->id;
                    $existingHopSo->mucluc_id    = $existingMucLuc->id;
                    $existingHopSo->hop_so    = (substr($row['hop_so'], 0, 1) === '=') ? "'" . $row['hop_so'] : $row['hop_so'];
                    $existingHopSo->save();

                } else {
                     // Log::info('phong ton tai');
                    $mucluc  = MucLuc::where('phong_id', $phongFind->id)->where('ma_mucluc', $row['ma_muc_luc'])->first();
                    if (!$mucluc) {
                        //   \Log::info(' mã mục lục không tồn tại ');
                        $existingMucLuc = new MucLuc();
                        $existingMucLuc->ten_mucluc     = $row['ma_muc_luc'];
                        $existingMucLuc->ma_mucluc      = $row['ma_muc_luc'];
                        $existingMucLuc->phong_id       = $phongFind->id;
                        $existingMucLuc->save();

                        $existingHopSo = new HopSoModel();
                        $existingHopSo->coquan_id   =  $existingCoQuan->id;
                        $existingHopSo->phong_id    =  $phongFind->id;
                        $existingHopSo->mucluc_id    = $existingMucLuc->id;
                        $existingHopSo->hop_so    = (substr($row['hop_so'], 0, 1) === '=') ? "'" . $row['hop_so'] : $row['hop_so'];
                        $existingHopSo->save();
                         
                        $existingHoSoQuery = false;


                    } else {
                        //Log::info('mucluc ton tai');
                        $existingHopSo  = HopSoModel::where('coquan_id', $existingCoQuan->id)
                                        ->where('phong_id', $phongFind->id)
                                        ->where('mucluc_id', $mucluc->id)
                                        ->where('hop_so',(substr($row['hop_so'], 0, 1) === '=') ? "'" . $row['hop_so'] : $row['hop_so'])->first();
                                       
                        if(!$existingHopSo){
                            //  \Log::info(' hộp số không tồn tại');
                            $existingHopSo = new HopSoModel();
                            $existingHopSo->coquan_id       = $existingCoQuan->id;
                            $existingHopSo->phong_id        = $phongFind->id;
                            $existingHopSo->mucluc_id       = $mucluc->id;
                            $existingHopSo->hop_so          = (substr($row['hop_so'], 0, 1) === '=') ? "'" . $row['hop_so'] : $row['hop_so'];
                            $existingHopSo->save();
                        }else{
                               //Log::info(' hộp số tồn tại');
                          
                            if ($existingCoQuan && $phongFind && $mucluc && $existingHopSo) {
                              
                                $existingHoSoQuery = Profile::where('config_id', $existingCoQuan->id)
                                    ->where('ma_phong', $phongFind->id)
                                    ->where('ma_muc_luc', $mucluc->id)
                                    ->where('hop_so', $existingHopSo->id)
                                    ->where('ho_so_so',$row['ho_so_so'])->first();
                                  //    \Log::info($existingHoSoQuery);
                                //  \Log::info($existingCoQuan->id);
                                //  \Log::info($phongFind->id);
                                //  \Log::info($mucluc->id);
                                //  \Log::info($existingHopSo->hop_so); 
                                //  \Log::info($row['ho_so_so']);
                            }
                           
                        }
                    }
                }
            }
            // if(!$existingHoSoQuery){
            //     return;
            // }
            // if (array_key_exists('ngay_thang_bd_kt', $row)) {
            //     $ngay_thang_arr = explode('-', $row['ngay_thang_bd_kt']);
            // } else {
            //     $ngay_thang_arr = explode('-', $row['ngay_thang_bd']);
            // }

            if (array_key_exists('ngay_thang_bd_kt', $row)) {
                $dateString = $row['ngay_thang_bd_kt'];
            } else {
                $dateString = $row['ngay_thang_bd'];
            }
         
            if (strpos($dateString, '-') !== false) {
                $ngay_thang_arr = explode('-', $dateString);
            }else{
                if (is_numeric($dateString)) {
                    $ngay_thang  = Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_thang_bd_kt'])->format('Y-m-d'))->format('d/m/Y');
                } else {
                    $ngay_thang = $row['ngay_thang_bd_kt']; // Nếu không phải số, coi như đã là ngày tháng hợp lệ
                }
                $ngay_thang_arr = [$ngay_thang];
            }
            
            if (is_array($ngay_thang_arr)) {
                $ngay_bat_dau = date_create_from_format('d/m/Y', trim($ngay_thang_arr[0]));
                if(count($ngay_thang_arr) === 2){
                    $ngay_ket_thuc = date_create_from_format('d/m/Y', trim($ngay_thang_arr[1]));
                }else{
                    $ngay_ket_thuc = date_create_from_format('d/m/Y', trim($ngay_thang_arr[0]));
                }
                Profile::unguard();
                $data = [
                    'config_id'        => $existingCoQuan->id,
                    'ma_phong'         => $existingPhong->id ?? $phongFind->id,
                    'ma_muc_luc'       => $existingMucLuc->id ?? $mucluc->id,
                    'hop_so'           => $existingHopSo->id ?? null,
                    'ho_so_so'         => $row['ho_so_so'] ?? null,
                    'tieu_de_ho_so'    => $row['tieu_de_ho_so'] ?? null,
                    'ngay_bat_dau'     => $ngay_bat_dau ? $ngay_bat_dau->format('Y-m-d') : null,
                    'ngay_ket_thuc'    => $ngay_ket_thuc ? $ngay_ket_thuc->format('Y-m-d') : null,
                    'so_to'            => $row['so_to'] ?? null,
                    'thbq'             => $row['thbq'] ?? null,
                    'ghi_chu'          => $row['ghi_chu'] ?? null,
                ];
               
                $collection1 = collect($data);
                $collection2 = collect($row);


                $mergedArray = $collection2->merge($collection1);

                $arrayData = json_decode($mergedArray, true);

                $fillableFields = (new \App\Models\Profile())->getFillable();

                $filteredData = array_intersect_key($arrayData, array_flip($fillableFields));
            
                $filteredData['config_id'] = $mergedArray['config_id'];  
                $result = new Profile();
                // nếu mã cơ quan, phông, mục lục hộp số, hồ sơ số đã có rồi thì thôi
                if($existingHoSoQuery){
                    $filteredData = [];
                }
                $result->fill($filteredData);
                $result->save();

                return $result;
            }
        } catch (\Exception $e) {
            // Bắt lỗi và ghi log dòng gây ra lỗi
            Log::error('Lỗi trong hàm model: ' . $e->getMessage() . ' at line ' . $e->getLine());
        }
    }
}
