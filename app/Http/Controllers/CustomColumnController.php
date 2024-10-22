<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;

class CustomColumnController extends Controller
{
    public function index()
    {
        $columns = Profile::first()->getFillable();
        $title = 'Add cột mới';
        return view('admins/pages/custom/index', compact('title', 'columns'));
    }


    public function store(Request $request)
    {
        $columnName = $request->input('column_name');
        $columnType = $request->input('column_type');

        $result = $this->addColumnAndUpdateFillable($columnName, $columnType);

        return $result;
    }
    public function addColumnAndUpdateFillable($columnName, $columnType)
    {
       // Chuyển đổi tên cột sang dạng slug không dấu với dấu gạch dưới
    $cleanColumnName = Str::lower(str_replace('-', '_', Str::slug($columnName)));

    if (!Schema::hasColumn('profiles', $cleanColumnName)) {
        Schema::table('profiles', function (Blueprint $table) use ($cleanColumnName, $columnType) {
            $table->$columnType($cleanColumnName)->nullable();
        });

        // Cập nhật thuộc tính fillable của model Profile
        $profile = new Profile();
        $fillable = $profile->getFillable();
        $fillable[] = $cleanColumnName;
        $profile->fillable($fillable);

        // Đọc và cập nhật mảng fillable_fields_profile.php
        $fillableFields = include app_path('Models/fillable_fields_profile.php');
        $fillableFields = array_values(array_unique($fillableFields)); // Loại bỏ các key và giữ các giá trị duy nhất
        $fillableFields[] = $cleanColumnName;
        File::put(app_path('Models/fillable_fields_profile.php'), '<?php' . PHP_EOL . 'return ' . var_export($fillableFields, true) . ';');

        return 'Cột đã được thêm thành công và mảng fillable đã được cập nhật.';
    } else {
        return "Cột $columnName đã tồn tại.";
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

    public function delete($column)
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
    
        return redirect()->back()->with('success', 'Cột đã được xóa thành công.');
    }
}
