<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingKpi;
use App\Models\User;
use Illuminate\Http\Request;

class SettingKpiController extends Controller
{
    public function store(Request $request)
    {
        try {
            $inputs = $request->except("_token");
            //$inputs["month"] = convertNumber($inputs["month"]);
            //$getRangeDateFromWeekNumber = getRangeDateFromWeekNumber($inputs["week"], $inputs["month"], $inputs["year"]);
            //$inputs["date_from"] = $getRangeDateFromWeekNumber["date_start"];
            //$inputs["date_to"] = $getRangeDateFromWeekNumber["date_end"];
            SettingKpi::create($inputs);

            return back()->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return back()->withInput()->with("error", "Vui lòng thử lại");
        }
    }

    public function delete($id)
    {
        SettingKpi::whereId($id)->delete();

        return back()->with("success", "Xóa thành công");
    }

    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->except("_token");
            //$inputs["month"] = convertNumber($inputs["month"]);
            //$getRangeDateFromWeekNumber = getRangeDateFromWeekNumber($inputs["week"], $inputs["month"], $inputs["year"]);
            //$inputs["date_from"] = $getRangeDateFromWeekNumber["date_start"];
            //$inputs["date_to"] = $getRangeDateFromWeekNumber["date_end"];
            SettingKpi::whereId($id)->update($inputs);

            return redirect()->route('admin.setting-kpi.list')->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return back()->withInput()->with("error", "Vui lòng thử lại");
        }
    }

    public function add()
    {
        $users = User::all();

        return view("admins.pages.setting_kpis.add", [
            "users" => $users
        ]);
    }

    public function edit($id)
    {
        $users = User::all();
        $kpi = SettingKpi::find($id);

        return view("admins.pages.setting_kpis.edit", [
            "users" => $users,
            "kpi" => $kpi
        ]);
    }

    public function list(Request $request)
    {
        $kpis = SettingKpi::query();
        $users = User::all();

        return view("admins.pages.setting_kpis.list", [
            "kpis" => $kpis->latest('date')->with('user')->paginate(20),
            "inputs" => $request->all(),
            "users" => $users
        ]);
    }
}
