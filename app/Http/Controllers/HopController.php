<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\HopSoModel;
use Illuminate\Http\Request;

class HopController extends Controller
{  
    public function index(Request $request)
    {
        $inputs = $request->all();
        $configs = HopSoModel::query();
       
        // if (isset($request->name) && $request->name != '') {
        //     $configs->where(function($query) use ($request) {
        //         $query->where('ten_phong', 'like', '%' . $request->name . '%')
        //               ->orWhere('ma_phong', 'like', '%' . $request->name . '%');
                 
        //     });
        // }

        if (isset($request->coquan) && $request->coquan != '') {
            $configs->where(function($query) use ($request) {
                $query->where('coquan_id', 'like', '%' . $request->coquan . '%');
                    
                 
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $configs = $configs->paginate($perPage);

        $title   = "Danh sách hộp số";
        $coquan = Config::all();
        
        return view("admins.pages.hop.list", [
            "hopso" => $configs,
            "title"  => $title,
            "inputs" => $inputs,
            "coquan" => $coquan,

        ]);
    }//
}
