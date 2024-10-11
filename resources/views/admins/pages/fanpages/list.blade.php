@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Fanpage</h4>
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
                                        <label for="">Tháng</label>
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Năm</label>
                                        <select name="year" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            @for($i = 2023; $i <= date("Y"); $i++)
                                                <option value="{{ $i }}" @if ($i == $year) {{ 'selected' }} @endif>
                                                    Năm {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
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
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Mã link</th>
                                            <th>Tên fanpage</th>
                                            <th>Link</th>
                                            <th style="text-align: center">Click</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fanpages as $key => $fanpageItem)
                                            <tr>
                                                <td>
                                                    {{ $fanpageItem->id }}
                                                </td>
                                                <td>
                                                    {{ $fanpageItem->user->full_name }}
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
                                                    <button class="btn btn-primary copy-button" data-clipboard-text="{{ $route }}">
                                                        Copy
                                                    </button>
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
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
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
