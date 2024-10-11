<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Admins\OaTemplateService;
use App\Services\Admins\ZaloOaService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OaTemplateController extends Controller
{
    protected $zaloOaService;
    protected $oaTemplateService;

    public function __construct(ZaloOaService $zaloOaService, OaTemplateService $oaTemplateService)
    {
        $this->zaloOaService = $zaloOaService;
        $this->oaTemplateService = $oaTemplateService;
    }

    public function templateIndex()
    {
        $templates = $this->oaTemplateService->getAllTemplateByOaID();
        $initialTemplateData = null;

        if ($templates->isNotEmpty()) {
            $initialTemplateData = $this->oaTemplateService->getTemplateById($templates->first()->template_id, $templates->first()->oa_id);
        }

        return view('admins.pages.zalo.template.template', compact('templates', 'initialTemplateData'));
    }

    public function getTemplateDetail(Request $request)
    {
        $templateId = $request->input('template_id');
        $accessToken = $this->zaloOaService->getAccessToken();

        if (!$accessToken) {
            Log::error('Access token is missing or invalid');
            return ApiResponse::error('Access token is missing or invalid', 401);
        }

        try {
            $client = new Client();
            $response = $client->get('https://business.openapi.zalo.me/template/info', [
                'headers' => [
                    'access_token' => $accessToken,
                    'Content-Type' => 'application/json'
                ],
                'query' => [
                    'template_id' => $templateId
                ],
            ]);

            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            if (isset($responseData['error']) && $responseData['error'] !== 0) {
                $errorMessage = $responseData['message'] ?? 'Unknown error';
                Log::error('API Error: ' . $errorMessage);
                return ApiResponse::error('Failed to get template details: ' . $errorMessage, 500);
            }

            if (isset($responseData['data']) && !empty($responseData['data'])) {
                return view('admins.pages.zalo.template.template_detail', [
                    'responseData' => $responseData['data']
                ]);
            } else {
                Log::error('Template detail response does not contain "data" or is empty. Response: ' . print_r($responseData, true));
                return ApiResponse::error('No data or invalid response structure', 500);
            }
        } catch (Exception $e) {
            Log::error('Failed to get template details: ' . $e->getMessage());
            return ApiResponse::error('Failed to get template details', 500);
        }
    }

    public function refreshTemplates()
    {
        try {
            $status = $this->oaTemplateService->checkTemplate();
            $templates = $this->oaTemplateService->getAllTemplateByOaId();

            $options = '';
            foreach ($templates as $template) {
                $options .= '<option value="' . $template->template_id . '">' . htmlspecialchars($template->template_name) . '</option>';
            }

            $initialTemplateData = null;
            if ($templates->isNotEmpty()) {
                $initialTemplateData = $this->oaTemplateService->getTemplateById($templates->first()->template_id, $templates->first()->oa_id);
            }

            return response()->json([
                'templates' => $options,
                'initialTemplateData' => $initialTemplateData
            ]);
        } catch (Exception $e) {
            Log::error('Failed to refresh templates: ' . $e->getMessage());
            return ApiResponse::error('Failed to refresh templates', 500);
        }
    }
}
