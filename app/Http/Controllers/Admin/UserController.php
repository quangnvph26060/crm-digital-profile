<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditEmployeeRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admins\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function list(Request $request)
    {
        $inputs = $request->all();
        $users = User::query();
        if (isset($request->name) && $request->name != '') {
            $users->where('full_name', 'like', '%' . $request->name . '%')
                  ->orWhere('email', 'like', '%' . $request->name . '%')
                  ->orWhere('phone', 'like', '%' . $request->name . '%');
        }

        return view('admins.pages.users.list', [
            "users" => $users->latest()->paginate(20),
            "inputs" => $inputs
        ]);
    }

    public function add()
    {
        return view('admins.pages.users.add');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('admins.pages.users.edit', [
            "user" => $user
        ]);
    }

    public function delete($userId)
    {
      
        $user = User::find($userId);
        if ($user) {

            $user->status = $user->status === 1 ? 0 : 1;
            
            $user->save();

            return back()->with('success', 'Trạng thái đã được thay đổi thành công');
        }
        return back()->with('error', 'Người dùng không tồn tại');
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $inputs = $request->except("_token");
            $inputs["password"] = $inputs["password"] == "" ? $user->password : bcrypt($inputs["password"]);
            $user->update($inputs);

            return redirect()->route('admin.user.list')->with('success', 'Sửa thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Sửa thất bại');
        }
    }

    public function store(Request $request)
    {
        try {
            $inputs = $request->except("_token");
            $inputs["password"] = bcrypt($inputs["password"]);
            User::create($inputs);

            return back()->with('success', 'Thêm thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Thêm thất bại');
        }
    }
}
