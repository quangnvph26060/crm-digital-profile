<?php

namespace App\Exports;

use App\Models\Mission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportPostPublished implements FromCollection, WithHeadings, WithMapping
{
    protected $project;

    protected $stt = 0;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function collection()
    {
        return Mission::where("status", 5)
                      ->where("project_id", $this->project->id)
                      ->get();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Từ khóa',
            'Url publish'
        ];
    }

    public function map($mission): array
    {
        return [
            1 + $this->stt,
            $mission->keyword,
            $mission->url_publish
        ];
    }
}
