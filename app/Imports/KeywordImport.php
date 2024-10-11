<?php

namespace App\Imports;

use App\Models\Keyword;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KeywordImport implements ToCollection, WithHeadingRow
{
    protected $projectId;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    public function collection(Collection $rows)
    {
        try {
            $datas = [];
            foreach ($rows as $row) {
                if (!is_null($row['keyword'])) {
                    $datas[] = [
                        "project_id" => $this->projectId,
                        "name" => $row['keyword'],
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                }
            }
            Keyword::insert($datas);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
