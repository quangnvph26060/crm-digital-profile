<?php

namespace App\Services\Admins;

use App\Models\OaTemplate;
use App\Models\ZaloOa;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OaTemplateService
{

    protected $zaloOa, $oaTemplate, $client;

    public function __construct(ZaloOa $zaloOa, OaTemplate $oaTemplate)
    {
        $this->zaloOa = $zaloOa;
        $this->oaTemplate = $oaTemplate;
        $this->client = new Client();
    }

    public function getAllTemplateByOaId()
    {
        try {
            $oa_id = ZaloOa::where('is_active', 1)->first()->id;
            return $this->oaTemplate->where('oa_id', $oa_id)->get();
        } catch (Exception $e) {
            Log::error('Failed to get templates: ' . $e->getMessage());
            throw new Exception("Failed to get templates");
        }
    }

    public function checkTemplate()
    {
        DB::beginTransaction();
        try {
            $zaloOa = $this->zaloOa->where('is_active', 1)->first();

            if (!$zaloOa) {
                Log::warning('No active Zalo OA found');
                return 'No active ZaloOa found';
            }

            $accessToken = $zaloOa->access_token;
            Log::info('Access Token: ' . $accessToken);

            $response = $this->client->get('https://business.openapi.zalo.me/template/all', [
                'headers' => [
                    'access_token' => $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'offset' => 0,
                    'limit' => 100,
                ],
                'timeout' => 30,
            ]);

            $responseBody = $response->getBody()->getContents();
            Log::info('Api Response: ' . $responseBody);

            $responseData = json_decode($responseBody, true);

            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $templates = $responseData['data'];
                foreach ($templates as $template) {
                    if (isset($template['templateId']) && isset($template['templateName']) && in_array($template['status'], ['PENDING_REVIEW', 'ENABLE'])) {
                        $existingTemplate = $this->oaTemplate
                            ->where('template_id', $template['templateId'])
                            ->where('oa_id', $zaloOa->id)
                            ->first();

                        if (!$existingTemplate) {
                            $this->oaTemplate->create([
                                'oa_id' => $zaloOa->id,
                                'template_id' => $template['templateId'],
                                'template_name' => $template['templateName'],
                            ]);
                        }

                        // Lấy thông tin chi tiết của template và cập nhật giá
                        $templateDetailResponse = $this->client->get('https://business.openapi.zalo.me/template/info', [
                            'headers' => [
                                'access_token' => $accessToken,
                                'Content-Type' => 'application/json',
                            ],
                            'query' => [
                                'template_id' => $template['templateId'],
                            ],
                            'timeout' => 30,
                        ]);

                        $templateDetailBody = $templateDetailResponse->getBody()->getContents();
                        Log::info('Template Detail API Response: ' . $templateDetailBody);

                        $templateDetailData = json_decode($templateDetailBody, true);

                        if (isset($templateDetailData['data'])) {
                            $templateDetailData = $templateDetailData['data'];
                            // Cập nhật giá trong cơ sở dữ liệu
                            $this->oaTemplate->updateOrCreate(
                                ['template_id' => $template['templateId'], 'oa_id' => $zaloOa->id],
                                ['price' => $templateDetailData['price'] ?? null]
                            );
                        } else {
                            Log::error("Template detail response does not contain 'data'. Response: " . print_r($templateDetailData, true));
                        }
                    } else {
                        Log::warning('Template missing required fields or status is rejected: ' . print_r($template, true));
                    }
                }
                DB::commit();
                return 'Template processed successfully';
            } else {
                Log::error("Invalid response structure from Zalo API");
                DB::rollBack();
                return 'Invalid response structure from Zalo API';
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to process template: " . $e->getMessage());
            return 'Failed to process template: ' . $e->getMessage();
        }
    }


    public function getTemplateById($template_id, $oa_id)
    {
        $accessToken = $this->zaloOa->where('id', $oa_id)->first()->access_token;
        try {
            $response = $this->client->get('https://business.openapi.zalo.me/template/info', [
                'headers' => [
                    'access_token' => $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'template_id' => $template_id,
                ],
            ]);
            $responseBody = $response->getBody()->getContents();
            Log::info('Api response: ' . $responseBody);
            $responseData = json_decode($responseBody, true)['data'];
            return $responseData;
        } catch (Exception $e) {
            Log::error('Failed to find template: ' . $e->getMessage());
            throw new Exception("Failed to find template: " . $e->getMessage());
        }
    }
}
