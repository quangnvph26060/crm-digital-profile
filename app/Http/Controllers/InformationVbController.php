<?php

namespace App\Http\Controllers;

use App\Exports\VanBanExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\InformationRequest;
use App\Imports\InformationVbImport;
use App\Models\Config;
use App\Models\InformationVb;
use App\Models\MucLuc;
use App\Models\Phong;
use App\Models\Profile;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InformationVbController extends Controller
{

    // public function index(Request $request)
    // {
    //     $inputs = $request->all();

    //     $vanban = InformationVb::query();
    //     $title = "Danh sách văn bản";

    //     // Áp dụng các bộ lọc
    //     if (isset($request->name) && $request->name != '') {
    //         $vanban->where('so_va_ki_hieu_van_ban', 'like', '%' . $request->name . '%');
    //     }
    //     if (isset($request->phong) && $request->phong != '') {
    //         $vanban->where('config_id', 'like', '%' . $request->config_id . '%');
    //     }
    //     if (isset($request->phong) && $request->phong != '') {
    //         $vanban->where('ma_phong', 'like', '%' . $request->phong . '%');
    //     }
    //     if (isset($request->muc_luc) && $request->muc_luc != '') {
    //         $vanban->where('ma_mucluc', 'like', '%' . $request->muc_luc . '%');
    //     }

    //     // Thêm phân trang ở đây
    //     $perPage = 10; // Số lượng bản ghi trên mỗi trang
    //     $vanban = $vanban->orderBy('profile_id', 'asc')->paginate($perPage);

    //     // Lấy ghi chú cho các cột
    //     $columnComments = $this->getColumnComments('information_vb');

    //     return view("admins.pages.vanban.index", [
    //         "vanban" => $vanban,
    //         "title"  => $title,
    //         "inputs" => $inputs,
    //         "columnComments" => $columnComments, // Chuyển ghi chú đến view
    //     ]);
    // }

    // Thêm phương thức để lấy ghi chú cột

    public function index(Request $request)
    {
        $inputs = $request->all();
        $phongdata  = Phong::all();
        $muclucdata = MucLuc::all();
        $configdata = Config::all();
        $vanban = InformationVb::query();
        $title = "Danh sách văn bản";

        // Áp dụng các bộ lọc
        if (isset($request->name) && $request->name != '') {
            $vanban->where('so_va_ki_hieu_van_ban', 'like', '%' . $request->name . '%');
        }

        // Sửa biến $request->config_id thành $request->phong
        if (isset($request->ma_co_quan) && $request->ma_co_quan != '') {
            $vanban->where('ma_co_quan', 'like', '%' . $request->ma_co_quan . '%');
        }

        // Tìm kiếm theo mã phòng
        if (isset($request->ma_phong) && $request->ma_phong != '') {
            $vanban->where('ma_phong', 'like', '%' . $request->ma_phong . '%');
        }

        // Tìm kiếm theo mục lục
        if (isset($request->muc_luc) && $request->muc_luc != '') {
            $vanban->where('ma_mucluc', 'like', '%' . $request->muc_luc . '%');
        }

        $vanban = $vanban->orderBy('created_at', 'desc');
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $vanban = $vanban->orderBy('profile_id', 'asc')->paginate($perPage);

        // Lấy ghi chú cho các cột
        $columnComments = $this->getColumnComments('information_vb');

        return view("admins.pages.vanban.index", [
            "vanban" => $vanban,
            "title"  => $title,
            "inputs" => $inputs,
            "columnComments" => $columnComments, // Chuyển ghi chú đến view
            "phongdata" => $phongdata,
            "muclucdata" => $muclucdata,
            "configdata" => $configdata,
        ]);
    }
    private function getColumnComments($tableName)
    {
        $columns = Schema::getColumnListing($tableName);
        $comments = [];

        foreach ($columns as $column) {
            $comments[$column] = DB::select("SHOW FULL COLUMNS FROM `$tableName` WHERE Field = ?", [$column])[0]->Comment ?? '';
        }

        return $comments;
    }


    public function add()
    {
        $title = "Thêm văn bản";
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        return view("admins.pages.vanban.add", [
            "title" => $title,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
        ]);
    }

    // public function store(Request $request)
    // {
    //     //  dd($request->all());
    //     $vanban = InformationVb::where('ma_phong', $request->ma_phong)
    //         ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
    //         ->where('ho_so_so', $request->ho_so_so)
    //         ->where('so_va_ki_hieu_van_ban', $request->so_va_ki_hieu_van_ban)->first();

    //     if ($vanban) {
    //         return back()->with('error', 'Không thể thêm văn bản vì đã tồn tại.');
    //     }

    //     $profile = Profile::where('ma_phong', $request->ma_phong)
    //         ->where('ma_muc_luc', $request->ma_mucluc)
    //         ->where('hop_so', $request->hop_so)
    //         ->first();

    //     if (!$profile) {
    //         return back()->with('error', 'Hồ sơ không tồn tại.');
    //     }
    //     $vanbannew = new InformationVb();
    //     $vanbannew->config_id  = $request->config_id;
    //     $vanbannew->ma_phong = $request->ma_phong;
    //     $vanbannew->ma_mucluc = $request->ma_mucluc;
    //     $vanbannew->hop_so = $request->hop_so;
    //     $vanbannew->ho_so_so = $request->ho_so_so;
    //     $vanbannew->so_va_ki_hieu_van_ban = $request->so_va_ki_hieu_van_ban;
    //     $vanbannew->time_vb = $request->time_vb;
    //     $vanbannew->to_so = $request->to_so;
    //     $vanbannew->tac_gia = $request->tac_gia;
    //     $vanbannew->noi_dung = $request->noi_dung;
    //     $vanbannew->ghi_chu = $request->ghi_chu;
    //     $vanbannew->profile_id = $profile->id;
    //     $vanbannew->status = $request->status;
    //     if ($request->file('duong_dan')) {
    //         $coquan = Config::find($request->config_id);
    //         $phong = Phong::find($request->ma_phong);
    //         $mucluc = MucLuc::find($request->ma_mucluc);
    //         $hoso = Profile::find($profile->id);
    //         $file = $request->file('duong_dan');
    //         $fileName = time() . '/' . $coquan->agency_code . '/' . $phong->ma_phong . '/' . $mucluc->ma_mucluc . '/' . $hoso->hop_so . '/' . $hoso->ho_so_so . '/' . $file->getClientOriginalName();
    //         $filePath = $file->storeAs('duong_dan', $fileName, 'public');
    //         $vanbannew->duong_dan = $filePath; // Lưu đường dẫn file
    //     }
    //     $vanbannew->save();

    //     return back()->with('success', 'Thêm văn bản thành công');
    // }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        // dd($data);
        $vanbannew = new InformationVb();

        $vanban = InformationVb::where('ma_phong', $request->ma_phong)
            ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
            ->where('ho_so_so', $request->ho_so_so)
            ->where('so_va_ki_hieu_van_ban', $request->so_va_ki_hieu_van_ban)->first();

        if ($vanban) {
            return back()->with('error', 'Không thể thêm văn bản vì đã tồn tại.');
        }

        $profile = Profile::where('ma_phong', $request->ma_phong)
            ->where('ma_muc_luc', $request->ma_mucluc)
            ->where('hop_so', $request->hop_so)
            ->first();

        if (!$profile) {
            return back()->with('error', 'Hồ sơ không tồn tại.');
        }

        foreach ($data as $key => $value) {
            $vanbannew->$key  = $value;
            if (isset($request->duong_dan)) {
                if ($key === "duong_dan") {
                    $coquan = Config::find($request->ma_co_quan);
                    $phong = Phong::find($request->ma_phong);
                    $mucluc = MucLuc::find($request->ma_mucluc);
                    $hoso = Profile::find($profile->id);
                    $file = $request->file('duong_dan');
                    $fileName = time() . '/' . $coquan->agency_code . '/' . $phong->ma_phong . '/' . $mucluc->ma_mucluc . '/' . $hoso->hop_so . '/' . $hoso->ho_so_so . '/' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('duong_dan', $fileName, 'public');
                    $vanbannew->duong_dan = $filePath; // Lưu đường dẫn file
                }
            }
        }
        $vanbannew->profile_id = $profile->id;
        $vanbannew->save();
        return back()->with('success', 'Thêm văn bản thành công');
    }
    public function edit($id)
    {

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

    public function view($id)
    {

        $title = "Thông tin chi tiết văn bản";

        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        $vanban = InformationVb::find($id);
        // dd($vanban);
        return view("admins.pages.vanban.view", [
            "title" => $title,
            "vanban" => $vanban,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
        ]);
    }

    public function update(Request $request, $id)
    {
        //  dd($request->all());
        $vanbannew = InformationVb::find($id);

        $vanban = InformationVb::where('id', '!=', $id)->where('ma_phong', $request->ma_phong)
            ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
            ->where('ho_so_so', $request->ho_so_so)
            ->where('so_va_ki_hieu_van_ban', $request->so_va_ki_hieu_van_ban)->first();

        if ($vanban) {
            return back()->with('error', 'Không thể thêm văn bản vì đã tồn tại.');
        }

        $profile = Profile::where('ma_phong', $request->ma_phong)
            ->where('ma_muc_luc', $request->ma_mucluc)
            ->where('hop_so', $request->hop_so)
            ->first();

        if (!$profile) {
            return back()->with('error', 'Hồ sơ không tồn tại.');
        }
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $vanbannew->$key  = $value;
            if (isset($request->duong_dan)) {
                if ($key === "duong_dan") {
                    $coquan = Config::find($request->ma_co_quan);
                    $phong = Phong::find($request->ma_phong);
                    $mucluc = MucLuc::find($request->ma_mucluc);
                    $hoso = Profile::find($profile->id);
                    $file = $request->file('duong_dan');
                    $fileName = time() . '/' . $coquan->agency_code . '/' . $phong->ma_phong . '/' . $mucluc->ma_mucluc . '/' . $hoso->hop_so . '/' . $hoso->ho_so_so . '/' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('duong_dan', $fileName, 'public');
                    $vanbannew->duong_dan = $filePath; // Lưu đường dẫn file
                }
            }
        }
        $vanbannew->profile_id = $profile->id;
        $vanbannew->save();
        return back()->with('success', 'Sửa văn bản thành công');
    }

    // public function update(Request $request, $id)
    // {
    //      dd($request->all());
    //     $vanban = InformationVb::where('id', '!=', $id)->where('ma_phong', $request->ma_phong)
    //         ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
    //         ->where('ho_so_so', $request->ho_so_so)
    //         ->where('so_va_ki_hieu_van_ban', $request->so_va_ki_hieu_van_ban)->first();
    //     if ($vanban) {
    //         return back()->with('error', 'Văn bản này đã tồn tại .');
    //     }
    //     $profile = Profile::where('ma_phong', $request->ma_phong)
    //         ->where('ma_muc_luc', $request->ma_mucluc)->where('hop_so', $request->hop_so)->first();
    //     if (!$profile) {
    //         return back()->with('error', 'Hồ sơ không tồn tại.');
    //     }

    //     $vanbannew = InformationVb::find($id);
    //     // $vanbannew = new InformationVb();
    //     $vanbannew->config_id  = $request->config_id;
    //     $vanbannew->ma_phong = $request->ma_phong;
    //     $vanbannew->ma_mucluc = $request->ma_mucluc;
    //     $vanbannew->hop_so = $request->hop_so;
    //     $vanbannew->ho_so_so = $request->ho_so_so;
    //     $vanbannew->so_va_ki_hieu_van_ban = $request->so_va_ki_hieu_van_ban;
    //     $vanbannew->time_vb = $request->time_vb;
    //     $vanbannew->to_so = $request->to_so;
    //     $vanbannew->tac_gia = $request->tac_gia;
    //     $vanbannew->noi_dung = $request->noi_dung;
    //     $vanbannew->ghi_chu = $request->ghi_chu;
    //     $vanbannew->status = $request->status;
    //     $vanbannew->profile_id = $profile->id;
    //     if ($request->file('duong_dan')) {
    //         $coquan = Config::find($request->config_id);
    //         $phong = Phong::find($request->ma_phong);
    //         $mucluc = MucLuc::find($request->ma_mucluc);
    //         $hoso = Profile::find($profile->id);
    //         $file = $request->file('duong_dan');
    //         $fileName = time() . '/' . $coquan->agency_code . '/' . $phong->ma_phong . '/' . $mucluc->ma_mucluc . '/' . $hoso->hop_so . '/' . $hoso->ho_so_so . '/' . $file->getClientOriginalName();
    //         $filePath = $file->storeAs('duong_dan', $fileName, 'public');
    //         $vanbannew->duong_dan =  $filePath;
    //     }
    //     $vanbannew->save();

    //     return back()->with('success', 'Sửa văn bản thành công');
    // }


    public function delete($id)
    {
        $vanban = InformationVb::find($id);
        if ($vanban) {
            $vanban->delete();
            return back()->with('success', 'Xóa văn bản thành công');
        } else {
            return back()->with('error', 'Văn bản không tồn tại');
        }
    }

    public function importExcel(FileRequest $request)
    {
        try {

            Excel::import(new InformationVbImport, $request->file('importexcel'));
            return back()->with('success', 'Dữ liệu đã được nhập thành công');
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return back()->with('error', 'Đã xảy ra lỗi khi nhập dữ liệu từ file Excel');
        }
    }

    public function exportExcel()
    {
        $fileDownload = Excel::download(new VanBanExport, 'vanban.xlsx');

        session()->flash('success', 'Dữ liệu đã xuất thành công');

        return $fileDownload;
    }

    public function PhongByConfigID(Request $request)
    {
        $coquandata = Profile::where('config_id', $request->id)->with('config', 'maPhong', 'maMucLuc')->get();
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function MucLucByPhongID(Request $request)
    {
        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->with('config', 'maPhong', 'maMucLuc')->get();
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function HopSoByMucLuc(Request $request)
    {

        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->where('ma_muc_luc', $request->mucluc)->with('config', 'maPhong', 'maMucLuc')->get();

        return response()->json(['status' => "success", 'data' => $coquandata]);
    }
    public function HoSoSoByHopSo(Request $request)
    {

        $coquandata = Profile::where('config_id', $request->id)->where('ma_phong', $request->phongId)->where('ma_muc_luc', $request->mucluc)->where('hop_so', $request->hopso)->with('config', 'maPhong', 'maMucLuc')->get();
        Log::info($coquandata);
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }
    public function addcolumn()
    {
        $title = "Quản lý trường văn bản";
        $columns = Schema::getColumnListing('information_vb');

        $columnData = [];
        foreach ($columns as $column) {
            // Lấy kiểu dữ liệu của cột
            $columnType = Schema::getColumnType('information_vb', $column);

            // Lấy ghi chú cho cột từ thông tin schema
            $comment = DB::table('information_schema.columns')
                ->where('table_schema', env('DB_DATABASE')) // Lấy database từ file .env
                ->where('table_name', 'information_vb')
                ->where('column_name', $column)
                ->value('column_comment');

            $columnData[] = [
                'name' => $column,
                'type' => $columnType,
                'comment' => $comment, // Thêm ghi chú
            ];
        }

        return view('admins.pages.vanban.addcolumn', compact('title', 'columnData'));
    }



    public function storecolumn(Request $request)
    {
        $request->validate([
            'column_name' => 'required|string|max:255',
            'data_type' => 'required|in:varchar,int,text',
        ]);

        $tableName = 'information_vb';

        switch ($request->data_type) {
            case 'varchar':
                $columnType = 'VARCHAR(255)';
                break;
            case 'int':
                $columnType = 'INT';
                break;
            case 'text':
                $columnType = 'TEXT';
                break;
            default:
                return back()->withErrors(['data_type' => 'Kiểu dữ liệu không hợp lệ.']);
        }

        // $columnName = $request->column_name;
        $comment = $request->column_name;
        $columnName = str_replace('-', '_', Str::slug($comment));


        try {
            DB::statement("ALTER TABLE `$tableName` ADD `$columnName` $columnType NULL");

            if (!empty($comment)) {
                DB::statement("ALTER TABLE `$tableName` MODIFY `$columnName` $columnType NULL COMMENT '$comment'");
            }

            $this->updateArrayVanBan($columnName);

            return back()->with('success', 'Cột đã được thêm thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }


    // Hàm để cập nhật $fillable trong model
    private function updateArrayVanBan($columnName)
    {
        // Đường dẫn đến file chứa mảng
        $arrayPath = app_path('Models/array_vanban.php');

        // Đọc nội dung file
        $array = include $arrayPath;

        // Kiểm tra xem cột đã tồn tại chưa
        if (!in_array($columnName, $array)) {
            $array[] = $columnName; // Thêm cột mới vào mảng

            // Ghi lại nội dung file
            file_put_contents($arrayPath, "<?php\n\nreturn " . var_export($array, true) . ";\n");
        }
    }



    public function destroy($column)
    {
        $tableName = 'information_vb';
        // Bạn có thể sử dụng Schema để xóa cột:
        Schema::table($tableName, function (Blueprint $table) use ($column) {
            $table->dropColumn($column);
        });
        $this->removeColumnFromArrayVanBan($column);
        return redirect()->back()->with('success', 'Cột đã được xóa thành công');
    }

    private function removeColumnFromArrayVanBan($columnName)
    {
        // Đường dẫn đến file chứa mảng
        $arrayPath = app_path('Models/array_vanban.php');

        // Đọc nội dung file
        $array = include $arrayPath;

        // Kiểm tra xem cột có tồn tại trong mảng hay không
        if (in_array($columnName, $array)) {
            // Xóa cột khỏi mảng
            $array = array_filter($array, function ($value) use ($columnName) {
                return $value !== $columnName;
            });

            // Ghi lại mảng đã cập nhật vào file
            file_put_contents($arrayPath, "<?php\n\nreturn " . var_export(array_values($array), true) . ";\n");
        }
    }
}
