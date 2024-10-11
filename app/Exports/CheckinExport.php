<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CheckinExport implements FromView
{
    protected $logs;

    protected $date_start;

    protected $date_to;

    protected $period;

    protected $users;

    public function __construct($logs, $date_start, $date_to, $period, $users)
    {
        $this->logs = $logs;
        $this->date_start = $date_start;
        $this->date_to = $date_to;
        $this->period = $period;
        $this->users = $users;
    }

    public function view(): View
    {
        return view('exports.checkin_new', [
            'logs' => $this->logs,
            'date_start' => $this->date_start,
            'date_to' => $this->date_to,
            'period' => $this->period,
            'users' => $this->users
        ]);
    }
}
