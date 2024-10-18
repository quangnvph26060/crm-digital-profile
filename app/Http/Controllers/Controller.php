<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public function __construct()
   {
   
//         $tableName = 'phong';
//         $columns = Schema::getColumnListing($tableName);
        
//         $columnDetails = [];
//         foreach ($columns as $column) {
//             $columnDetails[$column] = Schema::getColumnType($tableName, $column);
//         }
    
//         dd($columnDetails);
    
    }
   
}
