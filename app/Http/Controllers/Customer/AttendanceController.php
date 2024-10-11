<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $check_in = $check_out = NULL;
        $logs = Attendance::query();
        if (isset($request->date_start) && $request->date_start) {
            $logs->where("checkin", ">=", $request->date_start . " 00:00:00");
        }
        if (isset($request->date_end) && $request->date_end) {
            $logs->where("checkin", "<=", $request->date_end . " 23:59:59");
        }
        $logs->where("user_id", auth()->user()->id)
            ->latest("checkin");
        return view("customers.pages.attendances.index", [
            "logs" => $logs->paginate(100),
            "inputs" => $request->all()
        ]);
    }

    public function checkIn()
    {
        Attendance::create([
            "user_id" => auth()->user()->id,
            "checkin" => date("Y-m-d H:i:s")
        ]);

        return back()->with("success", "Check-in thành công");
    }

    public function checkOut()
    {
        Attendance::where("user_id", auth()->user()->id)
                  ->whereDate("checkin", date("Y-m-d"))
                  ->update(["checkout" => date("Y-m-d H:i:s")]);

        return back()->with("success", "Check-out thành công");
    }
    public function updateNote(Request $request){
        $note = $request->input('note');
        $checkIn = $request->input('check_in');
        Attendance::where('user_id', auth()->user()->id)
        ->where('checkin', $checkIn)
        ->update(['note' => $note,'status'=> 1]);
        return back()->with("success", "Chú thích thành công");
    }
    public function updateStatus(Request $request){
        $status = $request->input('status');
        $checkIn = $request->input('check_in');
        $id = $request->input('id');
        Attendance::where('user_id', $id)
        ->where('checkin', $checkIn)
        ->update(['status' => $status]);
        return back()->with("success", "Thay đổi thành công");
    }

}
