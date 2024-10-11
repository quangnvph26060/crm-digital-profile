<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Client;
use App\Services\Admins\ClientService;
use App\Services\Admins\PaymentSlipService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentSlipController extends Controller
{
    protected $paymentSlipService;
    protected $clientService;

    public function __construct(PaymentSlipService $paymentSlipService, ClientService $clientService)
    {
        $this->paymentSlipService = $paymentSlipService;
        $this->clientService = $clientService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $result = $this->paymentSlipService->getPaginatedPaymentSlip($query, $startDate, $endDate);
            $paymentslips = $result->paymentslips;
            $totalAmount = $result->totalAmount;

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admins.pages.paymentslip.table', compact('paymentslips', 'totalAmount'))->render(),
                    'pagination' => $paymentslips->links('pagination::bootstrap-4')->render(),
                ]);
            }
            return view('admins.pages.paymentslip.index', compact('paymentslips', 'totalAmount'));
        } catch (Exception $e) {
            Log::error("Failed to get paginated Payment Slip list: " . $e->getMessage());
            throw new Exception('Failed to get pagniated Payment Slip list');
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $result = $this->paymentSlipService->getPaginatedPaymentSlip($query, $startDate, $endDate);
            $paymentslips = $result->paymentslips;
            $totalAmount = $result->totalAmount;

            if ($request->ajax()) {
                $html = view('admins.pages.paymentslip.table', compact('paymentslips', 'totalAmount'))->render();
                $pagination = $paymentslips->appends(['query' => $query, 'start_date' => $startDate, 'end_date' => $endDate])->links('pagination::bootstrap-4')->render();
                return response()->json([
                    'html' => $html,
                    'pagination' => $pagination,
                ]);
            }
            return view('admins.pages.paymentslip.index', compact('paymentslips', 'totalAmount'));
        } catch (Exception $e) {
            Log::error('Failed to search PaymentSlip: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search payment slips'], 500);
        }
    }

    public function add()
    {
        $clients = $this->clientService->getAllClient();
        return view('admins.pages.paymentslip.add', compact('clients'));
    }

    public function store(Request $request)
    {
        try {
            $paymentslips = $this->paymentSlipService->createPaymentSlip($request->all());
            return redirect()->route('admin.paymentslip.index')->with('success', 'Tạo phiếu chi thành công');
        } catch (Exception $e) {
            Log::error('Failed to create new Payment Slip: ' . $e->getMessage());
            throw new Exception('Failed to create new Payment Slip');
        }
    }

    public function showClientInfor($id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client);
        } catch (Exception $e) {
            Log::error('Faield to get client infor: ' . $e->getMessage());
            return response()->json(['error' => 'Client not found'], 404);
        }
    }

    public function searchCustomer(Request $request)
    {
        try {
            $query = $request->query('query');
            $clients = Client::where('name', 'LIKE', "%{$query}%")
                ->orWhere('phone', 'LIKE', "%{$query}%")
                ->get();
            return response()->json(['success' => true, 'customers' => $clients]);
        } catch (Exception $e) {
            Log::error('Failed to search clients: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search clients'], 500);
        }
    }

    public function exportPDF($id)
    {
        try {
            $paymentslip = $this->paymentSlipService->getPaymentSlipById($id);

            $pdf = Pdf::loadView('pdf.paymentslip', compact('paymentslip'));
            $fileName = 'Phiếu chi dành cho khách hàng ' . $paymentslip->client->name . '.pdf';

            return $pdf->download($fileName);
        } catch (Exception $e) {
            Log::error('Failed to export this Payment Slip:' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xuất file pdf');
        }
    }

    public function delete($id)
    {
        try {
            $this->paymentSlipService->deletePaymentSlip($id);
            return response()->json([
                'success' => 'Xóa phiếu chi thành công.',
            ]);
        } catch (Exception $e) {
            Log::error("Failed to delete this Payment Slip: " . $e->getMessage());
            return ApiResponse::error("Xoá phiếu chi thất bại", 500);
        }
    }
}
