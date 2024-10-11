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
            <div class="col-lg-12">
                <form method="GET">
                    <div class="row">
                        <div class="col-lg-3 form-group">
                            <label for="">Chọn tháng</label>
                            <select class="form-control" name="month" id="">
                                @for ($i = 1; $i < 13; $i++)
                                    <option value="{{$i}}" @if($i == $month){{ 'selected' }}@endif>
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="">Chọn năm</label>
                            <select class="form-control" name="year" id="">
                                @for ($i = 2023; $i <= date("Y"); $i++)
                                    <option value="{{$i}}" @if($i == $year){{ 'selected' }}@endif>
                                        Năm {{ $i }}
                                    </option>
                                @endfor
                            </select>
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
                        @foreach ($users as $userItem)
                            @php
                                $totalPostInit = $userItem->log_missions->where('status', 1)->count();
                                $percentInit = ($userItem->kpis->count() > 0) ? (100 * $totalPostInit/$userItem->kpis->sum('post_new_num')) : 0;

                                $totalPostPublish = $userItem->log_missions->where('status', 3)->count();
                                $percentPublish = ($userItem->kpis->count() > 0) ? (100 * $totalPostPublish/$userItem->kpis->sum('post_publish_num')) : 0;

                                $totalPostEdit = $userItem->log_missions->where('status', 2)->count();
                                $percentEdit = ($userItem->kpis->count() > 0) ? (100 - 100 * $totalPostEdit/$userItem->kpis->sum('post_edit_num')) : 0
                            @endphp
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>{{$userItem->full_name}}</h4>
                                    </div>

                                    <div class="card-body">
                                        <p class="d-flex" style="justify-content: space-between;">
                                            <b>% lương nhận được</b>
                                            <span>{{number_format(100 * ($percentPublish + $percentEdit + $percentInit)/300)}}%</span>
                                        </p>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{100 * ($percentPublish + $percentEdit + $percentInit)/300}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="d-flex" style="justify-content: space-between;">
                                            <b>
                                                % hoàn thành bài mới
                                            </b>
                                            <span>
                                                {{number_format($percentInit)}}%
                                            </span>
                                        </p>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$percentInit}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="d-flex" style="justify-content: space-between;">
                                            <b>% không phải sửa bài</b>
                                            <span>{{number_format($percentEdit)}}</span>
                                        </p>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{$percentEdit}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="d-flex" style="justify-content: space-between;">
                                            <b>% được publish</b>
                                            <span>{{number_format($percentPublish)}}%</span>
                                        </p>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{$percentPublish}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div><!-- end row-->
    </div>
    <!-- container-fluid -->
</div>
@endsection

