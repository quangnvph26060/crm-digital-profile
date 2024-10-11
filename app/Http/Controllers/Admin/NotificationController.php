<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function list()
    {
        $notifications = Notification::whereNull('admin_id')
                                     ->whereNotNull('user_id')
                                     ->with('user')
                                     ->latest()
                                     ->paginate(20);

        return view("admins.pages.notifications.list", [
            "notifications" => $notifications
        ]);
    }

    public function add()
    {
        $users = User::all();

        return view("admins.pages.notifications.add", [
            "users" => $users
        ]);
    }

    public function store(Request $request)
    {
        $inputs = $request->except("_token");
        $inputs["status"] = 0;
        Notification::create($inputs);

        return back()->with("success", "Thêm thành công");
    }

    public function delete($id)
    {
        Notification::whereId($id)->delete();

        return back()->with("success", "Xóa thành công");
    }
}
