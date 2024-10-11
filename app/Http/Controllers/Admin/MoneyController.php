<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admins\MoneyService;
use Illuminate\Http\Request;

class MoneyController extends Controller
{
    protected $moneyService;

    public function __construct(MoneyService $moneyService)
    {
        $this->moneyService = $moneyService;
    }
    
    public function list(Request $request)
    {
        return view('admins.pages.moneys.list', $this->moneyService->list($request->all()));
    }

    public function putMoney(Request $request)
    {
        $result = $this->moneyService->putMoney($request->all());

        return back()->with($result['success'], $result['message']);
    }

    public function accept($id)
    {
        $result = $this->moneyService->accept($id);

        return back()->with($result['success'], $result['message']);
    }

    public function reject($id)
    {
        $result = $this->moneyService->reject($id);

        return back()->with($result['success'], $result['message']);
    }

    public function delete($id)
    {
        $result = $this->moneyService->delete($id);

        return back()->with($result['success'], $result['message']);
    }

    public function listPutMoneyByShop()
    {
        return view('admins.pages.moneys.list', $this->moneyService->list($request->all()));
    }
}
