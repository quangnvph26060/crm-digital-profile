<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Fanpage;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FanpageController extends Controller
{
    public function list(Request $request)
    {
        $fanpages = Fanpage::where("user_id", auth()->user()->id)
                            ->withCount(["tracks" => function ($query) use ($request) {
                                if (isset($request->month) && $request->month != -1) {
                                    $query->whereMonth("created_at", $request->month);
                                }
                                if (isset($request->year) && $request->year != -1) {
                                    $query->whereYear("created_at", $request->year);
                                }
                            }])
                            ->get();

        return view("customers.pages.fanpages.list", [
            "inputs" => $request->all(),
            "fanpages" => $fanpages
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "link" => "required"
        ]);
        try {
            Fanpage::create([
                "user_id" => auth()->user()->id,
                "name" => $request->name,
                "link" => $request->link,
                "code" => \Str::random(8)
            ]);

            return back()->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return back()->with("error", "Vui lòng thử lại");
        }
    }

    public function detail($code)
    {
        $fanpage = Fanpage::where("code", $code)->first();

        if (empty($fanpage)) {
            return back();
        }
        $ip = $this->get_client_ip();

        if ($ip !== "UNKNOWN") {
            $track = Track::where("ip", $ip)
                          ->where("fanpage_id", $fanpage->id)
                          ->latest()
                          ->first();
            if (!empty($track)) {
                $created_at = Carbon::parse($track->created_at)->addMinutes(60);
                if (strtotime($created_at) < strtotime(date("Y-m-d H:i:s"))) {
                    Track::create([
                        "ip" => $ip,
                        "fanpage_id" => $fanpage->id
                    ]);
                }
            } else {
                Track::create([
                    "ip" => $ip,
                    "fanpage_id" => $fanpage->id
                ]);
            }

            return redirect($fanpage->link);
        }

        return back();
    }

    public function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}
