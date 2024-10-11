<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SaralyController extends Controller
{
    public function list(Request $request)
    {
        $month = isset($request->month) ? $request->month : date("m");
        $year = isset($request->year) ? $request->year : date("Y");
        $end_day = date("t", strtotime("$year-$month-01"));
        $users = User::latest()
                     ->with([
                        'kpis' => function ($query) use ($month, $year, $end_day) {
                            $query->whereBetween("date_from", ["$year-$month-01", "$year-$month-$end_day"])
                                  ->whereBetween("date_to", ["$year-$month-01", "$year-$month-$end_day"]);
                        },
                        'log_missions' => function ($query) use ($month, $year, $end_day) {
                            $query->whereBetween('date', ["$year-$month-01", "$year-$month-$end_day"])
                                  ->where("is_expired", 0);
                        }
                    ])
                    ->get();

        return view("admins.pages.salary.list", [
            "users" => $users,
            "month" => $month,
            "year" => $year
        ]);
    }
}

