<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fanpage;
use App\Models\User;
use Illuminate\Http\Request;

class FanpageController extends Controller
{
    public function list(Request $request)
    {
        $fanpages = Fanpage::where(function ($query) use ($request) {
                                if (isset($request->user_id) && $request->user_id != -1) {
                                    $query->where("user_id", $request->user_id);
                                }
                            })
                            ->with("user")
                            ->withCount(["tracks" => function ($query) use ($request) {
                                if (isset($request->month) && $request->month != -1) {
                                    $query->whereMonth("created_at", $request->month);
                                }
                                if (isset($request->year) && $request->year != -1) {
                                    $query->whereYear("created_at", $request->year);
                                }
                            }])

                            ->get();

        return view("admins.pages.fanpages.list", [
            "inputs" => $request->all(),
            "fanpages" => $fanpages,
            "users" => User::all(),
            "month" => isset($request->month) ? $request->month : -1,
            "year" => isset($request->year) ? $request->year : -1
        ]);
    }

    public function delete($id)
    {
        $fanpage = Fanpage::whereId($id)->where("user_id", auth()->user()->id)->first();

        if (is_null($fanpage)) {
            return back()->with('error', 'Không tồn tại');
        }
        $fanpage->delete();

        return back()->with('success', 'Xóa thành công');
    }
}
