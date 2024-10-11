@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tổng quan nhân viên</h4>
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
                                        <label for="">Tháng</label>
                                        <select name="month" class="form-control" id="">
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
                                            <th>STT</th>
                                            <th data-priority="2">Họ tên</th>
                                            <th style="text-align: center" data-priority="3">Đã viết/KPI</th>
                                            <th>Viết chậm deadline</th>
                                            <th style="text-align: center" data-priority="6">Số bài đã cần sửa</th>
                                            <th>Sửa chậm deadline</th>
                                            <th style="text-align: center">Số bài đã đăng</th>
                                            <th>Đăng chậm deadline </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $userItem)
                                            @php
                                                $totalPostFromSetting = $userItem->kpis->sum("post_new_num");
                                                $totalPostAssigned = $userItem->missions->where("status", ">", 0)->count();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $userItem->full_name }}</td>
                                                <td align="center">
                                                    @if ($totalPostFromSetting == 0)
                                                        <b>
                                                            {{ $totalPostAssigned }}/{{ $totalPostFromSetting }} bài - <span class="text text-primary">0%</span>
                                                        </b>

                                                    @else
                                                        <b>
                                                            {{ $totalPostAssigned }}/{{ $totalPostFromSetting }} bài -
                                                            <span class="text text-primary">{{ number_format(100 *  $totalPostAssigned/$totalPostFromSetting) }}%</span>
                                                        </b>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    {{ number_format($userItem->post_new_expired) }}
                                                </td>
                                                <td align="center">
                                                    {{ $userItem->total_post_need_edit }} bài
                                                    {{-- -
                                                    <span class="text text-primary">
                                                        {{ $totalPostAssigned == 0 ? '0' : number_format(100 * $userItem->missions->where("status", 4)->count()/$totalPostAssigned) }}%
                                                    </span> --}}
                                                </td>
                                                <td align="center">
                                                    {{ number_format($userItem->post_edit_expired) }}
                                                </td>
                                                <td align="center">
                                                    {{ $userItem->missions->where("status", 5)->count() }} bài
                                                    {{-- -
                                                    <span class="text text-primary">
                                                        {{ $totalPostAssigned == 0 ? '0' : number_format(100 * $userItem->missions->where("status", 5)->count()/$totalPostAssigned) }}%
                                                    </span> --}}
                                                </td>
                                                <td align="center">
                                                    {{ number_format($userItem->post_publish_expired) }}
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
