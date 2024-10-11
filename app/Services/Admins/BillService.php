<?php

namespace App\Services\Admins;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillService
{
    protected $bill;
    protected $billDetail;
    protected $client;

    public function __construct(Bill $bill, BillDetail $billDetail, Client $client)
    {
        $this->client = $client;
        $this->bill = $bill;
        $this->billDetail = $billDetail;
    }

    public function getPaginatedBill($query, $startDate, $endDate)
    {
        try {
            $queryBuilder = Bill::with('client');

            if ($query) {
                $queryBuilder->whereHas('client', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%");
                });
            }
            if ($startDate) {
                $queryBuilder->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $queryBuilder->whereDate('created_at', '<=', $endDate);
            }

            $bills = $queryBuilder->orderByDesc('created_at')->paginate(10);
            $totalAmount = $queryBuilder->sum('total_money');

            return (object)[
                'bills' => $bills,
                'total_money' => $totalAmount,
            ];
        } catch (Exception $e) {
            Log::error('Failed to get paginated bill list: ' . $e->getMessage());
            throw new Exception('Failed to get paginated bill list');
        }
    }

    public function getBillById($id)
    {
        try {
            return $this->bill->find($id);
        } catch (Exception $e) {
            Log::error('Failed to find this bill: ' . $e->getMessage());
            throw new Exception('Failed to find this bill');
        }
    }

    public function createNewBill(array $data)
    {
        DB::beginTransaction();
        try {

            // Xử lý total_money để loại bỏ ký tự không hợp lệ
            $totalMoney = preg_replace('/[^\d\.]/', '', $data['total_money']);
            // dd($totalMoney);
            // Tạo Bill
            $bill = $this->bill->create([
                'total_money' => $totalMoney,
                'client_id' => $data['client_id'],
                'tax' => $data['tax'],
            ]);

            // Tạo BillDetail
            if (!empty($data['bill_details']) && is_array($data['bill_details'])) {
                $details = [];
                foreach ($data['bill_details'] as $detail) {
                    $details[] = new BillDetail([
                        'service_name' => $detail['service_name'],
                        'unit' => $detail['unit'],
                        'amount' => $detail['amount'],
                        'price' => preg_replace('/[^\d\.]/', '', $detail['price']),
                    ]);
                }
                $bill->billDetail()->saveMany($details);
            }

            DB::commit();
            return $bill;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create new bill: ' . $e->getMessage());
            throw new Exception('Failed to create new bill');
        }
    }

    public function deleteBill($id)
    {
        DB::beginTransaction();
        try {
            $bill = $this->getBillById($id);
            $bill->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete this bill: " . $e->getMessage());
            throw new Exception("Failed to delete this bill");
        }
    }
}
