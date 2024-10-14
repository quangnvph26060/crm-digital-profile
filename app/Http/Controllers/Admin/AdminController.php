<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\Admins\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function list(Request $request)
    {
        $title = "Danh sách người dùng";
        $inputs = $request->all();
        $users = Admin::query();
        if (isset($request->name) && $request->name != '') {
            $users->where('full_name', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%');
        }

        return view('admins.pages.admins.list', [
            "users" => $users->latest()->paginate(20),
            "inputs" => $inputs,
            'title' => $title,
        ]);
    }
    public function add()
    {
        return view('admins.pages.admins.add');
    }
    public function store(Request $request)
    {
        try {

            $inputs = $request->except("_token");
            $inputs["password"] = bcrypt($inputs["password"]);

            $inputs["username"] = $inputs["full_name"];
            $inputs["role_code"] = 'admin_mkt';
            Admin::create($inputs);

            return back()->with('success', 'Thêm thành công');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return back()->with('error', 'Thêm thất bại');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $user = Admin::find($id);

            if (!$user) {
                return back()->with('error', 'Không tìm thấy người dùng cần chỉnh sửa.');
            }
            // $config->update([
            //     'agency_name' => $request->agency_name,
            //     'agency_code' => $request->agency_code,
            //     'font_name'   => $request->agency_name,
            //     'font_code'   => $request->font_code,
            //     'toc_name'    => $request->toc_name,
            // ]);
            $user->update([
                'full_name'   => $request->full_name,
                'username'    => $request->full_name,
                'email'       => $request->email,
                'status'      => 1,
                'level'       => $request->level,
            ]);
            return back()->with('success', 'Chỉnh sửa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $user = Admin::find($id);

        return view('admins.pages.admins.edit', ['user' => $user]);
    }
    public function delete($userId)
    {
        $user = Admin::find($userId);
        if ($user) {
            $user->delete();
            return back()->with('success', 'Xóa người dùng thành công');
        }
        return back()->with('error', 'Người dùng không tồn tại');
    }
}
