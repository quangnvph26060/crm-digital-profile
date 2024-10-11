<?php

namespace App\Services\Admins;

use App\Models\Client;
use App\Models\OaTemplate;
use App\Models\Receipt;
use App\Models\ZaloOa;
use App\Models\ZnsMessage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class ReceiptService
{
    protected $zaloOaService;
    protected $receipt;
    protected $client;

    public function __construct(Receipt $receipt, Client $client, ZaloOaService $zaloOaService)
    {
        $this->receipt = $receipt;
        $this->client = $client;
        $this->zaloOaService = $zaloOaService;
    }

    // public function getTotalAmount($query = null, $startDate = null, $endDate = null)
    // {
    //     try {
    //         $queryBuilder = $this->receipt->newQuery();

    //         if ($startDate) {
    //             $queryBuilder->whereDate('created_at', '>=', $startDate);
    //         }
    //         if ($endDate) {
    //             $queryBuilder->whereDate('created_at', '<=', $endDate);
    //         }
    //         if ($query) {
    //             $clientIds = $this->client->where('name', 'like', "%{$query}%")
    //                 ->orWhere('phone', 'like', "%{$query}%")
    //                 ->pluck('id');

    //             $queryBuilder->where(function ($q) use ($query, $clientIds) {
    //                 $q->where('note', 'like', "%{$query}%")
    //                     ->orWhereIn('client_id', $clientIds);
    //             });
    //         }

    //         return $queryBuilder->sum('amount');
    //     } catch (Exception $e) {
    //         Log::error("Failed to get total amount: " . $e->getMessage());
    //         throw new Exception("Failed to get total amount");
    //     }
    // }


    public function getReceiptsByDate($date)
    {
        return Receipt::whereDate('created_at', $date)->orderByDesc('created_at')
            ->paginate(10); // Adjust pagination as needed
    }

    public function getPaginatedReceipt($query, $startDate, $endDate)
    {
        try {
            $queryBuilder = Receipt::with('client'); // Load thông tin khách hàng

            if ($query) {
                // Lọc theo tên khách hàng
                $queryBuilder->whereHas('client', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                        ->orWhere('phone', 'like', "%{$query}%");
                });
            }
            if ($startDate) {
                $queryBuilder->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $queryBuilder->whereDate('created_at', '<=', $endDate);
            }

            $receipts = $queryBuilder->orderByDesc('created_at')->paginate(10);
            $totalAmount = $queryBuilder->sum('amount'); // Tính tổng số tiền cho các bản ghi đã lọc

            return (object) [
                'receipts' => $receipts,
                'totalAmount' => $totalAmount,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get paginated receipts: ' . $e->getMessage());
            throw $e;
        }
    }



    public function getAllReceipt()
    {
        try {
            return $this->receipt->orderByDesc('created_at')->paginate(10);
        } catch (Exception $e) {
            Log::error("Failed to get receipt list: " . $e->getMessage());
            throw new Exception('Failed to get receipt list');
        }
    }

    public function getReceiptById($id)
    {
        try {
            return $this->receipt->find($id);
        } catch (Exception $e) {
            Log::error('Failed to find this receipt: ' . $e->getMessage());
            throw new Exception('Failed to find this receipt');
        }
    }

    public function createReceipt(array $data)
    {
        DB::beginTransaction();
        $totalMoney = preg_replace('/[^\d]/', '', $data['amount']);
        try {
            $receipt = $this->receipt->create([
                'amount' => $totalMoney,
                'note' => $data['note'],
                'client_id' => $data['client_id'],
            ]);

            // $accessToken = $this->zaloOaService->getAccessToken();
            // $oa_id = ZaloOa::where('is_active', 1)->first()->id;

            // try {
            //     // Gửi yêu cầu tới API Zalo
            //     $client = new GuzzleHttpClient();
            //     $response = $client->post('https://business.openapi.zalo.me/message/template', [
            //         'headers' => [
            //             'access_token' => $accessToken,
            //             'Content-Type' => 'application/json',
            //         ],
            //         'json' => [
            //             'phone' => preg_replace('/^0/', '84', $receipt->client->phone),
            //             'template_id' => '358801',
            //             'template_data' => [
            //                 'name' => $receipt->client->name,
            //                 'order_code' => $receipt->id,
            //                 'date' => Carbon::now()->format('d/m/y'), // Định dạng ngày tháng cụ thể
            //                 'price' => $receipt->amount,
            //                 'payment' => 'Chuyển khoản',
            //                 'custom_field' => $receipt->note,
            //                 'phone' => $receipt->client->phone,
            //             ]
            //         ]
            //     ]);

            //     $responseBody = $response->getBody()->getContents();
            //     Log::info('API response: ' . $responseBody);

            //     $responseData = json_decode($responseBody, true);
            //     $status = $responseData['error'] == 0 ? 1 : 0;

            //     $template_id = OaTemplate::where('template_id', '358801')->first()->id;

            //     // Lưu thông tin vào cơ sở dữ liệu
            //     ZnsMessage::create([
            //         'name' => $receipt->client->name,
            //         'phone' => $receipt->client->phone,
            //         'sent_at' => Carbon::now(),
            //         'status' => $status,
            //         'note' => $responseData['message'],
            //         'template_id' => $template_id,
            //         'oa_id' => $oa_id,
            //     ]);

            //     if ($status == 1) {
            //         Log::info('Gửi ZNS thành công');
            //     } else {
            //         Log::error('Gửi ZNS thất bại: ' . $response->getBody());
            //     }
            // } catch (Exception $e) {
            //     Log::error('Lỗi khi gửi tin nhắn: ' . $e->getMessage());

            //     // Lưu thông tin tin nhắn vào cơ sở dữ liệu khi gặp lỗi
            //     ZnsMessage::create([
            //         'name' => $receipt->client->name,
            //         'phone' => $receipt->client->phone,
            //         'sent_at' => Carbon::now(),
            //         'status' => 0,
            //         'note' => $e->getMessage(),
            //         'oa_id' => $oa_id,
            //     ]);
            // }

            DB::commit();
            return $receipt;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create new receipt:" . $e->getMessage());
            throw new Exception("Failed to create new receipt");
        }
    }

    public function deleteReceipt($id)
    {
        DB::beginTransaction();
        try {
            $receipt = $this->getReceiptById($id);
            $receipt->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete this receipt: ' . $e->getMessage());
            throw new Exception("Failed to delete this receipt");
        }
    }
}
