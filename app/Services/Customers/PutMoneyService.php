<?php

namespace App\Services\Customers;

use App\Repositories\PutMoney\PutMoneyRepository;

class PutMoneyService
{
    protected $putMoneyRepository;

    public function __construct(PutMoneyRepository $putMoneyRepository)
    {
        $this->putMoneyRepository = $putMoneyRepository;    
    }

    public function list()
    {
        return [
            'listPutMoney' => $this->putMoneyRepository->getPutMoneyByUser(auth()->user()->id)
        ];
    }

    public function delete($id)
    {
        $putMoney = $this->putMoneyRepository->find($id);

        if (empty($putMoney)) {
            return  [
                'success' => 'error',
                'message' => 'Không tồn tại yêu cầu này'
            ];
        }
        if ($putMoney->user_id != auth()->user()->id) {
            return  [
                'success' => 'error',
                'message' => 'Yêu cầu này không phải của bạn'
            ];
        }
        if ($putMoney->status) {
            return  [
                'success' => 'error',
                'message' => 'Yêu cầu này đã được duyệt nên không được xóa'
            ];
        }
        $putMoney->delete();

        return [
            'success' => 'success',
            'message' => 'Xóa thành công'
        ];
    }
}