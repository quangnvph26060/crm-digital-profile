<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admins\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function smtpForm()
    {
        return view('admins.pages.settings.smtp', $this->settingService->smtpForm());
    }

    public function storeSmtp(Request $request)
    {
        $result = $this->settingService->storeSmtp($request->except('_token'));

        return back()->with($result['success'], $result['message']);
    }
}
