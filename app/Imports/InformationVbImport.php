<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\HopSoModel;
use App\Models\InformationVb;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithMapping;
class InformationVbImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, WithLimit
{
    // private $rowCount = 0; 
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function limit(): int
    {
        return 20; // Giới hạn số dòng nhập là 20
    }

    public function model(array $row)
    {
        //  dd($row);
        // if ($this->rowCount >= 20) {
        //     return null;
        // }
        try {
            $coquan = Config::where('agency_code', trim(str_replace(["\n", "\r"], '', $row['ma_co_quan'])))->first();
            if ($coquan) {
                $phong = Phong::where('ma_phong', $row['ma_phong'])->where('coquan_id', $coquan->id)->first();
                // dd($phong);
                $mucluc = MucLuc::where('ma_mucluc', $row['ma_muc_luc'])->first();
                $hopso = HopSoModel::where('hop_so', $row['hop_so'])->first();
                //    Log::info($hopso);
                // dd($phong);
                if ($phong && $mucluc && $hopso ) {
                    $profile = Profile::where('config_id', $coquan->id)->where('ma_muc_luc', $mucluc->id)
                        ->where('hop_so', $hopso->id)->where('ho_so_so', $row['ho_so_so'])->first();
                    if ($profile) {
                        $vanban = InformationVb::where('so_van_ban', $row['so_van_ban'])->where('ma_phong', $phong->id)->where('profile_id', $profile->id)->first();
                        // dd($vanban);
                        if (!$vanban) {

                            $vanbannew = new InformationVb();
                            $vanbannew->ma_co_quan = $coquan->id;
                            $vanbannew->ma_phong = $phong->id;
                            $vanbannew->ma_mucluc = $mucluc->id;
                            $vanbannew->hop_so = $hopso->id;
                            $vanbannew->ho_so_so = $row['ho_so_so'];
                            $vanbannew->stt = $row['stt'];
                            $vanbannew->so_van_ban = (int)$row['so_van_ban'];
                            $vanbannew->ky_hieu_van_ban = $row['ky_hieu_van_ban'];
                            $vanbannew->profile_id = $profile->id;
                            $vanbannew->ngay_thang_van_ban = Carbon::createFromFormat('d/m/Y', $row['ngay_thang_van_ban'])->format('Y-m-d');
                            foreach ($row as $key => $value) {

                                if (!Schema::hasColumn('information_vb', $key) || $key == 'ma_co_quan' || $key == 'ma_phong' || $key == 'ma_mucluc' || $key == 'hop_so' || $key == 'ho_so_so' ||$key == 'stt' || $key == 'so_van_ban' || $key == 'ky_hieu_van_ban' || $key == 'ngay_thang_van_ban') {
                                    continue;
                                }
                                $vanbannew->$key = $value;

                                // Log::info($key);
                                // if($key == 'ngay_thang_van_ban'){
                                //     $vanbannew->$key = Carbon::createFromFormat('d/m/Y', $row[$key])->format('Y-m-d');
                                // }
                                $localPath = $row['duong_dan_file'];
                                if (file_exists($localPath)) {
                                    // Tạo tên file duy nhất
                                    $fileName = time() . '/' . $row['ma_co_quan'] . '/' . $row['ma_phong'] . '/' . $row['ma_muc_luc'] . '/' . $row['hop_so'] . '/' . $row['ho_so_so'] . '-' . basename($localPath);
                                    // Lưu file vào storage
                                    $filePath = Storage::disk('public')->putFileAs('documents', new \Illuminate\Http\File($localPath), $fileName);
                                    // Lưu đường dẫn vào cơ sở dữ liệu
                                    $vanbannew->duong_dan =  $filePath; // Lưu đường dẫn file
                                }
                            }
                            $vanbannew->save();
                        } else {
                            Log::info('k có 3');
                        }
                    } else {
                        Log::info('k có 2');
                    }
                } else {
                    Log::info('k có 1');
                }
            } else {
                Log::info('k có 0');
            }
        } catch (\Exception $e) {

            Log::error('Lỗi trong hàm model: ' . $e->getMessage() . ' at line ' . $e->getLine());
        }
    }
    public function chunkSize(): int
    {
        return 1000; // Số dòng dữ liệu mỗi lần xử lý
    }
    public function batchSize(): int
    {
        return 1000;
    }
}
