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
            'title' =>$title,
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
            \Log::info( 'Thêm thất bại. Lỗi: ' . $errorMessage);
            return back()->with('error', 'Thêm thất bại');
        }
    }
    public function delete($userId)
    {
      
        $user = Admin::find($userId);
        if ($user) {

            $user->status = $user->status === 1 ? 0 : 1;
            
            $user->save();

            return back()->with('success', 'Trạng thái đã được thay đổi thành công');
        }
        return back()->with('error', 'Người dùng không tồn tại');
    }

}
