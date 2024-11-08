<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;

class CustomColumnController extends Controller
{
    public function index(Request $request)
    {
        // tên cột db
        $columns = Schema::getColumnListing('profiles');

        $columnData = [];
        $excludedColumns = ['id', 'config_id', 'ma_phong', 'ma_muc_luc', 'hop_so', 'ho_so_so'];
        foreach ($columns as $column) {
            if (in_array($column, $excludedColumns)) {
                continue;
            }
            // Lấy kiểu dữ liệu của cột
            $columnType = Schema::getColumnType('profiles', $column);

            // Lấy ghi chú cho cột từ thông tin schema
            // $comment = DB::table('information_schema.columns')
            //     ->where('table_schema', env('DB_DATABASE'))
            //     ->where('table_name', 'profiles')
            //     ->where('column_name', $column)
            //     ->value('column_comment');
            $comment =  $this->getColumnComments('profiles');
          //
            // Kiểm tra xem cột có được yêu cầu không
            $isRequired = DB::table('information_schema.columns')
                ->where('table_schema', env('DB_DATABASE'))
                ->where('table_name', 'profiles')
                ->where('column_name', $column)
                ->value('is_nullable');
            $columnData[] = [
                'name' => $column,
                'type' => $columnType,
               // 'comment' => $comment, // Thêm ghi chú
                'is_required' => $isRequired === 'NO' ? 'Có' : 'Không', // Kiểm tra trạng thái yêu cầu
            ];
        }

        // Phân trang dữ liệu
        $perPage = 10; // Số lượng cột trên mỗi trang
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = count($columnData);
        $columnDataPaginated = array_slice($columnData, $offset, $perPage);

        // Tạo một đối tượng LengthAwarePaginator để hỗ trợ phân trang
        $columnDataPaginated = new LengthAwarePaginator(
            $columnDataPaginated,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $title = 'Thêm trường hồ sơ';
        return view('admins.pages.custom.index', compact('title', 'columnDataPaginated','comment'));
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

    public function store(Request $request)
    {
        // Xác thực các trường đầu vào
        $request->validate([
            'column_name' => 'required|string|max:255',
            'column_type' => 'required|in:string,integer,text',
            'is_required' => 'required|boolean',
        ]);

        $columnName = $request->input('column_name');
        $columnType = $request->input('column_type');
        $isRequired = $request->input('is_required');

        $result = $this->addColumnAndUpdateFillable($columnName, $columnType, $isRequired);

        return $result;
    }

    // Thêm cột và cập nhật các trường fillable
    public function addColumnAndUpdateFillable($columnName, $columnType, $isRequired)
    {

        $cleanColumnName = Str::lower(str_replace('-', '_', Str::slug($columnName)));

        if (!Schema::hasColumn('profiles', $cleanColumnName)) {
            Schema::table('profiles', function (Blueprint $table) use ($cleanColumnName, $columnType, $columnName, $isRequired) {

                if ($isRequired) {
                    $table->$columnType($cleanColumnName)->comment($columnName);
                } else {
                    $table->$columnType($cleanColumnName)->nullable()->comment($columnName);
                }
            });

            // Cập nhật thuộc tính fillable của model Profile
            $profile = new Profile();
            $fillable = $profile->getFillable();
            $fillable[] = $cleanColumnName;
            $profile->fillable($fillable);

            // Đọc và cập nhật mảng fillable_fields_profile.php
            $fillableFields = include     $arrayPath = app_path('Models/fillable_fields_profile.php');
            $fillableFields = array_values(array_unique($fillableFields)); // Loại bỏ các key và giữ các giá trị duy nhất
            $fillableFields[] = $cleanColumnName;
            $arrayPath =    $arrayPath = app_path('Models/array_vanban.php');
          //  File::put(app_path('Models/fillable_fields_profile.php'), '<?php' . PHP_EOL . 'return ' . var_export($fillableFields, true) . ';');

            file_put_contents(app_path('Models/fillable_fields_profile.php'), "<?php\n\nreturn " . var_export($fillableFields, true) . ";\n");

            return back()->with('success', 'Cột đã được thêm thành công!');
        } else {
            return back()->with('success', 'Cột đã tồn tại!');
        }
    }


    // Hàm để cập nhật mảng fillable từ file new_columns.php
    public function updateFillableArray($newColumns)
    {
        $fillableFields = require app_path('app/Models/fillable_fields_profile.php');

        foreach ($newColumns as $column) {
            $fillableFields[] = $column['name'];
        }

        return $fillableFields;
    }

    public function deleteColumn($column)
    {

        Schema::table('profiles', function ($table) use ($column) {
            $table->dropColumn($column);
        });

        // Đọc mảng fillable từ file fillable_fields_profile.php
        $fillableFields = include app_path('Models/fillable_fields_profile.php');

        // Xóa cột đã bị xóa khỏi mảng fillable
        $key = array_search($column, $fillableFields);
        if ($key !== false) {
            unset($fillableFields[$key]);
        }

        // Ghi lại mảng fillable mới vào file fillable_fields_profile.php
        $fillableFields = array_values($fillableFields); // Đảm bảo mảng không có key
        File::put(app_path('Models/fillable_fields_profile.php'), '<?php' . PHP_EOL . 'return ' . var_export($fillableFields, true) . ';');
        $cacheKey = 'duplicateValues';

        // Xóa dữ liệu trong session với key là $cacheKey
        session()->forget($cacheKey);
        return redirect()->back()->with('success', 'Cột đã được xóa thành công.');
    }
}
