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
    public function index(Request $request)
    {
        $comment             = $this->getColumnComments('profiles');
        $columnData = $this->getColumnData('profiles');
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $columnDataPaginated = $this->paginateData($columnData, $perPage, $currentPage);

        $title = 'Thêm trường hồ sơ';
        return view('admins.pages.custom.index', compact('title', 'columnDataPaginated', 'comment'));
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
        return redirect()->route('admin.thongtinhoso')->with('success', 'Cột đã được xóa thành công.');
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

    public function editColumn($column, Request $request)
    {
        $title               = 'Cập nhật trường hồ sơ';
        $perPage             = 10;

        $profiles            = $this->getColumnDetail('profiles', $column);
        $comment             = $this->getColumnComments('profiles');
        $columnData          = $this->getColumnData('profiles');

        $currentPage         = $request->input('page', 1);
        $columnDataPaginated = $this->paginateData($columnData, $perPage, $currentPage);
        return view('admins.pages.custom.edit', compact('title', 'columnDataPaginated', 'comment', 'profiles'));
    }

    public function updateColumn($column, Request $request)
    {
        // $request->validate([
        //     'column_name' => 'required|string|max:255',
        //     'column_type' => 'required|in:string,integer,text',
        //     'is_required' => 'required|boolean',
        // ]);
        $profiles = $this->getColumnDetail('profiles', $column);
        $columnName = $request->input('column_name');
        $columnType = $request->input('column_type');
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
        $flag = false;
        Schema::table('profiles', function (Blueprint $table) use ($cleanColumnName, $column, $columnType, $newType, $columnName, $isRequired) {
            if ($isRequired == "1") {
                if ($cleanColumnName == $column) {
                    DB::statement("UPDATE profiles SET $cleanColumnName = '' WHERE $cleanColumnName IS NULL");
                }

                DB::statement("ALTER TABLE profiles CHANGE $column $cleanColumnName $newType  NOT NULL  COMMENT '$columnName'");
            } else {
                if ($cleanColumnName == $column) {
                    DB::statement("UPDATE profiles SET $cleanColumnName = '' WHERE $cleanColumnName IS NULL");
                }

                DB::statement("ALTER TABLE profiles CHANGE $column $cleanColumnName $newType   DEFAULT NULL  COMMENT '$columnName'");
            }
        });
        // Cập nhật mảng fillable_fields_profile.php
        $fillableFields = include app_path('Models/fillable_fields_profile.php');
        $fillableFields = array_values(array_unique($fillableFields));

        // Xóa "ghi_chu" nếu đã tồn tại trong mảng
        $index = array_search($column, $fillableFields);
        if ($index !== false) {
            unset($fillableFields[$index]);
        }

        if (!in_array($cleanColumnName, $fillableFields)) {
            $fillableFields[] = $cleanColumnName;
            file_put_contents(app_path('Models/fillable_fields_profile.php'), "<?php\n\nreturn " . var_export($fillableFields, true) . ";\n");
        }

        return redirect()->route('admin.thongtinhoso')->with('success', 'Cột đã được cập nhật thành công!');
    }
}
