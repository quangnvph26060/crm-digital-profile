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
use App\Models\HopSoModel;
use App\Models\InformationVb;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{

    public function getColumnHoSo(Request $request)
    {
        $selectedValuesArray = json_decode($request->selectedValues, true);
        $profile = new Profile();
        $fillableFields = $profile->fillableProfiles();
        $cacheKey = 'duplicateValues';

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
        $title   = "Danh sách hồ sơ";
        $profiles = Profile::query();
        if (isset($request->name) && $request->name != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('tieu_de_ho_so', 'like', '%' . $request->name . '%');
            });
        }
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function ($query) use ($request) {
                $query->where('config_id', 'like', '%' . $request->coquan . '%');
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
        if (isset($request->hop_so) && $request->hop_so != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('hop_so', 'like', '%' . $request->hop_so . '%');
            });
        }
        $fillable = ['id']; //  các cột mặc định phải có

        $cacheKey = 'duplicateValues';
        $selectedProfiles = [];
        if (session()->has($cacheKey)) {
            $duplicateValues = session($cacheKey);
            // dd($duplicateValues)
            $selectedProfiles = $duplicateValues;
            $mergedArray = array_unique(array_merge($fillable, $selectedProfiles));
            if (count($mergedArray) > 1) {
                $profiles->select($mergedArray);
            }
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);

        $columnComments = $this->getColumnComments('profiles');

        $profileNew = new Profile();
        $fillableFields = $profileNew->fillableProfiles();

        return view("admins.pages.profiles.index", [
            "profiles"          => $profiles,
            "fillableFields"    => $fillableFields,
            "selectedProfiles"  => $selectedProfiles,
            "columnComments"    => $columnComments,
            "title"             => $title,
            "inputs"            => $inputs,
            "phongdata"         => $phongdata,
            "muclucdata"        => $muclucdata,
            "configdata"        => $configdata,
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
        $title   = "Thêm mới hồ sơ";
        $macoquan = ModelsConfig::all();
        $mamucluc = MucLuc::all();
        $listcolumns = $this->listcolumn();
        return view(
            'admins.pages.profiles.add',
            [
                'title' => $title,
                'macoquan' => $macoquan,
                'mamucluc' => $mamucluc,
                'columns' => $listcolumns,
            ]
        );
    }
    public function listcolumn()
    {
        $columns = Schema::getColumnListing('profiles');

        $excludedColumns = [
            'id',
            'created_at',
            'updated_at',
            'config_id',
            'ma_phong',
            'ma_muc_luc',
            'hop_so',
            'status'
        ];

        $columnData = [];
        foreach ($columns as $column) {
            // Bỏ qua các trường trong danh sách loại trừ
            if (in_array($column, $excludedColumns)) {
                continue;
            }

            $columnType = Schema::getColumnType('profiles', $column);

            $columnInfo = DB::table('information_schema.columns')
                ->where('table_schema', env('DB_DATABASE'))
                ->where('table_name', 'profiles')
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

    public function PhongDetailToConfig(Request $request)
    {
        $phongdata = Phong::select('ma_phong', 'ten_phong', 'id')->where('coquan_id', $request->id)->get();
        return response()->json(['status' => "success", 'data' => $phongdata]);
    }

    public function MucLucDetailToPhong(Request $request)
    {
        $muclucdata = MucLuc::where('phong_id', $request->id)->get();
        return response()->json(['status' => "success", 'data' => $muclucdata]);
    }

    public function MucLucDetailToHopSo(Request $request)
    {
        $muclucdata = Profile::where('id', $request->id)->first();
        $muclucdata = $muclucdata->hopso->hop_so;
        return response()->json(['status' => "success", 'data' => $muclucdata]);
    }

    public function HopSoToMucLuc(Request $request)
    {
        $muclucdata = HopSoModel::where('mucluc_id', $request->id)->get();
        return response()->json(['status' => "success", 'data' => $muclucdata]);
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
            DB::rollback();
            $data = $request->except('_token');
            // dd($data);
            $macoquan = $this->checkExistence(Config::class, $request->config_id, 'Không tìm thấy mã cơ quan.');

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
                ->where('ma_muc_luc', $request->ma_muc_luc)
                ->where('ho_so_so', $request->ho_so_so)
                ->first();
            $hopso = HopSoModel::find($request->hop_so);
            if (!$hopso) {
                DB::rollback();
                $hopso = HopSoModel::create([
                    'coquan_id' => $request->config_id,
                    'phong_id' => $request->ma_phong,
                    'mucluc_id' => $request->ma_muc_luc,
                    'hop_so' => $request->hop_so,
                ]);
            }

            if ($result_profile) {
                DB::rollback();
                return back()->with('error', 'Đã có hồ sơ trong hộp này');
            }
            $fillableFields = (new Profile)->getFillable();

            $data['config_id'] = $request->config_id;
            $data['hop_so'] = $hopso->id;

            Profile::unguard(); // Bỏ qua fillable để tạo bản ghi
            Profile::create($data);
            // dd($data);
            Profile::reguard();

            DB::commit();
            return back()->with('success', 'Thêm hồ sơ thành công');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Thêm hồ sơ không thành công');
            // return back()->with('error', 'Đã xảy ra lỗi khi thêm hồ sơ: ' . $e->getMessage() . ' (Dòng ' . $e->getLine() . ')');
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
        if (isset($request->ma_muc_luc) && $request->ma_muc_luc != '') {
            $profiles->where(function ($query) use ($request) {
                $query->where('ma_muc_luc', 'like', '%' . $request->ma_muc_luc . '%');
            });
        }
        // Thêm phân trang ở đây
        $perPage = 10; // Số lượng bản ghi trên mỗi trang
        $profiles = $profiles->paginate($perPage);
        //  dd($profiles);
        $macoquan = Config::all();
        $profile = Profile::find($id);
        $mamucluc = MucLuc::all();
        $title   = "Sửa hồ sơ";
        $listcolumns = $this->listcolumn();
        return view('admins.pages.profiles.edit', ['title' => $title, 'profile' => $profile, 'macoquan' => $macoquan, 'mamucluc' => $mamucluc, 'profiles' => $profiles,  'columns' => $listcolumns]);
    }
    public function detail($id)
    {
        $vanban = InformationVb::query();


        if (isset($request->name) && $request->name != '') {
            $vanban->where(function ($query) use ($request) {
                $query->where('so_kh_vb', 'like', '%' . $request->name . '%');
            });
        }
        $vanban->where('profile_id', $id);
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
        $columnComments = $this->getColumnComments('information_vb');
        return view(
            'admins.pages.profiles.detail',
            [
                'title' => $title,
                'profile' => $profile,
                'macoquan' => $macoquan,
                'mamucluc' => $mamucluc,
                'profiles' => $profiles,
                'vanban' => $vanban,
                'columnComments' => $columnComments,
            ]
        );
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
        $data = $request->except('_token');
        $fillableFields = (new Profile)->getFillable();

        $data['config_id'] = $request->config_id;

        $profile->update($data);

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
        $hoso = Profile::find($id);
        if ($hoso) {
            $vanban = InformationVb::where('profile_id', $id)->count();
            if ($vanban > 0) {
                InformationVb::where('profile_id', $id)->delete();
            }
            $hoso->delete();
            return back()->with('success', 'Xóa hồ sơ thành công');
        } else {
            return back()->with('error', 'Hồ sơ không tồn tại');
        }
    }
    public function deleteprofile($id)
    {
        $vanban = InformationVb::where('profile_id', $id)->count();
        if ($vanban > 0) {
            InformationVb::where('profile_id', $id)->delete();
        }
        $hoso = Profile::find($id);
        // dd($hoso);
         $hoso->delete();
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
        return Excel::download(new ProfileExport, 'Hoso.xlsx');
    }
    public function searchHoSo(Request $request)
    {
        $profiles = Profile::query();
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function ($query) use ($request) {
                $query->where('config_id', 'like', '%' . $request->coquan . '%');
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
        $maPhongs = $profiles->pluck('hop_so')->unique();
        return response()->json(['status' => 'success', 'data' => $maPhongs]);
    }
    public function searchPhong(Request $request)
    {
        $profiles = Phong::query();
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('coquan_id', 'like', '%' . $request->coquan . '%');
            });
        }
        $maPhongs = $profiles->pluck('id', 'ten_phong')->unique();
        return response()->json(['status' => 'success', 'data' => $maPhongs]);
    }
    public function searchMucLuc(Request $request)
    {

        $profiles = MucLuc::query();
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('phong_id', 'like', '%' . $request->coquan . '%');
            });
        }
        $mucluc = $profiles->pluck('id', 'ten_mucluc')->unique();
        return response()->json(['status' => 'success', 'data' => $mucluc]);
    }

    public function searchHopSo(Request $request)
    {
        $profiles = HopSoModel::query();
        if (isset($request->coquan) && $request->coquan != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('coquan_id', 'like', '%' . $request->coquan . '%');
            });
        }
        if (isset($request->phong) && $request->phong != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('phong_id', 'like', '%' . $request->phong . '%');
            });
        }
        if (isset($request->mucluc) && $request->mucluc != '') {

            $profiles->where(function ($query) use ($request) {

                $query->where('mucluc_id', 'like', '%' . $request->mucluc . '%');
            });
        }
         $hopso = $profiles->pluck('id', 'hop_so');
        return response()->json(['status' => 'success', 'data' => $hopso]);
    }
}
