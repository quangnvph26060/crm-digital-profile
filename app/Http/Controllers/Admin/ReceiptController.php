<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Admins\ClientService;
use App\Services\Admins\ReceiptService;
use App\Services\Admins\ZaloOaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    protected $receiptService;
    protected $clientService;
    protected $zaloOaService;

    public function __construct(ReceiptService $receiptService, ClientService $clientService, ZaloOaService $zaloOaService)
    {
        $this->receiptService = $receiptService;
        $this->clientService = $clientService;
        $this->zaloOaService = $zaloOaService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Nhận đối tượng từ dịch vụ
            $result = $this->receiptService->getPaginatedReceipt($query, $startDate, $endDate);
            $receipts = $result->receipts;
            $totalAmount = $result->totalAmount;

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admins.pages.receipt.table', compact('receipts', 'totalAmount'))->render(),
                    'pagination' => $receipts->links('pagination::bootstrap-4')->render(),
                ]);
            }
            return view('admins.pages.receipt.index', compact('receipts', 'totalAmount'));
        } catch (Exception $e) {
            Log::error('Failed to get paginated Receipt list: ' . $e->getMessage());
            throw new Exception('Failed to get paginated Receipt list');
        }
    }


    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $result = $this->receiptService->getPaginatedReceipt($query, $startDate, $endDate);
            $receipts = $result->receipts;
            $totalAmount = $result->totalAmount; // Đảm bảo biến này được gán giá trị

            if ($request->ajax()) {
                $html = view('admins.pages.receipt.table', compact('receipts', 'totalAmount'))->render();
                $pagination = $receipts->appends(['query' => $query, 'start_date' => $startDate, 'end_date' => $endDate])->links('pagination::bootstrap-4')->render();
                return response()->json(['html' => $html, 'pagination' => $pagination]);
            }

            return view('admins.pages.receipt.index', compact('receipts', 'totalAmount'));
        } catch (Exception $e) {
            Log::error('Failed to search receipts: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search receipts'], 500);
        }
    }


    public function add()
    {
        $clients = $this->clientService->getAllClient();
        return view('admins.pages.receipt.add', compact('clients'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $receipts = $this->receiptService->createReceipt($request->all());
            // dd($clients);
            return redirect()->route('admin.receipt.index')->with('success', 'Thêm phiếu thu thành công');
        } catch (Exception $e) {
            Log::error('Failed to create new Receipt: ' . $e->getMessage());
            throw new Exception("Failed to create new Receipt");
        }
    }

    public function showClientInfor($id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client);
        } catch (Exception $e) {
            Log::error("Failed to get client info: " . $e->getMessage());
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
            Log::error("Failed to search clients: " . $e->getMessage());
            return response()->json(['error' => 'Failed to search clients'], 500);
        }
    }

    public function showDateReceipts(Request $request)
    {
        $date = $request->input('show_date');
        $receipts = $this->receiptService->getReceiptsByDate($date);

        return response()->json([
            'table' => view('admins.pages.receipt.table', ['receipts' => $receipts])->render(),
            'pagination' => $receipts->links('pagination::bootstrap-4')->render(), // Trả về liên kết phân trang
        ]);
    }

    public function exportPDF($id)
    {
        try {
            $receipt = $this->receiptService->getReceiptById($id);

            $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));
            $fileName = 'Phiếu thu của khách hàng ' . $receipt->client->name . '.pdf';

            return $pdf->download($fileName);
        } catch (Exception $e) {
            Log::error('Failed to export this Receipt: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xuất file pdf');
        }
    }

    public function delete($id)
    {
        try {
            $this->receiptService->deleteReceipt($id);
            return response()->json(['success' => 'Xóa phiếu thu thành công ']);
        } catch (Exception $e) {
            Log::error('Failed to delete this Receipt: ' . $e->getMessage());
            return response()->json(['error' => 'Xóa phiếu thu thất bại', 500]);
        }
    }
}
