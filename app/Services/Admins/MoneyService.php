<?php

namespace App\Services\Admins;

use App\Models\PutMoney;
use App\Repositories\PutMoney\PutMoneyRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\DB;

class MoneyService
{
    protected $userRepository;

    protected $putMoneyRepository;

    public function __construct(
        UserRepository $userRepository,
        PutMoneyRepository $putMoneyRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->putMoneyRepository = $putMoneyRepository;
    }

    public function list($inputs)
    {
        $listPutMoney = $this->putMoneyRepository->list($inputs);

        return [
            'listPutMoney' => $listPutMoney
        ];
    }

    public function putMoney($inputs)
    {
        try {
            $user = $this->userRepository->checkUserByEmail(trim($inputs['email']));

            if (empty($user)) {
                return [
                    'success' => 'error',
                    'message' => 'Không tồn tại tài khoản này'
                ];
            }
            $money = str_replace(',', '', $inputs['money']);
            DB::beginTransaction();
            $this->putMoneyRepository->create([
                'shop_id' => $user->id,
                'user_id' => auth()->user()->id,
                'money' => $money,
                'note' => $inputs['note'],
                'status' => $inputs['submit'] == 'save-and-accept' ? PutMoney::STATUS_ACTIVE : PutMoney::STATUS_IN_ACTIVE
            ]);
            if ($inputs['submit'] == 'save-and-accept') {
                $this->userRepository->update($user->id, [
                    'balance' => DB::raw("balance+" . $money)
                ]);
            }
            DB::commit();

            return [
                'success' => 'success',
                'message' => 'Thêm thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return [
                'success' => 'error',
                'message' => 'Thêm thất bại'
            ];
        }
    }

    public function accept($id)
    {
        try {
            $putMoney = $this->putMoneyRepository->find($id);

            if ($putMoney->status == PutMoney::STATUS_ACTIVE) {
                return [
                    'success' => 'error',
                    'message' => 'Yêu cầu này đã được duyệt rồi'
                ];
            }
            DB::beginTransaction();
            $putMoney->update([
                'status' => PutMoney::STATUS_ACTIVE,
                'date_accept' => date('Y-m-d H:i:s')
            ]);
            $this->userRepository->update($putMoney->shop_id, [
                'balance' => DB::raw("balance+" . $putMoney->money)
            ]);
            DB::commit();

            return [
                'success' => 'success',
                'message' => 'Duyệt thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => 'error',
                'message' => 'Duyệt thất bại'
            ];
        }
    }

    public function reject($id)
    {
        try {
            $putMoney = $this->putMoneyRepository->find($id);

            if ($putMoney->status == PutMoney::STATUS_IN_ACTIVE) {
                return [
                    'success' => 'error',
                    'message' => 'Yêu cầu này đã từ chối rồi'
                ];
            }
            DB::beginTransaction();
            $putMoney->update([
                'status' => PutMoney::STATUS_IN_ACTIVE,
                'date_accept' => date('Y-m-d H:i:s')
            ]);
            $this->userRepository->update($putMoney->shop_id, [
                'balance' => DB::raw("balance-" . $putMoney->money)
            ]);
            DB::commit();

            return [
                'success' => 'success',
                'message' => 'Từ chối thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => 'error',
                'message' => 'Từ chối thất bại'
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->putMoneyRepository->delete($id);
            
            return [
                'success' => 'success',
                'message' => 'Xóa thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Từ chối thất bại'
            ];
        }
    }
}
