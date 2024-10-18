<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhongController extends Controller
{
    public function index(Request $request)
    {
        $inputs = $request->all();
        $configs = Phong::query();
     
        if (isset($request->name) && $request->name != '') {
            $configs->where(function($query) use ($request) {
                $query->where('ten_phong', 'like', '%' . $request->name . '%')
                      ->orWhere('ma_phong', 'like', '%' . $request->name . '%');
            });
        }
        
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $configs = $configs->paginate($perPage);
        
        $title   = "Danh sách Phông";
        return view("admins.pages.phong.list", [
            "phong" => $configs,
            "title"  => $title,
            "inputs" => $inputs,
           
        ]);
    }
    public function add()
    {
        $title   = "Thêm mới phông";
        $macoquan = Config::all();
        return view('admins.pages.phong.add', ['title' => $title,'macoquan'=>$macoquan]);
    }
    public function edit($id)
    {
        $macoquan = Config::all();
        $config = Phong::find($id);
        $title   = "Sửa thông tin phông";
        return view('admins.pages.phong.edit', ['title' => $title,'config'=>$config,'macoquan'=>$macoquan]);
    }
    public function update(Request $request, $id)
    {
        try {
            $config = Phong::find($id);

            if (!$config) {
                return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
            }
            $config->update([
                'ten_phong' => $request->ten_phong,
                'ma_phong' => $request->ma_phong,
                'coquan_id' => $request->ma_coquan,
            ]);
            return back()->with('success', 'Chỉnh sửa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $existingConfig = $this->checkExistingConfig($request);

            if ($existingConfig) {
                return back()->with('error', 'Không thể thêm bản ghi vì trùng lặp dữ liệu.');
            }
            $validator = $this->validateConfig($request);
            $this->saveConfig($request);

            return back()->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    private function checkExistingConfig($request)
    {
        return Phong::where('ten_phong', $request->ten_phong)
            ->where('ma_phong', $request->ma_phong)
            ->first();
    }

    private function validateConfig($request)
    {
        return Validator::make($request->all(), [
            'ten_phong' => 'required|string|max:255',
            'ma_phong' => 'required|string|max:10',
        ]);
    }

    private function saveConfig($request)
    {
        $phong = new Phong();
        $phong->ten_phong = $request->ten_phong;
        $phong->ma_phong = $request->ma_phong;
        $phong->coquan_id = $request->ma_coquan;
        $phong->save();
        // $this->addPhongToTrungGian($phong->id);
     
    }
    
    // public function addPhongToTrungGian($id)
    // {
    //     $muclucs = MucLuc::all();
    
    //     $data = $muclucs->map(function ($mucluc) use ($id) {
    //         return [
    //             'phong_id' => $id,
    //             'mucluc_id' => $mucluc->id,
    //         ];
    //     })->toArray();
    
    //     // Thêm dữ liệu vào bảng trung gian
    //     DB::table('phong_mucluc')->insert($data);
    // }
    public function delete($userId)
    {
        $profiles = Profile::where('ma_phong',$userId)->first();
        if($profiles){
            return back()->with('error', 'Mã phông này còn liên quan đền hồ sơ');
        }
        $config = Phong::find($userId);
       
        if ($config) {
            $config->delete();
            return back()->with('success', 'Xóa phông thành công');
        }
        return back()->with('error', 'Phông không tồn tại');
    }

    public function getAgencyCode(Request $request)
    {
        $query = $request->input('query');

        $agencyCodes = DB::table('phong')
            ->select('ten_phong')
            ->where('ten_phong', 'like', '%' . $query . '%')
            ->distinct()
            ->get();

        return response()->json($agencyCodes);
    }
}
