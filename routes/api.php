<?php

use App\Http\Controllers\HopController;
use App\Http\Controllers\HoSoController;
use App\Http\Controllers\InformationVbController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/district', function () {
    ///hgjgjjg

    return response()->json([
        "success" => true,
        "data" => [
            "id" => 1,
            "name" => "hà nội"
        ]
    ]);
});
Route::get('/phong-to-config', [ProfileController::class, 'PhongDetailToConfig'])->name('phong-to-config');
Route::get('/mucluc-to-phong', [ProfileController::class, 'MucLucDetailToPhong'])->name('mucluc-to-phong');
Route::get('/hopso-by-mucluc', [ProfileController::class, 'HopSoToMucLuc'])->name('hopso-to-mucluc');
Route::get('/mucluc-to-hopso', [ProfileController::class, 'MucLucDetailToHopSo'])->name('mucluc-to-hopso');

Route::get('/phong-by-config_id', [InformationVbController::class, 'PhongByConfigID'])->name('phong-by-config_id');
Route::get('/mucluc-by-phong_id', [InformationVbController::class, 'MucLucByPhongID'])->name('mucluc-by-phong_id');
Route::get('/hopso-by-mucluc', [InformationVbController::class, 'HopSoByMucLuc'])->name('hopso-by-mucluc');
Route::get('/hososo-by-hopso', [InformationVbController::class, 'HoSoSoByHopSo'])->name('hososo-by-hopso');

Route::post('/import', [ProfileController::class, 'import'])->name('import');

Route::get('/hop-so-phong-by-config_id', [HopController::class, 'PhongByConfigID'])->name('hop-so-phong-by-config_id');
Route::get('/hop-so-mucluc-by-phong_id', [HopController::class, 'MucLucByPhongID'])->name('hop-so-mucluc-by-phong_id');

Route::get('/hopso-by-mucluc', [HopController::class, 'HopSoByMucLuc'])->name('hop-so-mucluc-by-phong_id');

