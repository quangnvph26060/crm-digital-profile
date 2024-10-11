<?php

namespace App\Services\Admins;

use App\Models\Client;
use App\Models\PaymentSlip;
use App\Models\Receipt;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentSlipService
{
    protected $paymentSlip;
    protected $client;

    public function __construct(PaymentSlip $paymentSlip, Client $client)
    {
        $this->paymentSlip = $paymentSlip;
        $this->client = $client;
    }

    public function getPaginatedPaymentSlip($query, $startDate, $endDate)
    {
        try {
            $queryBuilder = PaymentSlip::with('client');

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

            $paymentslips = $queryBuilder->orderByDesc('created_at')->paginate(10);
            $totalAmount = $queryBuilder->sum('amount');
            return (object)[
                'paymentslips' => $paymentslips,
                'totalAmount' => $totalAmount,
            ];
        } catch (Exception $e) {
            Log::error('Failed to get paginated payment slips: ' . $e->getMessage());
            throw new Exception('Failed to get paginated payment slips');
        }
    }

    public function getAllPaymentSlip()
    {
        try {
            return $this->paymentSlip->orderByDesc('created_at')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to get payment slip list: ' . $e->getMessage());
            throw new Exception('Failed to get payment slip list');
        }
    }

    public function getPaymentSlipById($id)
    {
        try {
            return $this->paymentSlip->find($id);
        } catch (Exception $e) {
            Log::error('Failed to find this payment slip:' . $e->getMessage());
            throw new Exception('Failed to find this payment slip');
        }
    }

    public function createPaymentSlip(array $data)
    {
        DB::beginTransaction();
        $totalMoney = preg_replace('/[^\d]/', '', $data['amount']);
        try {
            $paymentSlip = $this->paymentSlip->create([
                'amount' => $totalMoney,
                'note' => $data['note'],
                'client_id' => $data['client_id'],
            ]);

            DB::commit();
            return $paymentSlip;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create new payment slip: ' . $e->getMessage());
            throw new Exception('Failed to create new payment slip');
        }
    }

    public function deletePaymentSlip($id)
    {
        DB::beginTransaction();
        try {
            $paymentSlip = $this->getPaymentSlipById($id);
            $paymentSlip->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete this paymentslip: " . $e->getMessage());
            throw new Exception("Failed to delete this payment slip");
        }
    }
}
