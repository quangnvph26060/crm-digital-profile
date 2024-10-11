<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Mission;
use App\Models\News;
use App\Models\Notification;
use App\Models\SettingKpi;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $date_from = isset($request->date_from) ? $request->date_from : date("Y-m-01");
        $date_end = isset($request->date_end) ? $request->date_end : date("Y-m-d");
        $user = User::whereId(auth()->user()->id)
                    ->with([
                        'kpis' => function ($query) use ($date_from, $date_end) {
                            $query->whereBetween("date", [$date_from, $date_end]);
                        },
                        'log_missions' => function ($query) use ($date_from, $date_end) {
                            $query->whereBetween('date', [$date_from, $date_end]);
                        }
                    ])
                    ->first();
        $totalPostEditAndPublish = Mission::whereBetween("date", [$date_from, $date_end])
                                          ->where("user_id", auth()->user()->id)->get();
        $check_in = $check_out = NULL;
        $data = Attendance::where("user_id", auth()->user()->id)
                        ->whereDate("checkin", date("Y-m-d"))
                        ->first();

        if (!empty($data)) {
            $check_in = !empty($data->checkin) ? date("H:i", strtotime($data->checkin)) : NULL;
            $check_out = !empty($data->checkout) ? date("H:i", strtotime($data->checkout)) : NULL;
        }

        return view('customers.pages.home_new', [
            'date_from' => $date_from,
            'date_end' => $date_end,
            'totalPostEditAndPublish' => $totalPostEditAndPublish,
            'user' => $user,
            'notifications' => Notification::where('type', 'general')->latest()->get(),
            'news' => News::latest()->get(),
            "check_in" => $check_in,
            "check_out" => $check_out
        ]);

    }

    public function index_old(Request $request)
    {
        $series = [];
        $month = isset($request->month) ? $request->month : date('m');
        $year = isset($request->year) ? $request->year : date('Y');
        $max_day = date('t', strtotime("$year-$month-01"));
        $range_day = CarbonPeriod::create(date("$year-$month-01"), date("$year-$month-$max_day"));
        $missions = Mission::whereMonth('date', $month)
                           ->whereYear('date', $year)
                           ->with('user')
                           ->oldest('date')
                           ->join("users", "users.id", "=", "missions.user_id")
                           ->get(["users.email", "missions.*"])
                           ->groupBy('email')
                           ->map(function($query) {
                                return $query->groupBy("date");
                           });
                        //    dd($missions);
        foreach ($missions as $email => $missionByDate) {
            $series[] = [
                "name" => $email,
                "type" => 'bar',
                "data" => $this->getPercent($missionByDate, $range_day)
            ];
        }
        return view('customers.pages.home', [
            'missions' => $missions,
            'series' => $series,
            'range_day' => $range_day,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function getPercent($missionByDate, $range_day)
    {
        $data = [];
        foreach($range_day as $dayItem) {
            if (empty($missionByDate[$dayItem->format('Y-m-d')])) {
                $data[] = 0;
            } else {
                $keyFinish = count($missionByDate[$dayItem->format('Y-m-d')]->where('status', '>', 0));
                $data[] = 100 * $keyFinish/count($missionByDate[$dayItem->format('Y-m-d')]);
            }
        }
        // foreach ($missionByDate as $date => $items) {
        //     $keyFinish = count($items->where('status', '>', 0));
        //     $data[] = $keyFinish/count($items) * 100;
        // }

        return $data;
    }
    private function saveImages($request, string $inputName, string $directory = 'images'): ?array
    {
        $paths = [];
    
        // Kiểm tra xem có file không
        if ($request->hasFile($inputName)) {
            // Lấy tất cả các file hình ảnh
            $images = $request->file($inputName);
    
            if (!is_array($images)) {
                $images = [$images]; // Đưa vào mảng nếu chỉ có 1 ảnh
            }
    
            foreach ($images as $image) {
                // Tạo tên file duy nhất
                $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();
    
                // Lưu file ảnh vào storage
                $path = $image->storeAs($directory, $filename, 'public'); // Lưu vào thư mục public storage
    
                // Lưu đường dẫn vào mảng
                $paths[] = $path;
            }
    
            // Trả về danh sách các đường dẫn
            return $paths;
        }
    
        // Trả về null nếu không có file nào được gửi
        return null;
    }
    
    public function store(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
    
        try {
            $request->validate([
                'font_identification_card' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'back_identification_card' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bank' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
            ]);
    
            // Gọi hàm saveImages để lưu ảnh
            $fontPath = $this->saveImages($request, 'font_identification_card', 'identification_cards');
            $backPath = $this->saveImages($request, 'back_identification_card', 'identification_cards');
    
            // Kiểm tra xem cả hai ảnh đã được lưu thành công hay chưa
            if (is_null($fontPath) || is_null($backPath)) {
                return back()->with('error', 'Lỗi khi lưu ảnh.');
            }
    
            // Cập nhật dữ liệu vào bảng user_info
            $user->update([
                'font_identification_card' => $fontPath[0], 
                'back_identification_card' => $backPath[0], 
                'bank' => $request->bank,
                'account_number' => $request->account_number,
            ]);
    
            return back()->with('success', 'Thông tin đã được cập nhật thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ghi lại lỗi xác thực vào log
            \Log::error('Validation errors: ', $e->errors());
            return back()->withErrors($e->errors())->withInput(); // Trả về các lỗi cụ thể
        } catch (\Exception $e) {
            // Ghi lại bất kỳ lỗi nào khác
            \Log::error('Error updating user info: ' . $e->getMessage(), [
                'request_data' => $request->all(), // Log dữ liệu yêu cầu để dễ xác định lỗi
            ]);
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật thông tin. Vui lòng thử lại.');
        }
    }
    
    
    
}
