<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OverViewController extends Controller
{
    public function overview(Request $request)
    {
        $month = isset($request->month) ? $request->month : date("m");
        $year = isset($request->year) ? $request->year : date("Y");
        $end_day = date("t", strtotime("$year-$month-01"));
        $data["users"] = User::latest()
                             ->with([
                                    "missions" => function ($query) use ($month, $year, $end_day) {
                                        $query->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    },
                                    "kpis" => function ($query) use ($month, $year, $end_day) {
                                        $query->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    }
                             ])
                             ->withCount([
                                    "log_missions as post_new_expired" => function ($query) use ($month, $year, $end_day) {
                                        $query->where("status", 1)
                                              ->where("is_expired", 1)
                                              ->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    },
                                    "log_missions as total_post_need_edit" => function ($query) use ($month, $year, $end_day) {
                                        $query->where("status", 2)
                                              ->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    },
                                    "log_missions as post_edit_expired" => function ($query) use ($month, $year, $end_day) {
                                        $query->where("status", 4)
                                              ->where("is_expired", 1)
                                              ->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    },
                                    "log_missions as post_publish_expired" => function ($query) use ($month, $year, $end_day) {
                                        $query->where("status", 5)
                                              ->where("is_expired", 1)
                                              ->whereBetween("date", ["$year-$month-01", "$year-$month-$end_day"]);
                                    }
                             ])
                             ->get();
        $data["year"] = $year;
        $data["month"] = $month;

        return view("admins.pages.overview", $data);
    }
}
