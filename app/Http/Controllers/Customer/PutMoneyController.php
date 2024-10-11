<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreatePutMoneyRequest;
use App\Services\Customers\PutMoneyService;
use Illuminate\Http\Request;

class PutMoneyController extends Controller
{
    protected $putMoneyService;

    public function __construct(PutMoneyService $putMoneyService)
    {
        $this->putMoneyService = $putMoneyService;
    }

    public function list()
    {
        return view('customers.pages.put_money.list', $this->putMoneyService->list());
    }

    public function delete($id)
    {
        $result = $this->putMoneyService->delete($id);

        return back()->with($result['success'], $result['message']);
    }

    public function store(CreatePutMoneyRequest $request)
    {
        dd($request->all());
    }
}

