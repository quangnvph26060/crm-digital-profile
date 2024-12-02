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
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ToModel;
class InformationVbImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    protected $batchData = []; // Tạm lưu dữ liệu batch

    public function model(array $row)
    {
        try {
            \DB::disableQueryLog();
            if (empty(trim($row['so_van_ban'])) || empty(trim($row['ma_co_quan'])) || empty(trim($row['ma_muc_luc'])) || empty(trim($row['ma_phong'])) || empty(trim($row['hop_so']))) {
                return null;
            }
            $coquan = Config::where('agency_code', trim(str_replace(["\n", "\r"], '', $row['ma_co_quan'])))->first();
            if ($coquan) {
                $phong = Phong::where('ma_phong', $row['ma_phong'])->where('coquan_id', $coquan->id)->first();
                if ($phong) {
                    $mucluc = MucLuc::where('ma_mucluc', $row['ma_muc_luc'])->where('phong_id', $phong->id)->first();
                    if ($mucluc) {
                        $hopso = HopSoModel::where('hop_so', $row['hop_so'])
                            ->where('coquan_id', $coquan->id)
                            ->where('phong_id', $phong->id)
                            ->where('mucluc_id', $mucluc->id)->first();
                        if ($hopso) {
                            $hososo = (substr($row['ho_so_so'], 0, 1) === '=') ? "'" . $row['ho_so_so'] : $row['ho_so_so'];
                            $profile = Profile::where([
                                ['config_id', '=', $coquan->id],
                                ['ma_muc_luc', '=', $mucluc->id],
                                ['ma_phong', '=', $phong->id],
                                ['hop_so', '=', $hopso->id],
                                ['ho_so_so', '=', $hososo],
                            ])->first();
                            if ($profile) {
                                $vanban = InformationVb::where('so_van_ban', $row['so_van_ban'])
                                    ->where('ma_co_quan', $coquan->id)
                                    ->where('ma_phong', $phong->id)
                                    ->where('ma_mucluc', $mucluc->id)
                                    ->where('hop_so', $hopso->id)
                                    ->first();
                                if (!$vanban) {
                                    $data = [
                                        'ma_co_quan' => $coquan->id,
                                        'ma_phong' => $phong->id,
                                        'ma_mucluc' => $mucluc->id,
                                        'hop_so' => $hopso->id,
                                        'ho_so_so' => $hososo,
                                        'stt' => $row['stt'],
                                        'so_van_ban' => (substr($row['so_van_ban'], 0, 1) === '=') ? "'" . $row['so_van_ban'] : $row['so_van_ban'],
                                        'ky_hieu_van_ban' => $row['ky_hieu_van_ban'],
                                        'profile_id' => $profile->id,
                                        'ngay_thang_van_ban' => Carbon::createFromFormat('d/m/Y', $row['ngay_thang_van_ban'])->format('Y-m-d'),
                                        'duong_dan' => $row['duong_dan_file'],
                                    ];
                                    // Log::info('data: ' . $data);
                                    // Thêm các trường dữ liệu còn lại vào $data
                                    foreach ($row as $key => $value) {
                                        if (Schema::hasColumn('information_vb', $key) && !in_array($key, [
                                            'ma_co_quan',
                                            'ma_phong',
                                            'ma_mucluc',
                                            'hop_so',
                                            'ho_so_so',
                                            'stt',
                                            'so_van_ban',
                                            'ky_hieu_van_ban',
                                            'ngay_thang_van_ban'
                                        ])) {
                                            $data[$key] = $value;
                                        }
                                    }
    
                                    // Xử lý tệp đính kèm
                                    // if (file_exists($row['duong_dan_file'])) {
                                    //     $fileName = time() . '/' . $row['ma_co_quan'] . '/' . $row['ma_phong'] . '/' . $row['ma_muc_luc'] . '/' . $row['hop_so'] . '/' . $row['ho_so_so'] . '-' . basename($row['duong_dan_file']);
                                    //     $filePath = Storage::disk('public')->putFileAs('documents', new \Illuminate\Http\File($row['duong_dan_file']), $fileName);
                                    //     $data['duong_dan'] = $filePath;
                                    // }
    
                                    // $this->batchData[] = $data;
                                    InformationVb::query()->insert($data);
                                    // Nếu batch đủ kích thước thì thực hiện chèn
                                    // if (count($this->batchData) >= $this->batchSize()) {
                                    //     InformationVb::query()->insert($this->batchData);
                                    //     $this->batchData = []; // Reset batch
                                    // }
                                }
                            }
                        }
                    }
                }
            }
    
            // Chèn các bản ghi còn lại
            // if (!empty($this->batchData)) {
            //     InformationVb::query()->insert($this->batchData);
            //     $this->batchData = [];
            // }
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
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';', // Dấu phân tách
            // 'enclosure' => '"',  // Thường là dấu " (dấu ngoặc kép)
            // 'escape_character' => '\\', // Ký tự escape, nếu có
            // 'inputEncoding' => 'UTF-8', // Đảm bảo tệp có mã hóa UTF-8
        ];
    }
    
}
