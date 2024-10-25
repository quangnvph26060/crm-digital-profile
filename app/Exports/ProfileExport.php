<?php

namespace App\Exports;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProfileExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

   public function map($row): array
{ 
    $sortedData = [];
    
    $tableColumns = collect($row)->keys()->all();

    foreach ($tableColumns as $column) {
        $sortedData[] = $row->$column;
    }

    return $sortedData;
}

public function headings(): array
{
    $tableColumns = DB::getSchemaBuilder()->getColumnListing('profiles'); 

    return $tableColumns;
}

    public function collection()
    {
        return  Profile::select('*')->selectRaw('null as updated_at, null as created_at')->get();
    }
}