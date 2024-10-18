<?php

namespace App\Exports;

use App\Models\Profile;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProfileExport implements FromCollection
{

    public function map($row): array
    {
        return [
            'Mã cơ quan' => $row->config_id,
            'Mã mục lục' => $row->ma_muc_luc,
            'Hộp số' => $row->hop_so,
        ];
    }
    public function headings(): array
    {
        return [
            'Mã cơ quan 1',
            'Mã mục lục 1',
            'Hộp số 1',
         
        ];
    }
    public function collection()
    {
        return Profile::all();
    }
}
