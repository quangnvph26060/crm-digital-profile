<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\ZaloOa;
use App\Models\ZnsMessage;
use App\Services\Admins\ZaloOaService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZnsMessageController extends Controller
{
    protected $zaloOaService;
    public function  __construct(ZaloOaService $zaloOaService)
    {
        $this->zaloOaService = $zaloOaService;
    }

    public function znsMessage()
    {
        $activeOas = ZaloOa::where('is_active', 1)->pluck('id');

        $messages = ZnsMessage::whereIn('oa_id', $activeOas)->orderByDesc('sent_at')->get();

        $totalFeesByOa = $messages->groupBy('oa_id')->map(function ($messagesByOa) {
            return $messagesByOa->sum(function ($message) {
                return $message->status == 1 ? ($message->template->price ?? 0) : 0;
            });
        });
        Log::info('Messages:', ['messages' => $messages]);
        Log::info('Total Fees By OA:', ['totalFeesByOa' => $totalFeesByOa]);
        return view('admins.pages.zalo.messages', compact('messages', 'totalFeesByOa'));
    }


    public function znsQuota()
    {
        $accessToken = $this->zaloOaService->getAccessToken();
        try {
            $client = new Client();
            $response = $client->get('https://business.openapi.zalo.me/message/quota', [
                'headers' => [
                    'access_token' => $accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $responseBody = $response->getBody()->getContents();

            Log::info('Phản hồi APi: ' . $responseBody);
            $responseData = json_decode($responseBody, true)['data'];
            return view('admins.pages.zalo.quota', compact('responseData'));
        } catch (Exception $e) {
            Log::error('Cannot get Zns quota: ' . $e->getMessage());
            return ApiResponse::error('Cannot get Zns quota', 500);
        }
    }
}
