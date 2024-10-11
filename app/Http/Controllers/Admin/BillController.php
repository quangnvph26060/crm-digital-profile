<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Admins\BillService;
use App\Services\Admins\ClientService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    protected $billService;
    protected $clientService;

    public function __construct(BillService $billService, ClientService $clientService)
    {
        $this->billService = $billService;
        $this->clientService = $clientService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $result = $this->billService->getPaginatedBill($query, $startDate, $endDate);
            $bills = $result->bills;
            $totalAmount = $result->total_money;

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admins.pages.bill.table', compact('bills', 'totalAmount'))->render(),
                    'pagination' => $bills->links('pagination::bootstrap-4')->render(),
                ]);
            }

            return view('admins.pages.bill.index', compact('bills', 'totalAmount'));
        } catch (Exception $e) {
            Log::error('Failed to get paginated Bill list: ' . $e->getMessage());
            throw new Exception("Failed to get paginated Bill list");
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $result = $this->billService->getPaginatedBill($query, $startDate, $endDate);
            $bills = $result->bills;
            $totalAmount = $result->total_money;

            if ($request->ajax()) {
                $html = view('admins.pages.bill.table', compact('bills', 'totalAmount'))->render();
                $pagination = $bills->appends(['query' => $query, 'start_date' => $startDate, 'end_date' => $endDate])->links('pagination::bootstrap-4')->render();
                return response()->json(['html' => $html, 'pagination' => $pagination]);
            }

            return view('admins.pages.bill.index', compact('bills', 'totalAmount'));
        } catch (Exception $e) {
            Log::error('Faield to search Bills: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search bills'], 500);
        }
    }

    public function add()
    {
        $clients = $this->clientService->getAllClient();
        return view('admins.pages.bill.add', compact('clients'));
    }

    public function store(Request $request)
    {
        try {
            $bills = $this->billService->createNewBill($request->all());
            return redirect()->route('admin.bill.index')->with('success', 'Tạo báo giá thành công');
        } catch (Exception $e) {
            Log::error('Failed to create new Bill: ' . $e->getMessage());
            throw new Exception('Failed to create new Bill');
        }
    }

    public function showClientInfor($id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client);
        } catch (Exception $e) {
            Log::error('Failed to get client info: ' . $e->getMessage());
            return response()->json(['error' => 'Client not found'], 404);
        }
    }

    public function searchCustomer(Request $request)
    {
        try {
            $query = $request->query('query');
            $clients = Client::where('name', 'like', "%{$query}%")->orWhere('phone', 'like', "%{$query}%")->get();
            return response()->json(['success' => true, 'customers' => $clients]);
        } catch (Exception $e) {
            Log::error("Failed to search clients: " . $e->getMessage());
            return response()->json(['error' => 'Failed to search clients'], 500);
        }
    }

    public function exportPDF($id)
    {
        try {
            $bill = $this->billService->getBillById($id);

            // Calculate subtotal by summing up the price of all items before tax
            $subtotal = $bill->billDetail->sum(function ($detail) {
                return $detail->amount * $detail->price;
            });

            // Calculate the tax amount based on the subtotal
            $tax_money = $subtotal * ($bill->tax / 100);

            // Data to pass to the view
            $data = [
                'invoice_number' => $bill->id,
                'invoice_date' => $bill->created_at->format('d/m/Y'),
                'client_name' => $bill->client->name,
                'client_company' => $bill->client->company_name,
                'client_address' => $bill->client->address,
                'client_tax_number' => $bill->client->tax_number,
                'client_phone' => $bill->client->phone,
                'client_email' => $bill->client->email,
                'items' => $bill->billDetail->map(function ($detail) {
                    return [
                        'name' => $detail->service_name,
                        'unit' => $detail->unit,
                        'quantity' => $detail->amount,
                        'unit_price' => $detail->price
                    ];
                })->toArray(),
                'subtotal' => $subtotal,
                'tax_money' => $tax_money,
                'tax' => $bill->tax,
                'total' => $bill->total_money
            ];

            $pdf = Pdf::loadView('pdf.bill', $data);
            $fileName = 'Báo giá_' . $bill->client->name . '_' . Carbon::parse($bill->created_at)->format('d-m-y') . '.pdf';

            return $pdf->download($fileName);
        } catch (Exception $e) {
            Log::error("Failed to export this bill: " . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xuất file pdf');
        }
    }

    public function delete($id)
    {
        try {
            $this->billService->deleteBill($id);
            return response()->json([
                'success' => 'Xóa báo giá thành công'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete this Bill: ' . $e->getMessage());
            return response()->json(['error' => 'Xóa báo giá thất bại', 500]);
        }
    }
}
