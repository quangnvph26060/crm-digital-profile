<?php

namespace App\Http\Controllers;

use App\Exports\VanBanExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\InformationRequest;
use App\Imports\InformationVbImport;
use App\Jobs\ProcessData;
use App\Models\Config;
use App\Models\HopSoModel;
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
use Illuminate\Pagination\LengthAwarePaginator;

class InformationVbController extends Controller
{


    // Thêm phương thức để lấy ghi chú cột
    public function getColumnvanBan(Request $request)
    {
        $selectedValuesArray = json_decode($request->selectedValues, true);
        $InformationVb = new InformationVb();
        $fillableFields = $InformationVb->fillableProfiles();
        $cacheKey = 'duplicateValuesVb';

        $duplicateValues = array_intersect($selectedValuesArray, $fillableFields);

        // Lưu giá trị vào Session
        $request->session()->put($cacheKey, $duplicateValues);

        return back();
    }
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
            $vanban->where(function($query) use ($request) {
              //  $hopSoIds = HopSoModel::where('hop_so', 'like', '%' . $request->name . '%')->pluck('id');
                $query->where('ky_hieu_van_ban', 'like', '%' . $request->name . '%')
                      ->orWhere('trich_yeu_noi_dung_van_ban', 'like', '%' . $request->name . '%')
                      ->orWhere('so_van_ban', 'like', '%' . $request->name . '%');
                        // if ($hopSoIds->isNotEmpty()) {
                        //     $query->orWhere('hop_so', 'like', '%' . $request->name . '%');
                        // }
                      
            });
        }

      
        
        // Sửa biến $request->config_id thành $request->phong
        if (isset($request->coquan) && $request->coquan != '') {
            $vanban->where('ma_co_quan', 'like', '%' . $request->coquan . '%');
        }

        // Tìm kiếm theo mã phòng
        if (isset($request->phong) && $request->phong != '') {
            $vanban->where('ma_phong', 'like', '%' . $request->phong . '%');
        }

        // Tìm kiếm theo mục lục
        if (isset($request->muc_luc) && $request->muc_luc != '') {
            $vanban->where('ma_mucluc', 'like', '%' . $request->muc_luc . '%');
        }
        if (isset($request->hop_so) && $request->hop_so != '') {
            // $hopso = HopSoModel::find($request->hop_so);
            $vanban->where('hop_so', 'like', '%' . $request->hop_so . '%');
        }

        // Thêm phân trang ở đây
        $fillable = ['id', 'profile_id']; //  các cột mặc định phải có

        $cacheKey = 'duplicateValuesVb';
        $selectedProfiles = [];
        if (session()->has($cacheKey)) {
            $duplicateValues = session($cacheKey);
            // dd($duplicateValues);
            $selectedProfiles = $duplicateValues;
            $mergedArray = array_unique(array_merge($fillable, $selectedProfiles));
            if (count($mergedArray) > 2) {
                $vanban->select($mergedArray);
            }
        }

        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $vanban = $vanban->orderBy('profile_id', 'asc')->paginate($perPage);

        // Lấy ghi chú cho các cột
        $columnComments = $this->getColumnComments('information_vb');

        $InformationVb = new InformationVb();
        $fillableFields = $InformationVb->fillableProfiles();
        return view("admins.pages.vanban.index", [
            "vanban" => $vanban,
            "title"  => $title,
            "fillableFields"    => $fillableFields,
            "selectedProfiles"   => $selectedProfiles,
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
        $listcolumns = $this->listcolumn();
        //  dd($listcolumns);
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        return view("admins.pages.vanban.add", [
            "title" => $title,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
            'columns' => $listcolumns
        ]);
    }

    public function addbyhoso($id)
    {

        $title = "Thêm văn bản";
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        $hoso = Profile::find($id);
        $listcolumns = $this->listcolumn();
        return view("admins.pages.vanban.addbyhoso", [
            "title" => $title,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
            'hoso' => $hoso,
            'columns' => $listcolumns
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('_token');
            // dd($data);
            $vanbannew = new InformationVb();

            $vanban = InformationVb::where('ma_phong', $request->ma_phong)
                ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
                ->where('ho_so_so', $request->ho_so_so)
                ->where('so_van_ban', $request->so_van_ban)->first();

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
            DB::commit();
            return back()->with('success', 'Thêm văn bản thành công');
        } catch (\Exception $e) {
            DB::rollback();
            // return back()->with('error', 'Đã xảy ra lỗi khi thêm hồ sơ: ' . $e->getMessage() . ' (Dòng ' . $e->getLine() . ')');
            return back()->with('error', 'Thêm văn bản thất bại');
        }
    }
    public function edit($id)
    {

        $title = "Sửa văn bản";
        $listcolumns = $this->listcolumn();
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        $vanban = InformationVb::find($id);
        // dd($vanban);
        return view("admins.pages.vanban.edit", [
            "title" => $title,
            "vanban" => $vanban,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
            'columns' => $listcolumns
        ]);
    }

    public function view($id)
    {

        $title = "Thông tin chi tiết văn bản";
        $listcolumns = $this->listcolumn();
        $macoquan = Config::all();
        $mamucluc = MucLuc::all();
        $vanban = InformationVb::find($id);
        // dd($vanban);
        return view("admins.pages.vanban.view", [
            "title" => $title,
            "vanban" => $vanban,
            'macoquan' => $macoquan,
            'mamucluc' => $mamucluc,
            'columns' => $listcolumns,

        ]);
    }

    public function update(Request $request, $id)
    {
        //  dd($request->all());
        DB::beginTransaction();

        try {
            $vanbannew = InformationVb::find($id);

            $vanban = InformationVb::where('id', '!=', $id)->where('ma_phong', $request->ma_phong)
                ->where('ma_mucluc', $request->ma_mucluc)->where('hop_so', $request->hop_so)
                ->where('ho_so_so', $request->ho_so_so)
                ->where('so_van_ban', $request->so_van_ban)->first();

            if ($vanban) {
                return back()->with('error', 'Không thể sửa văn bản vì đã tồn tại.');
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
            DB::commit();
            return back()->with('success', 'Sửa văn bản thành công');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Cập nhật văn bản thất bại');
        }
    }

    public function listcolumn()
    {
        $columns = Schema::getColumnListing('information_vb');

        $excludedColumns = [
            'id',
            'created_at',
            'updated_at',
            'ma_co_quan',
            'ma_phong',
            'ma_mucluc',
            'hop_so',
            'ho_so_so',
            'duong_dan',
            'profile_id',
            'status'
        ];

        $columnData = [];
        foreach ($columns as $column) {
            // Bỏ qua các trường trong danh sách loại trừ
            if (in_array($column, $excludedColumns)) {
                continue;
            }

            $columnType = Schema::getColumnType('information_vb', $column);

            $columnInfo = DB::table('information_schema.columns')
                ->where('table_schema', env('DB_DATABASE'))
                ->where('table_name', 'information_vb')
                ->where('column_name', $column)
                ->first(['column_comment', 'is_nullable']);

            $columnInfoArray = (array) $columnInfo;
            $columnInfoArray = array_change_key_case($columnInfoArray, CASE_LOWER);
            // dd($columnInfoArray);
            $columnData[] = [
                'name' => $column,
                'type' => $columnType,
                'comment' => $columnInfoArray['column_comment'] ?? '',
                'is_required' => $columnInfoArray['is_nullable'],
            ];
        }

        return $columnData;
    }




    public function delete($id)
    {
        $vanban = InformationVb::find($id);
        if ($vanban) {
            $vanban->delete();
            return redirect()->back()->with('success', 'Xóa văn bản thành công');
        } else {
            return redirect()->back()->with('error', 'Văn bản không tồn tại');
        }
    }

    public function deleteview($id)
    {
        $vanban = InformationVb::find($id);

        if ($vanban) {
            $vanban->delete();
            return redirect()->route('admin.profile.detail', ['id' => $vanban->profile_id])
                ->with('success', 'Xóa văn bản thành công');
        } else {
            return redirect()->back()->with('success', 'Văn bản không tồn tại');
        }
    }
    public function deletevb($id)
    {
        $vanban = InformationVb::find($id);
        return $vanban->delete();
    }


    public function importExcel(Request $request)
    {
        try {

            //   Excel::import(new InformationVbImport, $request->file('importexcel'));
            $file = $request->file('importexcel');
            $filePath = $file->store('imports');

            // Đẩy job vào hàng đợi
            ProcessData::dispatch($filePath);
            return back()->with('success', 'Dữ liệu đang được cập nhật...');
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return back()->with('error', 'Đã xảy ra lỗi khi nhập dữ liệu từ file Excel');
        }
    }

    public function exportExcel()
    {
        $fileDownload = Excel::download(new VanBanExport, 'Vanban.xlsx');

        session()->flash('success', 'Dữ liệu đã xuất thành công');

        return $fileDownload;
    }

    public function PhongByConfigID(Request $request)
    {

        $coquandata = Profile::where('config_id', $request->id)
            ->with('config', 'maPhong', 'maMucLuc')
            ->get()
            ->unique('ma_phong')
            ->values() // Đảm bảo reindex lại collection sau unique
            ->toArray(); // Chuyển đổi sang dạng mảng
        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function MucLucByPhongID(Request $request)
    {

        $coquandata = Profile::where('config_id', $request->id)
            ->where('ma_phong', $request->phongId)
            ->with('config', 'maPhong', 'maMucLuc')
            ->get()
            ->unique('ma_muc_luc')
            ->values() // Đảm bảo reindex lại collection
            ->toArray(); // Chuyển đổi thành mảng

        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function HopSoByMucLuc(Request $request)
    {
        $coquandata = Profile::where('config_id', $request->id)
            ->where('ma_phong', $request->phongId)
            ->where('ma_muc_luc', $request->mucluc)
            ->with('config', 'maPhong', 'maMucLuc', 'hopso')
            ->get()
            ->unique('hop_so')
            ->values()
            ->toArray();


        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function HoSoSoByHopSo(Request $request)
    {
        $coquandata = Profile::where('config_id', $request->id)
            ->where('ma_phong', $request->phongId)
            ->where('ma_muc_luc', $request->mucluc)
            ->where('hop_so', $request->hopso)
            ->with('config', 'maPhong', 'maMucLuc')
            ->get()
            ->unique('ho_so_so')
            ->values()
            ->toArray();


        return response()->json(['status' => "success", 'data' => $coquandata]);
    }

    public function addColumn(Request $request)
    {
        $comment             = $this->getColumnComments('information_vb');
        $columnData = $this->getColumnData('information_vb');
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $columnDataPaginated = $this->paginateData($columnData, $perPage, $currentPage);

        $title = "Quản lý trường văn bản";
        return view('admins.pages.vanban.addcolumn', compact('title', 'columnDataPaginated', 'comment'));
    }

    function getColumnDetail($tableName, $columnName)
    {
        $columnInfo = DB::select("SHOW FULL COLUMNS FROM `$tableName` WHERE Field = ?", [$columnName]);

        if (!empty($columnInfo)) {
            $columnInfo = $columnInfo[0];
            $columnDetail['name'] = $columnInfo->Field;
            $columnDetail['type'] = $columnInfo->Type;
            $columnDetail['comment'] = $columnInfo->Comment;
            $columnDetail['nullable'] = $columnInfo->Null === 'YES' ? true : false;
            return $columnDetail;
        } else {
            // Xử lý khi không có kết quả trả về
            return redirect()->back()->with('error', 'Cập nhật không thành công.');
        }
    }

    private function getColumnData($table)
    {
        $columns = Schema::getColumnListing($table);
        $columnData = [];

        foreach ($columns as $column) {
            $columnType = Schema::getColumnType($table, $column);
            $isRequired = DB::table('information_schema.columns')
                ->where('table_schema', env('DB_DATABASE'))
                ->where('table_name', $table)
                ->where('column_name', $column)
                ->value('is_nullable');

            $columnData[] = [
                'name' => $column,
                'type' => $columnType,
                'is_required' => $isRequired === 'NO' ? 'Có' : 'Không',
            ];
        }

        return $columnData;
    }
    private function paginateData($data, $perPage, $currentPage)
    {
        $offset = ($currentPage - 1) * $perPage;
        $total = count($data);
        $paginatedData = array_slice($data, $offset, $perPage);

        foreach ($paginatedData as $key => $item) {
            if ($item["name"] === "created_at" || $item["name"] === "id" || $item["name"] === "updated_at") {
                unset($paginatedData[$key]);
            }
        }

        return new LengthAwarePaginator(
            $paginatedData,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
    public function editColumn($column, Request $request)
    {
        $title               = 'Cập nhật trường văn bản';
        $perPage             = 10;

        $information_vb      = $this->getColumnDetail('information_vb', $column);
        $comment             = $this->getColumnComments('information_vb');
        $columnData          = $this->getColumnData('information_vb');

        $currentPage         = $request->input('page', 1);
        $columnDataPaginated = $this->paginateData($columnData, $perPage, $currentPage);
        return view('admins.pages.vanban.editcolumn', compact('title', 'columnDataPaginated', 'comment', 'information_vb'));
    }
    public function storecolumn(Request $request)
    {
        // Validate yêu cầu
        $request->validate([
            'column_name' => 'required|string|max:255',
            'data_type' => 'required|in:varchar,int,text',
            'is_required' => 'nullable|boolean', // Kiểm tra giá trị bắt buộc
        ]);

        $tableName = 'information_vb';

        // Xác định kiểu dữ liệu dựa trên lựa chọn của người dùng
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

        $comment = $request->column_name;
        $columnName = str_replace('-', '_', Str::slug($comment));

        // Kiểm tra nếu trường bắt buộc
        $isRequired = $request->is_required ? 'NOT NULL' : 'NULL';

        try {
            // Thêm cột vào bảng
            DB::statement("ALTER TABLE `$tableName` ADD `$columnName` $columnType $isRequired");

            // Nếu có ghi chú, thêm ghi chú cho cột
            if (!empty($comment)) {
                DB::statement("ALTER TABLE `$tableName` MODIFY `$columnName` $columnType $isRequired COMMENT '$comment'");
            }

            // Cập nhật mảng văn bản (nếu cần)
            $this->updateArrayVanBan($columnName);

            return back()->with('success', 'Cột đã được thêm thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
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

        $cacheKey = 'duplicateValuesVb';

        session()->forget($cacheKey);

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
            // chmod($arrayPath, 7777);
        }
    }

    public function updateColumn($column, Request $request)
    {

        // $request->validate([
        //     'column_name' => 'required|string|max:255',
        //     'column_type' => 'required|in:string,integer,text',
        //     'is_required' => 'required|boolean',
        // ]);

        $profiles = $this->getColumnDetail('information_vb', $column);

        $columnName = $request->input('column_name');
        $columnType = $request->input('data_type');
        $isRequired = $request->input('is_required');

        $result = $this->editColumnAndUpdateFillable($columnName, $columnType, $isRequired, $profiles['name']);
        return $result;
    }
    public function editColumnAndUpdateFillable($columnName, $columnType, $isRequired, $column)
    {
        $cleanColumnName = Str::lower(str_replace('-', '_', Str::slug($columnName))); // tên cột mới
        switch ($columnType) {
            case "string":
                $newType  = 'VARCHAR(255)';
                break;
            case "integer":
                $newType  = 'INT';
                break;
            case "text":
                $newType  = 'TEXT';
                break;
            case "date":
                $newType  = 'DATE';
                break;
            default:
                $newType = 'VARCHAR(255)';
        }
        Schema::table('information_vb', function (Blueprint $table) use ($cleanColumnName, $column, $columnType, $newType, $columnName, $isRequired) {
            if ($isRequired == "1") {
                if ($cleanColumnName == $column) {
                    DB::statement("UPDATE information_vb SET $cleanColumnName = '' WHERE $cleanColumnName IS NULL");
                }

                DB::statement("ALTER TABLE information_vb CHANGE $column $cleanColumnName $newType  NOT NULL  COMMENT '$columnName'");
            } else {
                if ($cleanColumnName == $column) {
                    DB::statement("UPDATE information_vb SET $cleanColumnName = '' WHERE $cleanColumnName IS NULL");
                }

                DB::statement("ALTER TABLE information_vb CHANGE $column $cleanColumnName $newType   DEFAULT NULL  COMMENT '$columnName'");
            }
        });
        // Cập nhật mảng fillable_fields_profile.php
        $fillableFields = include app_path('Models/array_vanban.php');
        $fillableFields = array_values(array_unique($fillableFields));

        // Xóa "ghi_chu" nếu đã tồn tại trong mảng
        $index = array_search($column, $fillableFields);
        if ($index !== false) {
            unset($fillableFields[$index]);
        }

        if (!in_array($cleanColumnName, $fillableFields)) {
            $fillableFields[] = $cleanColumnName;
            file_put_contents(app_path('Models/array_vanban.php'), "<?php\n\nreturn " . var_export($fillableFields, true) . ";\n");
        }

        return redirect()->route('admin.column')->with('success', 'Cột đã được cập nhật thành công!');
    }
}
