<?php

namespace App\Imports;

use App\Models\Config;
use App\Models\HopSoModel;
use App\Models\InformationVb;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class InformationVbImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    protected $batchData = []; // Tạm lưu dữ liệu batch

    public function collection(Collection $rows)
    {
        try {
            foreach ($rows as $row) {
                \Log::info($row);
                $coquan = Config::where('agency_code', trim(str_replace(["\n", "\r"], '', $row['ma_co_quan'])))->first();
                if ($coquan) {
                    $phong = Phong::where('ma_phong', $row['ma_phong'])->where('coquan_id', $coquan->id)->first();
                    $mucluc = MucLuc::where('ma_mucluc', $row['ma_muc_luc'])->first();
                    $hopso = HopSoModel::where('hop_so', $row['hop_so'])->first();

                    if ($phong && $mucluc && $hopso) {
                        $profile = Profile::where('config_id', $coquan->id)
                            ->where('ma_muc_luc', $mucluc->id)
                            ->where('ma_phong', $phong->id)
                            ->where('hop_so', $hopso->id)
                            ->where('ho_so_so', $row['ho_so_so'])
                            ->first();

                        if ($profile) {
                            $vanban = InformationVb::where('so_van_ban', $row['so_van_ban'])
                                ->where('ma_phong', $phong->id)
                                ->where('profile_id', $profile->id)
                                ->first();

                            if (!$vanban) {
                                $data = [
                                    'ma_co_quan' => $coquan->id,
                                    'ma_phong' => $phong->id,
                                    'ma_mucluc' => $mucluc->id,
                                    'hop_so' => $hopso->id,
                                    'ho_so_so' => $row['ho_so_so'],
                                    'stt' => $row['stt'],
                                    'so_van_ban' => $row['so_van_ban'],
                                    'ky_hieu_van_ban' => $row['ky_hieu_van_ban'],
                                    'profile_id' => $profile->id,
                                    'ngay_thang_van_ban' => Carbon::createFromFormat('d/m/Y', $row['ngay_thang_van_ban'])->format('Y-m-d'),
                                ];

                                foreach ($row as $key => $value) {
                                    if (Schema::hasColumn('information_vb', $key) && !in_array($key, [
                                        'ma_co_quan', 'ma_phong', 'ma_mucluc', 'hop_so', 'ho_so_so', 'stt',
                                        'so_van_ban', 'ky_hieu_van_ban', 'ngay_thang_van_ban'
                                    ])) {
                                        $data[$key] = $value;
                                    }
                                }

                                if (file_exists($row['duong_dan_file'])) {
                                    $fileName = time() . '/' . $row['ma_co_quan'] . '/' . $row['ma_phong'] . '/' . $row['ma_muc_luc'] . '/' . $row['hop_so'] . '/' . $row['ho_so_so'] . '-' . basename($row['duong_dan_file']);
                                    $filePath = Storage::disk('public')->putFileAs('documents', new \Illuminate\Http\File($row['duong_dan_file']), $fileName);
                                    $data['duong_dan'] = $filePath;
                                }

                                $this->batchData[] = $data;

                                // Khi batch đủ 1000 bản ghi thì insert
                                if (count($this->batchData) >= $this->batchSize()) {
                                    InformationVb::insert($this->batchData);
                                    $this->batchData = []; // Reset batch
                                }
                            }
                        }
                    }
                }
            }

            // Insert các bản ghi còn lại
            if (!empty($this->batchData)) {
                InformationVb::insert($this->batchData);
                $this->batchData = [];
            }
        } catch (\Exception $e) {
            Log::error('Lỗi trong hàm collection: ' . $e->getMessage() . ' at line ' . $e->getLine());
        }
    }

    public function chunkSize(): int
    {
        return 1000; // Đọc file từng khối 1000 dòng
    }

    public function batchSize(): int
    {
        return 1000; // Chèn 1000 bản ghi mỗi lần
    }
}
