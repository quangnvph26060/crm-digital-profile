<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        $inputs = $request->all();
        $configs = Config::query();
        
        if (isset($request->name) && $request->name != '') {
            $configs->where(function($query) use ($request) {
                $query->where('agency_name', 'like', '%' . $request->name . '%')
                      ->orWhere('agency_code', 'like', '%' . $request->name . '%');
            });
        }
        
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $configs = $configs->paginate($perPage);
        
        $title   = "Danh sách cơ quan";
        return view("admins.pages.config.list", [
            "config" => $configs,
            "title"  => $title,
            "inputs" => $inputs,
        ]);
    }
    public function add()
    {
        $title   = "Thêm mới cơ quan";
        return view('admins.pages.config.add', ['title' => $title]);
    }
    public function edit($id)
    {
        $config = Config::find($id);
        $title   = "Sửa thông tin cơ quan";
        return view('admins.pages.config.edit', ['title' => $title,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        try {
            $config = Config::find($id);

            if (!$config) {
                return back()->with('error', 'Không tìm thấy bản ghi cần chỉnh sửa.');
            }
            $config->update([
                'agency_name' => $request->agency_name,
                'agency_code' => $request->agency_code,
                'font_name'   => $request->agency_name,
                'font_code'   => $request->font_code,
                'toc_name'    => $request->toc_name,
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
        return Config::where('agency_name', $request->agency_name)
            ->where('agency_code', $request->agency_code)
            ->where('font_name', $request->font_name)
            ->where('font_code', $request->font_code)
            ->where('toc_name', $request->toc_name)
            ->first();
    }

    private function validateConfig($request)
    {
        return Validator::make($request->all(), [
            'agency_name' => 'required|string|max:255',
            'agency_code' => 'required|string|max:10',
            'font_name' => 'required|string|max:255',
            'font_code' => 'required|string|max:10|numeric',
            'toc_name' => 'required|string|max:255',
        ]);
    }

    private function saveConfig($request)
    {
        $config = new Config();
        $config->agency_name = $request->agency_name;
        $config->agency_code = $request->agency_code;
        $config->font_name = $request->font_name;
        $config->font_code = $request->font_code;
        $config->toc_name = $request->toc_name;
        $config->save();
    }
    
    public function delete($userId)
    {
        $config = Config::find($userId);
        if ($config) {
            $config->delete();
            return back()->with('success', 'Xóa cơ quan thành công');
        }
        return back()->with('error', 'Cơ quan không tồn tại');
    }

    public function getAgencyCode(Request $request)
    {
        $query = $request->input('query');

        $agencyCodes = DB::table('configs')
            ->select('agency_code')
            ->where('agency_code', 'like', '%' . $query . '%')
            ->distinct()
            ->get();

        return response()->json($agencyCodes);
    }
}
