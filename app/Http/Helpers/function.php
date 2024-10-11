<?php

function is_admin() {
    if (auth()->user()->role_code == 'admin') {

    }
}

function getWeekNumberByDate($date, $month, $year)
{
    $endDate = date("t", strtotime("$year-$month-01"));
    if (strtotime($date) >= strtotime("$year-$month-01") && strtotime($date) <= strtotime("$year-$month-07")) {
        return 1;
    } else if (strtotime($date) >= strtotime("$year-$month-08") && strtotime($date) <= strtotime("$year-$month-14")) {
        return 2;
    } else if (strtotime($date) >= strtotime("$year-$month-15") && strtotime($date) <= strtotime("$year-$month-21")) {
        return 3;
    } else if (strtotime($date) >= strtotime("$year-$month-22") && strtotime($date) <= strtotime("$year-$month-$endDate")) {
        return 4;
    }
}

function getDayOfWeek($dateOfWeek) {
    $dateOfWeekJapan = [
        'Monday'    => 'T2',
        'Tuesday'   => 'T3',
        'Wednesday' => 'T4',
        'Thursday'  => 'T5',
        'Friday'    => 'T6',
        'Saturday'  => 'T7',
        'Sunday'    => 'CN',
    ];

    if (array_key_exists($dateOfWeek, $dateOfWeekJapan)) {
        return $dateOfWeekJapan[$dateOfWeek];
    }

    return '';
}


function getRangeDateFromWeekNumber($week, $month, $year)
{
    $endDate = date("t", strtotime("$year-$month-01"));
    if ($week == 1) {
        return [
            "date_start" => "$year-$month-01",
            "date_end" => "$year-$month-07"
        ];
    } else if ($week == 2) {
        return [
            "date_start" => "$year-$month-08",
            "date_end" => "$year-$month-14"
        ];
    } else if ($week == 3) {
        return [
            "date_start" => "$year-$month-15",
            "date_end" => "$year-$month-21"
        ];
    } else if ($week == 4) {
        return [
            "date_start" => "$year-$month-22",
            "date_end" => "$year-$month-$endDate"
        ];
    }
}

function convertNumber($number)
{
    if ($number < 10) {
        return "0" . $number;
    }

    return $number;
}
