<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\HopSoModel;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
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

        if (isset($request->ma_phong) && $request->ma_phong != '') {
            $configs->where(function($query) use ($request) {
                $query->where('phong_id', 'like', '%' . $request->ma_phong . '%');

            });
        }

        if (isset($request->ma_mucluc) && $request->ma_mucluc != '') {
            $configs->where(function($query) use ($request) {
                $query->where('mucluc_id', 'like', '%' . $request->ma_mucluc . '%');

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
    }
    public function add(){
        $title   = "Thêm mới hộp số";
        $coquan = Config::all();
        return view('admins.pages.hop.add', ['title' => $title, 'coquan' => $coquan]);
    }

    public function store(Request $request){

        try {

            $empty_hoso = HopSoModel::where('phong_id', $request->phong_id)->where('hop_so', $request->hop_so)->first();

            if($empty_hoso){
                return back()->with('error', 'Hộp số đã có trong Phông');
            }
            HopSoModel::create([
                'coquan_id' => $request->coquan_id,
                'phong_id' => $request->phong_id,
                'mucluc_id' => $request->mucluc_id,
                'hop_so' => $request->hop_so,
            ]);
            return back()->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }

    }

    public function edit($id){
        $title   = "Sửa hộp số";
        $hopso = HopSoModel::find($id);
        $coquan = Config::all();
        return view('admins.pages.hop.edit', ['title' => $title, 'hopso' => $hopso, 'coquan' => $coquan]);
    }

    public function update(Request $request, $id){

        try {
            $hopso = HopSoModel::find($id);

            if(!$hopso){
                return back()->with('error', 'Không tìm thấy hộp số cần chỉnh sửa.');
            }
            $empty_hoso = HopSoModel::where('id', '!=', $id)->where('mucluc_id', $request->mucluc_id)->where('hop_so', $request->hop_so)->first();

            if($empty_hoso){
                return back()->with('error', 'Hộp số đã có trong mục lục');
            }
            $hopso->update([
                'coquan_id' => $request->coquan_id,
                'phong_id' => $request->phong_id,
                'mucluc_id' => $request->mucluc_id,
                'hop_so' => $request->hop_so,
            ]);


            return back()->with('success', 'Cập nhập thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }

    }

    public function delete($id){
        try{
            $hopso = HopSoModel::find($id);
            if(!$hopso){
                return back()->with('error', 'Không tìm thấy hộp số cần chỉnh sửa.');
            }

            $count = Profile::where('hop_so', $id)->count();
            if($count>0){
                return back()->with('error', 'Hộp số đã có người đăng ký dữ liệu, không thể xóa.');
            }
            $hopso->delete();
            return back()->with('success', 'Xóa thành công');
        }catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function view($id){
        $title   = "Chi tiết hộp số";
        $hopso = HopSoModel::find($id);
        if(!$hopso){
            return back()->with('error', 'Không tìm thấy hộp số cần xem.');
        }
        $profiles = Profile::where('hop_so', $id)->with('config', 'maPhong', 'maMucLuc')->paginate(10);
        return view('admins.pages.hop.detail', ['title' => $title, 'hopso' => $hopso, 'hoso' => $profiles]);
    }


    public function PhongByConfigID(Request $request)
    {

        $phong = Phong::where('coquan_id', $request->id)->get();

        return response()->json(['status' => "success", 'data' => $phong]);

    }

    public function MucLucByPhongID(Request $request)
    {

        $mucluc = MucLuc::where('phong_id', $request->phongId)->get();

        return response()->json(['status' => "success", 'data' => $mucluc]);

    }

}
