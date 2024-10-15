<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InformationVb;
use Illuminate\Http\Request;

class InformationVbController extends Controller
{
    //
    public function index(Request $request)
    {

        $inputs = $request->all();

        $vanban = InformationVb::query();

        $title   = "Danh sách văn bản";
        if (isset($request->name) && $request->name != '') {
            $vanban->where(function($query) use ($request) {
                $query->where('so_kh_vb', 'like', '%' . $request->name . '%');
            });
        }

        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $vanban = $vanban->paginate($perPage);


        return view("admins.pages.vanban.index", [
            "vanban" => $vanban,
            "title"  => $title,
            "inputs" => $inputs,
        ]);
    }
}
