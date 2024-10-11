<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\OaTemplateController;
use App\Http\Controllers\Admin\PaymentSlipController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\ZaloController;
use App\Http\Controllers\Admin\ZnsMessageController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Models\Receipt;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dang-ky-mien-phi', [ClientController::class, 'addByLink'])->name('addByLink');
Route::get("/thong-tin-du-an-seo", "CustomerController@customerForm")->name("customer-form");
Route::post("/store-customer", "CustomerController@storeCustomer")->name("store-customer");
Route::get("/admin/customer/list", "CustomerController@getListCustomer")->name("customer-list")->middleware("is-login-admin","role-admin");
Route::get("/admin/customer/{id}/detail", "CustomerController@getDetailCustomer")->name("detail-customer")->middleware("is-login-admin");
Route::get("/admin/customer/{id}/delete", "CustomerController@delete")->name("delete-customer")->middleware("is-login-admin");
Route::get('/', 'AuthController@loginForm')->name('login');
Route::post('/login', 'AuthController@postLogin')->name('post-login');

// Route::get('/register', 'AuthController@registerForm')->name('register');
// Route::post('/register', 'AuthController@postRegister')->name('post-register');

// Route::get('/forget-password', 'AuthController@forgetPassword')->name('forget-password');
// Route::post('/forget-password', 'AuthController@postForgetPassword')->name('post-forget-password');

// Route::get('/reset-password/{token}', 'AuthController@resetPassword')->name('reset-password');
// Route::post('/reset-password/{token}', 'AuthController@postResetPassword')->name('post-reset-password');

// Route::get('/verify/{token}', 'AuthController@verifyEmail')->name('verify-email');

Route::get('admin/login', 'AuthController@loginFormAdmin')->name('login-admin');
Route::post('/admin/login', 'AuthController@postLoginAdmin')->name('post-login-admin');

Route::group(["prefix" => "cronjob"], function () {
    Route::get("/set-kpi", "CronjobController@setKpiAuto");
});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => 'is-login-admin'], function () {
    //config
    Route::prefix('config')->name('config.')->group(function () {
        Route::get('', [ConfigController::class, 'index'])->name('index');
        Route::get('/add-config', [ConfigController::class, 'add'])->name('add');
        Route::get('/edit-config/{id}', [ConfigController::class, 'edit'])->name('edit');
        Route::get('/get-agency-code', [ConfigController::class, 'getAgencyCode'])->name('get-agency-code');
        Route::post('/add-config', [ConfigController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [ConfigController::class, 'delete'])->name('delete');
        Route::post('/update-config/{id}', [ConfigController::class, 'update'])->name('update');
        // Route::get('/client/{id}', [ConfigController::class, 'showClientInfor'])->name('show');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('', [ProfileController::class, 'index'])->name('index');
        Route::get('/add-config', [ConfigController::class, 'add'])->name('add');
        Route::get('/edit-config/{id}', [ConfigController::class, 'edit'])->name('edit');
        Route::get('/get-agency-code', [ConfigController::class, 'getAgencyCode'])->name('get-agency-code');
        Route::post('/add-config', [ConfigController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [ConfigController::class, 'delete'])->name('delete');
        Route::post('/update-config/{id}', [ConfigController::class, 'update'])->name('update');
        // Route::get('/client/{id}', [ConfigController::class, 'showClientInfor'])->name('show');
    });
    Route::prefix('receipt')->name('receipt.')->group(function () {
        Route::get('', [ReceiptController::class, 'index'])->name('index');
        Route::get('/client/{id}', [ReceiptController::class, 'showClientInfor'])->name('show');
        Route::get('search', [ReceiptController::class, 'search'])->name('search');
        Route::get('add', [ReceiptController::class, 'add'])->name('add');
        Route::post('store', [ReceiptController::class, 'store'])->name('store');
        Route::get('customer-search', [ReceiptController::class, 'searchCustomer'])->name('searchCustomer');
        Route::get('export-pdf/{id}', [ReceiptController::class, 'exportPDF'])->name('export_pdf');
        Route::delete('delete/{id}', [ReceiptController::class, 'delete'])->name('delete');
    });
    Route::prefix('zalo')->name('zalo.')->group(function () {
        Route::prefix('oa')->name('oa.')->group(function () {
            Route::get('', [ZaloController::class, 'index'])->name('index');
            Route::get('/get-active-oa-name', [ZaloController::class, 'getActiveOaName'])->name('getActiveOaName');
            Route::post('/update-oa-status/{oaId}', [ZaloController::class, 'updateOaStatus'])->name('updateOaStatus');
            Route::post('/refresh-access-token', [ZaloController::class, 'refreshAccessToken'])->name('refreshAccessToken');
        });
        Route::prefix('message')->name('message.')->group(function () {
            Route::get('', [ZnsMessageController::class, 'znsMessage'])->name('znsmessage');
            Route::get('/quota', [ZnsMessageController::class, 'znsQuota'])->name('znsQuota');
        });
        Route::prefix('template')->name('template.')->group(function () {
            Route::get('', [OaTemplateController::class, 'templateIndex'])->name('znsTemplate');
            Route::get('refresh', [OaTemplateController::class, 'refreshTemplates'])->name('znsTemplateRefresh');
            Route::get('detail', [OaTemplateController::class, 'getTemplateDetail'])->name('znsTemplateDetail');
        });
    });
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('', [ClientController::class, 'index'])->name('index');
        Route::get('search', [ClientController::class, 'search'])->name('search');
        Route::delete('delete/{id}', [ClientController::class, 'delete'])->name('delete');
        Route::get('add', [ClientController::class, 'add'])->name('add');
        Route::post('store', [ClientController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ClientController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [ClientController::class, 'update'])->name('update');
        Route::post('storeByLink', [ClientController::class, 'storeByLink'])->name('storeByLink');
    });
    Route::prefix('bill')->name('bill.')->group(function () {
        Route::get('', [BillController::class, 'index'])->name('index');
        Route::get('/client/{id}', [BillController::class, 'showClientInfor'])->name('show');
        Route::get('search', [BillController::class, 'search'])->name('search');
        Route::get('add', [BillController::class, 'add'])->name('add');
        Route::post('store', [BillController::class, 'store'])->name('store');
        Route::get('customer-search', [BillController::class, 'searchCustomer'])->name('searchCustomer');
        Route::get('export-pdf/{id}', [BillController::class, 'exportPDF'])->name('export_pdf');
        Route::delete('delete/{id}', [BillController::class, 'delete'])->name('delete');
    });
    Route::prefix('paymentslip')->name('paymentslip.')->group(function () {
        Route::get('', [PaymentSlipController::class, 'index'])->name('index');
        Route::get('/client/{id}', [PaymentSlipController::class, 'showClientInfor'])->name('show');
        Route::get('search', [PaymentSlipController::class, 'search'])->name('search');
        Route::get('add', [PaymentSlipController::class, 'add'])->name('add');
        Route::post('store', [PaymentSlipController::class, 'store'])->name('store');
        Route::get('customer-search', [PaymentSlipController::class, 'searchCustomer'])->name('searchCustomer');
        Route::get('export-pdf/{id}', [PaymentSlipController::class, 'exportPDF'])->name('export_pdf');
        Route::delete('delete/{id}', [PaymentSlipController::class, 'delete'])->name('delete');
    });
    Route::get('/logout', 'DashboardController@logout')->name('logout');
    Route::get('/', 'DashboardController@dashboard')->name('dashboard')->middleware("role-admin");

    Route::group(["prefix" => "check-in", "as" => "check-in.",'middleware' => 'role-admin'], function () {
        Route::get("/", 'CheckInController@index')->name("index");
        Route::get("/pay-roll", 'CheckInController@getPayroll')->name("payroll");
    });

    Route::group(['prefix' => 'setting', 'as' => 'setting.', "middleware" => "role-admin"], function () {
        Route::get('/smtp', 'SettingController@smtpForm')->name('smtp-form');
        Route::post('/store-smtp', 'SettingController@storeSmtp')->name('store-smtp');
    });

  Route::group(["prefix" => "fanpage", "as" => "fanpage.",'middleware' => 'role-admin'], function () {
        Route::get("/list", "FanpageController@list")->name("list");
    });

    Route::group(['prefix' => 'mission', 'as' => 'mission.'], function () {
        Route::get('/add', 'MissionController@add')->name('add'); //->middleware("role-admin");
        Route::get('/{id}/edit', 'MissionController@edit')->name('edit'); //->middleware("role-admin");
        Route::post('/{id}/update', 'MissionController@update')->name('update'); //->middleware("role-admin");
        Route::post('/store', 'MissionController@store')->name('store'); //->middleware("role-admin");
        Route::get('/list', 'MissionController@list')->name('list');
        Route::get('/{id}/delete', 'MissionController@delete')->name('delete'); //->middleware("role-admin");
        Route::get('/{id}/comment', 'MissionController@comment')->name('comment')->middleware("role-admin");
        // Route::post('/{id}/comment', 'MissionController@storeComment')->name('store-comment');
        Route::post('/comment', 'MissionController@storeComment')->name('store-comment')->middleware("role-admin");
    });

    Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
        Route::get('/list', 'ProjectController@list')->name('list');
        Route::get('/add', 'ProjectController@add')->name('add');
        Route::post('/store', 'ProjectController@store')->name('store');
        Route::get('/{id}/edit', 'ProjectController@edit')->name('edit');
        Route::post('/{id}/update', 'ProjectController@update')->name('update');
        Route::get('/{id}/import', 'ProjectController@getViewImport')->name('import');
        Route::post('{id}/import', 'ProjectController@storeImport')->name('store-import');
        Route::post('{id}/store-handle', 'ProjectController@storeHandle')->name('store-handle');
        Route::get('/{id}/add-mission', 'ProjectController@getViewAddMission')->name('add-mission');
        Route::post('/{id}/store-mission', 'ProjectController@storeMission')->name('store-mission');
        Route::get('/{id}/export', 'ProjectController@export')->name('export');
    });

    Route::group(["prefix" => "user", "as" => "user.", "middleware" => "role-admin"], function () {
        Route::get('/list', 'UserController@list')->name('list');
        Route::get('/add', 'UserController@add')->name('add');
        Route::post('/store', 'UserController@store')->name('store');
        Route::get('/{id}/edit', 'UserController@edit')->name('edit');
        Route::post('/{id}/update', 'UserController@update')->name('update');
        Route::get("/{id}/delete", 'UserController@delete')->name("delete");
    });

	Route::group(["prefix" => "admin", "as" => "admin.", "middleware" => "role-admin"], function () {
        Route::get('/list', 'AdminController@list')->name('list');
        Route::get('/add', 'AdminController@add')->name('add');
        Route::post('/store', 'AdminController@store')->name('store');
        Route::get("/{id}/delete", 'AdminController@delete')->name("delete");
    });

    Route::group(["prefix" => "notification", "as" => "notification.", "middleware" => "role-admin"], function () {
        Route::get('/list', 'NotificationController@list')->name('list');
        Route::get('/add', 'NotificationController@add')->name('add');
        Route::post('/store', 'NotificationController@store')->name('store');
        Route::get('/{id}/delete', 'NotificationController@delete')->name('delete');
    });

    Route::group(['prefix' => 'role', 'as' => 'role.', "middleware" => "role-admin"], function () {
        Route::get('/list', 'RoleController@list')->name('list');
        Route::get('/add', 'RoleController@addForm')->name('add');
        Route::post('/store', 'RoleController@store')->name('store');
        Route::get('/{id}/delete', 'RoleController@delete')->name('delete');
        Route::get('/{id}/edit', 'RoleController@edit')->name('edit');
        Route::post('/{id}/update', 'RoleController@update')->name('update');
    });

    Route::group(['prefix' => 'permission', 'as' => 'permission.', "middleware" => "role-admin"], function () {
        Route::get('/list', 'PermissionController@list')->name('list');
        Route::get('/create', 'PermissionController@create')->name('create');
        Route::post('/store', 'PermissionController@store')->name('store');
        Route::get('/{id}/edit', 'PermissionController@edit')->name('edit');
        Route::post('/{id}/update', 'PermissionController@update')->name('update');
        Route::get('/{id}/delete', 'PermissionController@delete')->name('delete');
    });

    Route::group(["prefix" => "setting-kpi", "as" => "setting-kpi.", "middleware" => "role-admin"], function () {
        Route::get('/list', 'SettingKpiController@list')->name('list');
        Route::get('/add', 'SettingKpiController@add')->name('add');
        Route::get('/{id}/edit', 'SettingKpiController@edit')->name('edit');
        Route::post("/store", "SettingKpiController@store")->name("store");
        Route::post("/{id}/update", "SettingKpiController@update")->name("update");
        Route::get('/{id}/delete', 'SettingKpiController@delete')->name("delete");
    });
    Route::group(["prefix" => "salary", "as" => "salary.", "middleware" => "role-admin"], function () {
        Route::get('/list', "SaralyController@list")->name("list");
    });

    Route::group(["prefix" => "news", "as" => "news.", "middleware" => "role-admin"], function () {
        Route::get("/list", "NewsController@list")->name("list");
        Route::get("/add", "NewsController@add")->name("add");
        Route::post("/store", "NewsController@store")->name("store");
        Route::get("/{newsId}/edit", "NewsController@edit")->name("edit");
        Route::post("/{newsId}/update", "NewsController@update")->name("update");
        Route::get("/{newsId}/delete", "NewsController@delete")->name("delete");
    });

    Route::get('/overview', "OverViewController@overview")->name("overview")->middleware('role-admin');
});
// Route::group(['prefix' => 'customer', 'namespace' => 'Customer', 'as' => 'customer.'], function () {
//     Route::get('/logout', function () {
//         auth()->logout();

//         return redirect()->route('login');
//     })->name('logout');
//        Route::get('/', 'HomeController@index')->name('index')->middleware('auth');
//     Route::post('/userinfo', 'HomeController@store')->name('store')->name('store');
//     //Route::get('/attendance', 'AttendanceController@index')->name("attendance");
//     Route::group(["prefix" => "attendance", "as" => "attendance."], function () {
//         Route::get("/", "AttendanceController@index")->name("index");
//         Route::get("/check-in", "AttendanceController@checkIn")->name("check-in");
//         Route::get("/check-out", "AttendanceController@checkOut")->name("check-out");
//         Route::post("/update-note", "AttendanceController@updateNote")->name("update-note");
//         Route::post("/update-status", "AttendanceController@updateStatus")->name("update-status");
//     });
//     Route::group(["prefix" => "fanpage", "as" => "fanpage."], function () {
//         Route::get('/list', 'FanpageController@list')->name("list");
//         Route::post('/store', 'FanpageController@store')->name("store");
//         Route::get('/{id}/delete', 'FanpageController@delete')->name('delete');
//     });
//     Route::group(['prefix' => 'mission', 'as' => 'mission.'], function () {
//         Route::get('/', 'MissionController@getListMission')->name('list');
//         Route::post('/{id}/update', 'MissionController@update')->name('update');
//         Route::get('/{id}/comments', 'MissionController@getListCommentById');
//         Route::post('/comment', 'MissionController@storeComment')->name('comment');
//     });
//     Route::get("/them-viec", 'MissionController@addJob')->name("add-job");
//     Route::post("/store-job", "MissionController@storeJob")->name("store-job");
// });

// Route::get('/{code}', 'Customer\FanpageController@detail')->name("customer.fanpage.track");
// Route::group(["prefix" => "customer", "as" => "customer."], function () {
//     Route::get("/list", "CustomerController@listCustomer")->name("list");
//     Route::get("/create", "CustomerController@createCustomer")->name("create");
//     Route::post("/store", "CustomerController@store")->name("store");
// });
// Route::group(["prefix" => "news", "as" => "news."], function () {
//     Route::get("/{newsId}/detail", "Admin\NewsController@detail")->name("detail");
// });


