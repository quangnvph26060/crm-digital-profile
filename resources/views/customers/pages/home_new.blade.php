@extends('customers.layouts.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notiItem)
                <div class="alert alert-warning">{!! $notiItem->name !!}</div>
            @endforeach
        @endif
        <div class="col-6">
            <p style="text-align: center">Vui lòng chấm công trước khi làm việc.</p>
            <p style="text-align: center">Thời gian làm việc: Sáng: 8h00 - 12h00, Chiều: 13h30-17h00</p>
            <p style="text-align: center">Từ thứ 2 đến thứ 7 (Không bao gồm ngày nghỉ, lễ theo quy định)</p>
        </div>
        <div class="col-6">
            @if (session('success'))
                <div style="text-align: center" class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row" style="justify-content: center">
                <div class="col-lg-6">
                    <a style="width: 100%; font-size: 20px" class="btn btn-primary"
                        href="{{ empty($check_in) ? route('customer.attendance.check-in') : '#' }}">
                        {{ !empty($check_in) ? $check_in : 'Check-in' }}
                    </a>
                </div>
            </div>
            <div class="row" style="justify-content: center; margin-top: 10px">
                <div class="col-lg-6">
                    <a style="width: 100%; font-size: 20px" class="btn btn-danger"
                        href="{{ empty($check_out) && !empty($check_in) ? route('customer.attendance.check-out') : '#' }}">
                        {{ !empty($check_out) ? $check_out : 'Check-out' }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12" style="margin-top: 50px">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Biểu đồ tổng quan trong tháng</h4>
            </div>
        </div>
        <div class="col-lg-12">
            <form method="GET">
                <div class="row">
                    <div class="col-lg-3 form-group">
                        <label for="">Từ ngày</label>
                        <input type="date" class="form-control" name="date_from" value="{{ $date_from }}">
                    </div>
                    <div class="col-lg-3 form-group">
                        <label for="">Đến ngày</label>
                        <input type="date" class="form-control" name="date_end" value="{{ $date_end }}">
                    </div>
                    <div class="col-lg-2 form-group">
                        <label style="opacity: 0" for="">1</label> <br>
                        <button type="submit" class="btn btn-success">Lọc</button>
                    </div>
                </div>
            </form>
            <br>
            <br>
            <div id="chart-container">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 style="display: flex;
    text-wrap: nowrap;">
                            {{ auth()->user()->full_name }} -  <span class="col-12 text-center">
                                <p  class="update-user"  data-bs-toggle="modal" data-bs-target="#myModal">
                                   Cập nhật thông tin
                                </p>
                            </span>
                        </h3>
                        <div>
                            <p class="d-flex" style="justify-content: space-between;">
                                <b>Viết bài mới:</b>
                                @php
                                    $totalPostAssign = $user->log_missions->where('status', 1)->count();
                                @endphp
                                <span>
                                    <b class="text text-success">
                                        {{ $totalPostAssign . '/' . $user->kpis->sum('post_new_num') }} bài
                                    </b>
                                    -
                                    <b class="text text-danger">
                                        @php
                                            $percent =
                                                $user->kpis->sum('post_new_num') == 0
                                                    ? 0
                                                    : (100 * $totalPostAssign) / $user->kpis->sum('post_new_num');
                                        @endphp
                                        {{ number_format($percent) }}%
                                    </b>
                                </span>
                            </p>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%"
                                    aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p>
                                <b>Số bài hiện tại đang cần sửa: <span
                                        class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('status', 2))) }}</span></b>
                            </p>
                            <p>
                                <b>Số bài hiện tại đã sửa: <span
                                        class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('status', 4))) }}</span></b>
                            </p>
                            <p>
                                <b>Số bài hiện tại được đăng: <span
                                        class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('status', 3))) }}</span></b>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h3>Tin nội bộ</h3>
                        <ul>
                            @foreach ($news as $item)
                                <a href="{{ route('news.detail', ['newsId' => $item->id]) }}">
                                    <li>
                                        {{ $item->title }}
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

    <div class="modal fade " id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" method="POST" action="{{ route('customer.storestore') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- File Upload Fields -->
                        <div class="mb-3">
                            <label for="file1" class="form-label">Căn cước công dân mặt trước</label>
                            <input class="form-control" name="font_identification_card" type="file" id="file1" required>
                        </div>
                        <div class="mb-3">
                            <label for="file2" class="form-label">Căn cước công dân mặt sau</label>
                            <input class="form-control" name="back_identification_card" type="file" id="file2" required>
                        </div>
    
                        <!-- Bank Information Fields -->
                        <div class="mb-3">
                            <label for="bankName" class="form-label">Tên ngân hàng</label>
                            <input type="text" name="bank" class="form-control" id="bankName" placeholder="Tên ngân hàng" required>
                        </div>
                        <div class="mb-3">
                            <label for="accountNumber" class="form-label">Số tài khoản</label>
                            <input type="text" name="account_number" class="form-control" id="accountNumber" placeholder="Số tài khoản" required>
                        </div>
    
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success w-100">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('showModal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                myModal.show();
            });
        </script>
    @endif
  
    <style>
        #chart-container {
            position: relative;
            height: 500px;
            margin: auto;
            width: 100%;
            overflow: hidden;
        }
        .update-user{
            align-items: start;
            display: flex;
            font-size: 14px;
            color: #777272;
            margin-top: 10px;
            padding-left: 10px;
            cursor: pointer;
        }
    </style>
@endsection
