<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\InformationRequest;
use App\Imports\VanBanImport;
use App\Models\Config;
use App\Models\InformationVb;
use App\Models\MucLuc;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InformationVbController extends Controller
{
    //
    public function index(Request $request)
    {

        $inputs = $request->all();

        $vanban = InformationVb::query();

        $title = "Danh sách văn bản";
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

    public function add(){
        $title = "Thêm văn bản";
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        return view("admins.pages.vanban.add", [
            "title" => $title,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
        ]);
    }

    public function store(InformationRequest $request){
        // dd($request->all());
        $vanban = InformationVb::where('ma_phong', $request->ma_phong)
                ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
                ->where('ho_so_so', $request->ho_so_so)
                ->where('so_kh_vb', $request->so_kh_vb)->first();
        if($vanban){
            return back()->with('error', 'Không thể thêm văn bản vì đã tồn tại.');
        }
        $profile = Profile::where('ma_phong', $request->ma_phong)
        ->where('ma_muc_luc', $request->ma_mucluc)->where('hop_so', $request->hop_so)->first();
        if(!$profile){
            return back()->with('error', 'Hồ sơ không tồn tại.');
        }
        $vanbannew = new InformationVb();
        $vanbannew->config_id  = $request->config_id;
        $vanbannew->ma_phong = $request->ma_phong;
        $vanbannew->ma_mucluc = $request->ma_mucluc;
        $vanbannew->hop_so = $request->hop_so;
        $vanbannew->ho_so_so = $request->ho_so_so;
        $vanbannew->so_kh_vb = $request->so_kh_vb;
        $vanbannew->time_vb = $request->time_vb;
        $vanbannew->to_so = $request->to_so;
        $vanbannew->tac_gia = $request->tac_gia;
        $vanbannew->noi_dung = $request->noi_dung;
        $vanbannew->ghi_chu = $request->ghi_chu;
        $vanbannew->profile_id = $profile->id;
        if ($request->file('duong_dan')) {
            $file = $request->file('duong_dan');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('duong_dan', $fileName, 'public');
            $vanbannew->duong_dan = 'storage/' . $filePath; // Lưu đường dẫn file
        }
        $vanbannew->save();

        return back()->with('success', 'Thêm văn bản thành công');
    }

    public function edit($id){

        $title = "Sửa văn bản";
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        $vanban = InformationVb::find($id);
        // dd($vanban);
        return view("admins.pages.vanban.edit", [
            "title" => $title,
            "vanban" => $vanban,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
        ]);
    }

    public function update(InformationRequest $request, $id){
        // dd($request->all());
        $vanban = InformationVb::where('id' , '!=', $id)->where('ma_phong', $request->ma_phong)
                ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
                ->where('ho_so_so', $request->ho_so_so)
                ->where('so_kh_vb', $request->so_kh_vb)->first();
        if($vanban){
            return back()->with('error', 'Văn bản này đã tồn tại .');
        }
        $profile = Profile::where('ma_phong', $request->ma_phong)
        ->where('ma_muc_luc', $request->ma_mucluc)->where('hop_so', $request->hop_so)->first();
        if(!$profile){
            return back()->with('error', 'Hồ sơ không tồn tại.');
        }

        $vanbannew = InformationVb::find($id);
        // $vanbannew = new InformationVb();
        $vanbannew->config_id  = $request->config_id;
        $vanbannew->ma_phong = $request->ma_phong;
        $vanbannew->ma_mucluc = $request->ma_mucluc;
        $vanbannew->hop_so = $request->hop_so;
        $vanbannew->ho_so_so = $request->ho_so_so;
        $vanbannew->so_kh_vb = $request->so_kh_vb;
        $vanbannew->time_vb = $request->time_vb;
        $vanbannew->to_so = $request->to_so;
        $vanbannew->tac_gia = $request->tac_gia;
        $vanbannew->noi_dung = $request->noi_dung;
        $vanbannew->ghi_chu = $request->ghi_chu;
        $vanbannew->profile_id = $profile->id;
        if ($request->file('duong_dan')) {
            $file = $request->file('duong_dan');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('duong_dan', $fileName, 'public');
            $vanbannew->duong_dan = 'storage/' . $filePath; // Lưu đường dẫn file
        }
        $vanbannew->save();

        return back()->with('success', 'Sửa văn bản thành công');
    }

    public function delete($id){
        $vanban = InformationVb::find($id);
        if($vanban){
            $vanban->delete();
            return back()->with('success', 'Xóa văn bản thành công');
        }else{
            return back()->with('error', 'Văn bản không tồn tại');
        }
    }

    public function importExcel(FileRequest $request){

    }

    public function PhongByConfigID(Request $request) {
        $coquandata = Profile::where('config_id', $request->id)->with('config', 'maPhong', 'maMucLuc')->get();
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function MucLucByPhongID(Request $request) {
        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->with('config', 'maPhong', 'maMucLuc')->get();
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function HopSoByMucLuc(Request $request) {

        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->where('ma_muc_luc', $request->mucluc)->with('config', 'maPhong', 'maMucLuc')->get();

        return response()->json(['status' => "success", 'data' => $coquandata]);
    }
    public function HoSoSoByHopSo(Request $request) {

        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->where('ma_muc_luc', $request->mucluc)->where('hop_so', $request->hopso)->with('config', 'maPhong', 'maMucLuc')->get();
        Log::info($coquandata);
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }
}
