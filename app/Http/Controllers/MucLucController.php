<?php

namespace App\Http\Controllers;

use App\Models\MucLuc;
use App\Models\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MucLucController extends Controller
{
    public function index(Request $request)
    {
        $inputs = $request->all();
        $configs = MucLuc::query();

        if (isset($request->name) && $request->name != '') {
            $configs->where(function($query) use ($request) {
                $query->where('ten_mucluc', 'like', '%' . $request->name . '%')
                      ->orWhere('ma_mucluc', 'like', '%' . $request->name . '%');
            });
        }

        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $configs = $configs->paginate($perPage);

        $title   = "Danh sách mục lục";
        return view("admins.pages.mucluc.list", [
            "mucluc" => $configs,
            "title"  => $title,
            "inputs" => $inputs,

        ]);
    }
    public function add()
    {
        $title   = "Thêm mới mục lục";
        $phongdata  = Phong::all();
        return view('admins.pages.mucluc.add', ['title' => $title,  'phongdata' => $phongdata]);
    }
    public function edit($id)
    {
        $config = MucLuc::find($id);
        $phongdata  = Phong::all();
        $title   = "Sửa mục lục";
        return view('admins.pages.mucluc.edit', ['title' => $title,'config'=>$config, 'phongdata' => $phongdata]);
    }
    public function update(Request $request, $id)
    {
        try {
            $config = MucLuc::find($id);

            if (!$config) {
                return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
            }
            $mucluc = MucLuc::where('id', '!=' , $id)->where('ten_mucluc', $request->ten_mucluc)
            ->where('ma_mucluc', $request->ma_mucluc)->where('phong_id', $request->phong_id)
            ->first();
            if($mucluc){
                return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
            }
            $config->update([
                'ten_mucluc' => $request->ten_mucluc,
                'ma_mucluc' => $request->ma_mucluc,
                'phong_id' => $request->phong_id
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

            // if ($validator->fails()) {
            //     $errors = $validator->errors()->all();
            //     return back()->with('errors', $errors);
            // }
            $this->saveConfig($request);

            return back()->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    private function checkExistingConfig($request)
    {
        return MucLuc::where('ten_mucluc', $request->ten_mucluc)
            ->where('ma_mucluc', $request->ma_mucluc)->where('phong_id', $request->phong_id)
            ->first();
    }

    private function validateConfig($request)
    {

        return Validator::make($request->all(), [
            'ten_mucluc' => 'required|string|max:255',
            'ma_mucluc' => 'required|string|max:10',
            'phong_id' => 'required'
        ]);
    }

    private function saveConfig($request)
    {
        $config = new MucLuc();
        $config->ten_mucluc = $request->ten_mucluc;
        $config->ma_mucluc = $request->ma_mucluc;
        $config->phong_id = $request->phong_id;
        $config->save();
    }

    public function delete($userId)
    {
        $config = MucLuc::find($userId);
        if ($config) {
            $config->delete();
            return back()->with('success', 'Xóa mục lục thành công');
        }
        return back()->with('error', 'Mục lục không tồn tại');
    }

    public function getAgencyCode(Request $request)
    {
        $query = $request->input('query');

        $agencyCodes = DB::table('mucluc')
            ->select('ten_mucluc')
            ->where('ma_mucluc', 'like', '%' . $query . '%')
            ->distinct()
            ->get();

        return response()->json($agencyCodes);
    }
}
