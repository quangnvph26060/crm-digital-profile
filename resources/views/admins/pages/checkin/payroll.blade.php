@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Bảng lương</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">User</label>
                                        <select name="user_id" class="form-control" id="">
                                            <option value="">
                                                Tất cả
                                            </option>
                                            @foreach ($list_users as $item)
                                                <option value="{{ $item->id }}" @if(isset($inputs["user_id"]) && $inputs["user_id"] == $item->id){{ 'selected' }}@endif>
                                                    {{ $item->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3" >
                                    <div class="form-group">
                                        <label for="">Tháng</label>
                                        {{-- <input type="date" name="date_start" value="{{ isset($inputs['date_start']) ? $inputs['date_start'] : '' }}" class="form-control"> --}}
                                        <select name="month" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" @if ($i == $month) {{ 'selected' }} @endif>
                                                    Tháng {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="display: none">
                                    <div class="form-group">
                                        <label for="">Từ</label>
                                        <input type="date" name="date_start" value="{{ isset($inputs['date_start']) ? $inputs['date_start'] : '' }}" class="form-control">
                                        {{-- <select name="month" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" @if ($i == $month) {{ 'selected' }} @endif>
                                                    Tháng {{ $i }}
                                                </option>
                                            @endfor
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3"  style="display: none">
                                    <div class="form-group">
                                        <label for="">Đến</label>
                                        <input type="date" name="date_to" value="{{ isset($inputs['date_to']) ? $inputs['date_to'] : '' }}" class="form-control">
                                        {{-- <select name="year" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            @for($i = 2023; $i <= date("Y"); $i++)
                                                <option value="{{ $i }}" @if ($i == $year) {{ 'selected' }} @endif>
                                                    Năm {{ $i }}
                                                </option>
                                            @endfor
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" name="submit" value="search" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <button type="submit" name="submit" value="export" class="btn btn-success">Xuất Excel</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @include('globals.alert')
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tháng</th>
                                            <th>Nhân viên</th>
                                            <th>Lương cơ bản</th>
                                            <th>Tổng cộng ngày công</th>
                                            <th>Lương nhận được</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalAllDayWork = 0;
                                            $dataOverview = [];
                                        @endphp
                                            @foreach ($users as $key => $item)
                                                @php
                                                    $totalDayWork = 0;
                                                @endphp
                                                <tr>
                                                    <td >{{ $key + 1 }}</td>
                                                    <td>{{ $month }}/{{ \Carbon\Carbon::now()->format('Y') }}</td>
                                                    <td >{{ $item->full_name }}</td>
                                                    <td>{{ number_format($item->salary, 0, ',', '.')}}</td>
                                                 
                                                    @foreach ($period1->where('user_id', $item->id) as $dateItem)
                                                        @php
                                                          
                                                            $checkin = \Carbon\Carbon::parse($dateItem->checkin);
                                                            $checkout = \Carbon\Carbon::parse($dateItem->checkout);
                                                            $diffMinute = $checkin->diffInMinutes($checkout);
                                                       
                                                          
                                                            if ($dateItem->checkout != '' && $diffMinute/60 <= 4 ) {
                                                                $totalDayWork += 0.5;
                                                            }
                                                            elseif($dateItem->checkout != '' ) {
                                                                $totalDayWork += 1;
                                                            }
                                                            elseif($dateItem->checkout == '' &&  $dateItem->status === 0 && $dateItem->note != ""  ) {
                                                                $totalDayWork += 1;
                                                            }
                                                        @endphp
                                                    @endforeach
                                                <td>
                                                    {{ $totalDayWork }} 
                                                </td>
                                                <td>
                                                    @php
                                                        $result_salary = $item->salary/26;
                                                        $sum_salary = number_format($result_salary * $totalDayWork, 0, ',', '.');
                                                    @endphp
                                                        {{ $sum_salary }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" id="btnOpenModal" 
                                                    data-user-id = "{{$item->id}}"
                                                    data-user-name = "{{$item->full_name}}"
                                                    data-user-phone = "{{$item->phone}}"
                                                    data-user-email = "{{$item->email}}"
                                                    data-user-salary = "{{$item->salary}}"
                                                    data-user-bank = "{{$item->bank}}"
                                                    data-user-account-number = "{{$item->account_number}}"
                                                    data-user-day-salary = "{{$totalDayWork}}"
                                                    data-user-sum-salary = "{{$sum_salary}}"
                                                    >Trả lương</button>
                                                </td>
                                                </tr>
                                            @endforeach
                                        {{-- @foreach ($logs as $key => $item)
                                            @php
                                                $checkin = \Carbon\Carbon::parse($item->checkin);
                                                $diffMinute = $checkin->diffInMinutes($item->checkout);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ date("m/Y", strtotime($item->checkin)) }}</td>
                                                <td>{{ !empty($item->user) ? $item->user->full_name : "" }}</td>
                                                <td>{{ !empty($item->user) ? number_format($item->user->salary, 0, ',', '.') : "" }} </td>
                                                <td>
                                                    <b>{{ date("H:i", strtotime($item->checkin)) }}</b>
                                                </td>
                                                <td style="color: red">
                                                    <b>{{ !empty($item->checkout) ? date("H:i", strtotime($item->checkout)) : ""}}</b>
                                                </td>
                                                <td>
                                                    @if(!empty($item->checkout))
                                                        {{ number_format($diffMinute/60, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                        {{-- <tr>
                                            <td style="text-align:center"colspan="3">Tổng số</td>
                                            @foreach ($dataOverview as $number)
                                                <td >{{ $number }}</td>
                                            @endforeach
                                                <td >{{ $totalAllDayWork }}</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      
                        <div id="myModal" class="modal">
                            
                            <div class="modal-content">
                                <div class="d-flexv justify-content-between">
                                    
                                    <h4 id="title-text"></h4>
                                    <span class="close" style="margin-top: -38px">&times;</span>
                                </div>
                                <hr>
                                <strong id="employeeName"></strong><br>
                                <strong id="employeeEmail"></strong><br>
                                <strong id="employeePhone"></strong><br>
                                <strong id="employeeSalary"> </strong><br>
                                <strong id="employeeDaySalary"> </strong><br>
                                <strong id="employeeSumSalary"></strong><br>
                                <strong id="employeeBank"></strong><br>
                                <strong id="employeeAccount"></strong>
                            </div>
                        </div>
                        {{-- {{ $logs->appends($inputs)->links() }} --}}
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    var btnOpenModals = document.querySelectorAll('#btnOpenModal');
    var modal  = document.querySelector('#myModal');
    var span = document.getElementsByClassName("close")[0];
    var employeeName = document.getElementById('employeeName');
    var employeeEmail = document.getElementById('employeeEmail');
    var employeePhone = document.getElementById('employeePhone');
    var employeeBank = document.getElementById('employeeBank');
    var employeeAccount = document.getElementById('employeeAccount');

    var employeeSalary = document.getElementById('employeeSalary');
    var employeeDaySalary = document.getElementById('employeeDaySalary');
    var employeeSumSalary = document.getElementById('employeeSumSalary');
    var titleText = document.getElementById('title-text');
    btnOpenModals.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var userId = this.getAttribute('data-user-id');
            var name = this.getAttribute('data-user-name');
            var phone = this.getAttribute('data-user-phone');
            var email = this.getAttribute('data-user-email');
            var bank = this.getAttribute('data-user-bank');
            var day = this.getAttribute('data-user-day-salary'); //  tổng số ngày công
            var salary = this.getAttribute('data-user-salary');  //  lương cơ bản
            var account_number = this.getAttribute('data-user-account-number');
            var sum_salary = this.getAttribute('data-user-sum-salary'); // lương nhận được
            employeeName.textContent = "Nhân viên: " + name;
            employeeEmail.textContent = "Email: " + email;
            employeePhone.textContent = "Số điện thoại: " + phone;
            employeeBank.textContent = "Ngân hàng: " + bank;
            employeeAccount.textContent = "Số tài khoản: " + account_number;
            employeeDaySalary.textContent = "Tổng số ngày công: "+ day;
            employeeSalary.textContent = "Lương cơ bản: "+ salary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            employeeSumSalary.textContent = "Lương nhận được: "+ sum_salary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            titleText.textContent = "Thông tin nhân viên";
            modal.style.display ="block";

        });
    });
      // Khi người dùng bấm vào nút <span> (x), đóng modal
        span.onclick = function() {
            modal.style.display = "none";
        }

    // Khi người dùng bấm vào bất kỳ nơi nào bên ngoài modal, đóng modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

});
</script>
<style>
   .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%; 
        overflow: auto;
        background-color: rgba(0,0,0,0.4); 
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30% !important;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>