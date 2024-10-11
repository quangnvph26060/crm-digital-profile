<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CheckinExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckInController extends Controller
{
    public function index(Request $request)
    {
        $date_start = (isset($request->date_start) && $request->date_start != '') ? $request->date_start : date("Y-m-d");
        $date_to = (isset($request->date_to) && $request->date_to != '') ? $request->date_to : date("Y-m-d");
        $logs = Attendance::query();
        if (isset($request->user_id) && $request->user_id != -1) {
            $logs->where("user_id", $request->user_id);
        }
        $logs->where("checkin", ">=", $date_start . ' 00:00:00');
        $logs->where("checkin", '<=',$date_to . ' 23:59:59');
        $period = CarbonPeriod::create($date_start, $date_to);
        if ($request->submit == "export") {
            $users = User::whereHas("attendances")
                         ->with(['attendances' => function ($query) use ($date_start, $date_to) {
                            $query->where("checkin", ">=", $date_start . ' 00:00:00')
                                  ->where("checkin", "<=", $date_to . ' 23:59:59');
                         }])
                         ->where("status", 1)
                         ->get();
            return \Excel::download(new CheckinExport($logs->get(), $date_start, $date_to, $period, $users), 'check-in.xlsx');
        }

        return view("admins.pages.checkin.index", [
            "inputs" => $request->all(),
            "period" => $period,
            "users" => User::where('status',1)->get(), //  "users" => User::all(),
            "logs" => $logs->paginate(50),
            "month" => isset($request->date_start) ? $request->date_start : "",
            "year" => isset($request->date_to) ? $request->date_to : ""
        ]);
    }
    public function getPayroll(Request $request)
    {
        $date_start = (isset($request->date_start) && $request->date_start != '') ? $request->date_start : date("Y-m-d");
        $date_to = (isset($request->date_to) && $request->date_to != '') ? $request->date_to : date("Y-m-d");
        
        // lấy ra tháng hiên tại
        $currentMonth =  (isset($request->month) && $request->month != '') ? $request->month : Carbon::now()->month;
        $userID = $request->user_id;
        $query =  User::whereHas("attendances", function ($query) use ($currentMonth) {
            $query->whereMonth("checkin", $currentMonth);
        });
        if (!empty($userID)) {
            $query->where("id", $userID);
        }

        $users = $query->get();
        $period = CarbonPeriod::create($date_start, $date_to);
        $period1 = Attendance::whereMonth("checkin",$currentMonth)->where('status',0)->get();
        if ($request->submit == "export") {
            $users = User::whereHas("attendances")
                         ->where("status", 1)
                         ->get();
            return \Excel::download(new CheckinExport($logs->get(), $date_start, $date_to, $period, $users), 'check-in.xlsx');
        }
        return view("admins.pages.checkin.payroll", [
            "inputs" => $request->all(),
            "period" => $period,
            "users" => $users,//  "users" => User::all(),
            "list_users" => User::where('status', 1)->get(),
            "period1" => $period1,
            // "logs" => $logs->paginate(50),
            "month" => $currentMonth,
            "year" => isset($request->date_to) ? $request->date_to : ""
        ]);
    }
}
