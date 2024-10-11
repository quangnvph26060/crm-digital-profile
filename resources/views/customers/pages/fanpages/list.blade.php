@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Thêm mới Fanpage</h4>
        </div>
    </div>
    <div class="col-lg-6">
        <form method="POST" action="{{ route('customer.fanpage.store') }}">
            @csrf
            <div class="form-group">
                <label for="">Tên fanpage <span class="text text-danger">*</span></label>
                <input required autocomplete="off" type="text" name="name" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="">Link <span class="text text-danger">*</span></label>
                <input required autocomplete="off" type="text" name="link" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <button class="btn btn-success">Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Fanpage của bạn</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<form action="">
    <div class="row">
        <div class="col-lg-2">
            <select class="form-control" name="month" id="">
                <option value="-1">Chọn tháng</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option @if(isset($inputs["month"]) && $inputs["month"] == $i){{ 'selected' }}@endif value="{{ $i < 10 ? "0" . $i : $i }}">Tháng {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-2">
            <select class="form-control" name="year" id="">
                <option value="-1">Chọn năm</option>
                @for ($i = 2023; $i <= date("Y"); $i++)
                    <option @if(isset($inputs["year"]) && $inputs["year"] == $i){{ 'selected' }}@endif value="{{ $i }}">Năm {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-2">
            <button class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ url()->current() }}" class="btn btn-danger">Tải lại</a>
        </div>
    </div>
</form>
<br>
<div class="row">
    <div class="col-lg-12">
        @include('globals.alert')
        <div class="card card-h-100">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã fanpage</th>
                            <th>Tên fanpage</th>
                            <th>Link</th>
                            <th>Lượt click</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fanpages as $key => $fanpageItem)
                            <tr>
                                <td>
                                    {{ $fanpageItem->id }}
                                </td>
                                <td>
                                    <a href="{{ route('customer.fanpage.track', ['code' => $fanpageItem->code]) }}" target="_blank">
                                        {{ $fanpageItem->code }}
                                    </a>
                                </td>
                                <td>
                                    {{ $fanpageItem->name }}
                                </td>
                                <td>
                                    <a href="{{ $fanpageItem->link }}" target="_blank">
                                        Xem ngay
                                    </a>
                                    <br>
                                    @php
                                        $route = route('customer.fanpage.track', ['code' => $fanpageItem->code]);
                                    @endphp
                                    <button class="btn btn-primary copy-button" data-clipboard-text="{{ $route }}">Copy</button>
                                </td>
                                <td align="center">
                                    {{ number_format($fanpageItem->tracks_count) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script>
    $(document).ready(function() {
        var clipboard = new ClipboardJS('.copy-button');
        
        clipboard.on('success', function(e) {
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            console.error('Sao ch�p th?t b?i.');
        });
    });
</script>
@endsection
