<?php

namespace App\Http\Controllers;

use App\Exports\ProfileExport;
use App\Http\Requests\ProfileRequest;
use App\Imports\ProfileImport;
use App\Models\Config as ModelsConfig;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\InformationVb;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

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
        $configdata = Config::all();
        $title   = "Danh sách hồ sơ";
        $profiles = Profile::query();
        if (isset($request->name) && $request->name != '') {

            $profiles->where(function($query) use ($request) {

                $query->where('tieu_de_ho_so', 'like', '%' . $request->name . '%');
            });
        }
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function($query) use ($request) {
                $query->where('config_id', 'like', '%' . $request->coquan . '%');
            });
        }
        if (isset($request->phong) && $request->phong != '') {

            $profiles->where(function($query) use ($request) {
                $query->where('ma_phong', 'like', '%' . $request->phong . '%');
            });
        }
        if (isset($request->muc_luc) && $request->muc_luc != '') {

            $profiles->where(function($query) use ($request) {

                $query->where('ma_muc_luc', 'like', '%' . $request->muc_luc . '%');
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);


        return view("admins.pages.profiles.index", [
            "profiles"      => $profiles,
            "title"         => $title,
            "inputs"        => $inputs,
            "phongdata" => $phongdata,
            "muclucdata" => $muclucdata,
            "configdata" => $configdata,
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
    public function storeProfile(Request $request)
    {
        DB::beginTransaction();
      
        try {
            $data = $request->except('_token');
           //   dd($data);
            $macoquan = $this->checkExistence(Config::class, $request->config_id , 'Không tìm thấy mã cơ quan.');

            $maphong = Phong::where('id', $request->ma_phong)
                ->where('coquan_id', $request->config_id)
                ->first();

            if (!$maphong) {
                DB::rollback();
                return back()->with('error', 'Không tìm thấy mã phòng trong cơ quan này.');
            }

            $result_profile = Profile::where('hop_so', $request->hop_so)
                ->where('config_id', $request->config_id)
                ->where('ma_phong', $request->ma_phong)
                ->where('ma_muc_luc', $request->ma_mucluc)
                ->where('ho_so_so', $request->ho_so_so)
                ->first();

            if ($result_profile) {
                DB::rollback();
                return back()->with('error', 'Đã có hồ sơ trong hộp này');
            }
            $fillableFields = (new Profile)->getFillable();
        
            $data['config_id'] = $request->config_id;
            Profile::unguard(); // Bỏ qua fillable để tạo bản ghi
            Profile::create($data);
            Profile::reguard();
          
           

            DB::commit();
            return back()->with('success', 'Thêm hồ sơ thành công');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Đã xảy ra lỗi khi thêm hồ sơ: ' . $e->getMessage() . ' (Dòng ' . $e->getLine() . ')');
        }
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
    private function checkExistence($model, $id, $errorMessage)
    {
        $object = $model::find($id);
        if (!$object) {
            return back()->with('error', $errorMessage);
        }
        return $object;
    }

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
        $vanban = InformationVb::query();

      
        if (isset($request->name) && $request->name != '') {
            $vanban->where(function($query) use ($request) {
                $query->where('so_kh_vb', 'like', '%' . $request->name . '%');
            });
        }
        $vanban->where('profile_id',$id);
        $perPage = 10;
        $vanban = $vanban->paginate($perPage);

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
        return view('admins.pages.profiles.detail', 
        [
            'title' => $title, 
            'profile' => $profile, 
            'macoquan' => $macoquan, 
            'mamucluc' => $mamucluc, 
            'profiles' => $profiles,
            'vanban'=>$vanban
        ]);
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
        $profile = $this->checkExistence(Profile::class, $id, 'Không tìm thấy thông tin hồ sơ.');

        $profile->update([
            'config_id ' => $request->config_id,
            'ma_phong' => $request->ma_phong,
            'ma_muc_luc' => $request->ma_mucluc,
            'hop_so'   => $request->hop_so,
            'so_to' => $request->so_to,
            'ho_so_so' => $request->ho_so_so,
            'thbq' => $request->thbq,
            'tieu_de_ho_so' => $request->tieu_de_ho_so,
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
    public function deleteHoso($id)
    {
        $vanban = Profile::find($id);
        if ($vanban) {
            $vanban->delete();
            return back()->with('success', 'Xóa văn bản thành công');
        } else {
            return back()->with('error', 'Văn bản không tồn tại');
        }
    }
    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'Vui lòng chọn file Excel để nhập'], 400);
        }

        $file = $request->file('file');

        try {
            Excel::import(new ProfileImport, $file);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi khi nhập dữ liệu từ file Excel'], 500);
        }

        return response()->json(['success' => 'Dữ liệu đã được nhập thành công'], 200);
    }
    public function export()
    {
        return Excel::download(new ProfileExport, 'users.xlsx');
    }
}
