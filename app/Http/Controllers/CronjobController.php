<?php

namespace App\Http\Controllers;

use App\Models\SettingKpi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CronjobController extends Controller
{
    public function setKpiAuto()
    {
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];

        if ($weekday != "SU") {
            $users = User::where("post_number_per_day", ">", 0)->where("status", 1)->get();
            foreach ($users as $key => $userItem) {
                SettingKpi::updateOrCreate(
                    [
                        "date" => date("Y-m-d"),
                        "user_id" => $userItem->id
                    ], [
                        "post_new_num" => $userItem->post_number_per_day
                    ]
                );
            }

            return true;
        }
    }
}
