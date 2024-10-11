@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Chấm công</h4>
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
                                            <option value="-1">
                                                Tất cả
                                            </option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}" @if(isset($inputs["user_id"]) && $inputs["user_id"] == $item->id){{ 'selected' }}@endif>
                                                    {{ $item->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
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
                                <div class="col-lg-3">
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
                                            <th>Ngày</th>
                                            <th>Thứ</th>
                                            <th>Nhân viên</th>
                                            <th>Vào</th>
                                            <th>Ra</th>
                                            <th>Mô tả</th>
                                            <th>Tổng giờ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $key => $item)
                                            @php
                                                $checkin = \Carbon\Carbon::parse($item->checkin);
                                                $diffMinute = $checkin->diffInMinutes($item->checkout);
                                            @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ date("d/m/Y", strtotime($item->checkin)) }}</td>
                                            <td>{{ getDayOfWeek(date("l", strtotime($item->checkin))) }}</td>
                                            <td>{{ !empty($item->user) ? $item->user->full_name : "" }}</td>
                                            <td>
                                                <b>{{ date("H:i", strtotime($item->checkin)) }}</b>
                                            </td>
                                            <td style="color: red">
                                                <b>{{ !empty($item->checkout) ? date("H:i", strtotime($item->checkout)) : ""}}</b>
                                            </td>
                                            <td>
                                                <div class="dropdown-container">
                                                    <p class="hover-target
                                                        {{ $item->note != "" ? ($item->status === 1 ? 'text-red' : 'text-blue') : '' }}">
                                                        {{ $item->note }} 
                                                    </p>
                                                
                                                   
                                                    <div class="dropdown-menu">
                                                        <form action="{{ route('customer.attendance.update-status') }}" method="POST" class="status-form">
                                                            @csrf
                                                            <input type="hidden" name="check_in" value="{{ $item->checkin }}">
                                                            <input type="hidden" name="id" value="{{ $item->user->id }}">
                                                            <button type="submit" name="status" value="0" class="confirm-btn">Confirm</button>
                                                            <button type="submit" name="status" value="1" class="cancel-btn">Cancel</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($item->checkout))
                                                    {{ number_format($diffMinute/60, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $logs->appends($inputs)->links() }}
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
<style scoped>
/* Container for dropdown and content */
.dropdown-container {
    position: relative;
    display: inline-block;
}

/* The p element */
.hover-target {
    cursor: pointer; /* Make it clear that the element is interactive */
}

/* The dropdown menu */
.dropdown-menu {
    display: none; /* Hide by default */
    position: absolute;
    bottom: 100%; /* Show above the p element */
    left: 0;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    padding: 10px;
    z-index: 1; /* Make sure it appears above other elements */
    min-width: 160px;
    text-align: center;
}


.confirm-btn, .cancel-btn {
    display: block; 
    margin: 5px auto;
    padding: 5px 10px;
    border: none;
    color: white;
    cursor: pointer;
}

.confirm-btn {
    background-color:#1d7f58;
}

.cancel-btn {
    background-color: #f44336;
}


.dropdown-container:hover .dropdown-menu {
    display: flex;
}
.status-form{
    display: flex;
    gap: 10px;
}
.text-red {
    color: red;
    background-color: #ffe5e5;
    border: 1px solid red;
    padding: 5px;
    border-radius: 5px;
}
.text-blue {
    color: #aae1cb;
    background-color: #e0f7f1;
    border: 1px solid #1d7f58;
    padding: 5px;
    border-radius: 5px;
}
</style>