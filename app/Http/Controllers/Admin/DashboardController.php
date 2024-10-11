<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\SettingKpi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $date_from = isset($request->date_from) ? $request->date_from : date("Y-m-01");
        $date_end = isset($request->date_end) ? $request->date_end : date("Y-m-d");
        $users = User::with([
                        'kpis' => function ($query) use ($date_from, $date_end) {
                            $query->whereBetween("date", [$date_from, $date_end]);
                        },
                        'log_missions' => function ($query) use ($date_from, $date_end) {
                            $query->whereBetween('date', [$date_from, $date_end]);
                        }
                    ])
                    ->where("status", 1)
                    ->get();
        $totalPostEditAndPublish = Mission::whereBetween("date", [$date_from, $date_end])->get();

        return view('admins.pages.dashboard_new', [
            'date_from' => $date_from,
            'date_end' => $date_end,
            'totalPostEditAndPublish' => $totalPostEditAndPublish,
            'users' => $users,
        ]);
        // $kpis = SettingKpi::latest()
        //                   ->get();

        // if (count($kpis) > 0) {
        //     if (isset($request->date) && $request->date != '') {
        //         $date = $request->date;
        //         $date_from = explode("/", $request->date)[0];
        //         $date_to = explode("/", $request->date)[1];
        //     } else {
        //         $date = $kpis[0]->date_from . '/' . $kpis[0]->date_to;
        //         $date_from = $kpis[0]->date_from;
        //         $date_to = $kpis[0]->date_to;
        //     }
        //     $month = isset($request->month) ? $request->month : date('m');
        //     $year = isset($request->year) ? $request->year : date('Y');
        //     $week = isset($request->week) ? $request->week : getWeekNumberByDate(date("Y-m-d"), $month, $year);
        //     $users = User::whereHas(
        //                     'kpis', function ($query) use ($date_from, $date_to) {
        //                         $query->where("date_from", $date_from)
        //                               ->where("date_to", $date_to);
        //                     }
        //                 )
        //                  ->with([
        //                     'kpis' => function ($query) use ($date_from, $date_to) {
        //                         $query->where("date_from", $date_from)
        //                               ->where("date_to", $date_to);
        //                     },
        //                     'log_missions' => function ($query) use ($date_from, $date_to) {
        //                         $query->whereBetween('date', [$date_from, $date_to]);
        //                     }
        //                  ])
        //                  ->get();

        //     return view('admins.pages.dashboard_new', [
        //         'date' => $date,
        //         'date_from' => $date_from,
        //         'date_to' => $date_to,
        //         'kpis' => $kpis,
        //         'users' => $users,
        //     ]);
        // } else {
        //     return view('admins.pages.dashboard_new', [
        //         'kpis' => []
        //     ]);
        // }
    }

    public function dashboardOld(Request $request)
    {
        $yAxis = $xAxis = [];
        $date = isset($request->date) ? $request->date : date('Y-m-d');
        $missions = Mission::where('date', $date)
                           ->join("users", "users.id", "=", "missions.user_id")
                           ->get(["users.email", "missions.*"])
                           ->groupBy("email");
        foreach ($missions as $email => $missionByUser) {
            $xAxis[] = $email;
            if (count($missionByUser) == 0) {
                $yAxis[] = 0;
            } else {
                $yAxis[] = 100 * count($missionByUser->where('status', '>', 0))/count($missionByUser);
            }
        }

        return view('admins.pages.dashboard', [
            "date" => $date,
            "xAxis" => $xAxis,
            "yAxis" => $yAxis
        ]);
    }

    public function logout()
    {
        auth('admin')->logout();

        return redirect()->route('login-admin');
    }
}
