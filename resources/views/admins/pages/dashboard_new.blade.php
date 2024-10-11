@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
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
                        @foreach ($users as $user)
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>{{$user->full_name}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="d-flex" style="justify-content: space-between;">
                                            <b>Viết bài mới:</b>
                                            @php
                                                $totalPostAssign = $user->log_missions->where('status', 1)->count();
                                            @endphp
                                            <span>
                                                <b class="text text-success">
                                                    {{$totalPostAssign . '/' . $user->kpis->sum('post_new_num')}} bài
                                                </b>
                                                -
                                                <b class="text text-danger">
                                                    @php
                                                        $percent = $user->kpis->sum('post_new_num') == 0 ? 0 : 100 * $totalPostAssign/$user->kpis->sum('post_new_num')
                                                    @endphp
                                                    {{ number_format($percent) }}%
                                                </b>
                                            </span>
                                        </p>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>
                                            <b>Số bài hiện tại đang cần sửa: <span class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('user_id', $user->id)->where("status", 2))) }}</span></b>
                                        </p>
                                        <p>
                                            <b>Số bài hiện tại đã sửa: <span class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('user_id', $user->id)->where("status", 4))) }}</span></b>
                                        </p>
                                        <p>
                                            <b>Số bài hiện tại cần đăng: <span class="text text-danger">{{ number_format(count($totalPostEditAndPublish->where('user_id', $user->id)->where("status", 3))) }}</span></b>
                                        </p>
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

