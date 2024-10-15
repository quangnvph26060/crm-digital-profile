<?php

namespace App\Http\Controllers;

use App\Models\Config as ModelsConfig;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Config;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
        // dd($request->all());

        $phongdata  = Phong::all();
        $muclucdata = MucLuc::all();
        $title   = "Danh sách hồ sơ";
        $profiles = Profile::query();
        if (isset($request->name) && $request->name != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('tieu_de_ho_so', 'like', '%' . $request->name . '%');
            });
        }
        if (isset($request->phong) && $request->phong != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_phong', 'like', '%' . $request->phong . '%');
            });
        }
        if (isset($request->muc_luc) && $request->muc_luc != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_muc_luc', 'like', '%' . $request->muc_luc . '%');
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);
        //  dd($profiles);

        return view("admins.pages.profiles.index", [
            "profiles" => $profiles,
            "title"  => $title,
            "inputs" => $inputs,
            "phongdata" => $phongdata,
            "muclucdata" => $muclucdata,
        ]);
    }
    public function add()
    {
        $title   = "Thêm mới hồ sơ";
        $macoquan = ModelsConfig::all();
        $mamucluc = MucLuc::all();
        return view(
            'admins.pages.profiles.add',
            [
                'title' => $title,
                'macoquan' => $macoquan,
                'mamucluc' => $mamucluc
            ]
        );
    }
    public function PhongDetailToConfig(Request $request)
    {
        $phongdata = Phong::select('ma_phong', 'ten_phong', 'id')->where('coquan_id', $request->id)->get();
        return response()->json(['status' => "success", 'data' => $phongdata]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $macoquan =  Config::find($request->ma_coquan);
        if (!$macoquan) {
            return back()->with('error', 'Không tìm thấy mã cơ quan.');
        }
        $maphong = Phong::where('id', $request->ma_phong)
            ->where('coquan_id', $request->ma_coquan)
            ->first();
        if (!$maphong) {
            return back()->with('error', 'Không tìm thấy mã phông trong cơ quan này.');
        }
        // dd($request->all());
        $profile = new Profile();
        $profile->config_id  = $request->ma_coquan;
        $profile->ma_muc_luc = $request->ma_mucluc;
        $profile->ma_phong = $request->ma_phong;
        $profile->hop_so = $request->hop_so;
        $profile->ho_so_so = $request->ho_so_so;
        $profile->tieu_de_ho_so = $request->tieu_de_ho_so;
        $profile->ngay_bat_dau = $request->date_start;
        $profile->ngay_ket_thuc = $request->date_end;
        $profile->so_to = $request->so_to;
        $profile->thbq = $request->thbq;
        $profile->ghi_chu = $request->ghi_chu;
        $profile->save();
        return back()->with('success', 'Thêm hồ sơ thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profiles = Profile::query();
        if (isset($request->name) && $request->name != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('tieu_de_ho_so', 'like', '%' . $request->name . '%');
            });
        }
        if (isset($request->phong) && $request->phong != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_phong', 'like', '%' . $request->phong . '%');
            });
        }
        if (isset($request->muc_luc) && $request->muc_luc != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_muc_luc', 'like', '%' . $request->muc_luc . '%');
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);
        //  dd($profiles);
        $macoquan = Config::all();
        $profile = Profile::find($id);
        $mamucluc = MucLuc::all();
        $title   = "Xem hồ sơ";

        return view('admins.pages.profiles.edit', ['title' => $title, 'profile' => $profile, 'macoquan' => $macoquan, 'mamucluc' => $mamucluc, 'profiles' => $profiles]);
    }
    public function detail($id)
    {
        $profiles = Profile::query();
        if (isset($request->name) && $request->name != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('tieu_de_ho_so', 'like', '%' . $request->name . '%');
            });
        }
        if (isset($request->phong) && $request->phong != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_phong', 'like', '%' . $request->phong . '%');
            });
        }
        if (isset($request->muc_luc) && $request->muc_luc != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_muc_luc', 'like', '%' . $request->muc_luc . '%');
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);
        //  dd($profiles);
        $macoquan = Config::all();
        $profile = Profile::find($id);
        $mamucluc = MucLuc::all();
        $title   = "Xem hồ sơ";

        return view('admins.pages.profiles.detail', ['title' => $title, 'profile' => $profile, 'macoquan' => $macoquan, 'mamucluc' => $mamucluc, 'profiles' => $profiles]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        if (!$profile) {
            return back()->with('error', 'Không tìm thấy thông tin hồ sơ.');
        }
        $profile->update([
            'config_id ' => $request->ma_coquan,
            'ma_phong' => $request->ma_phong,
            'ma_muc_luc' => $request->ma_mucluc,
            'hop_so'   => $request->hop_so,
            'so_to' => $request->so_to,
            'ho_so_so'=>$request->ho_so_so,
            'thbq' => $request->thbq,
            'tieu_de_ho_so'=>$request->tieu_de_ho_so,
            'ghi_chu' => $request->ghi_chu,
            'ngay_bat_dau' => $request->date_start,
            'ngay_ket_thuc' => $request->date_end,
        ]);
        return back()->with('success', 'Chỉnh sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
