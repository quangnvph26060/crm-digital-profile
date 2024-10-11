@extends('admins.layouts.index')
@section('css')
<link href="{{asset('libs/assets/libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Danh sách công việc</h4>
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
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Từ khóa</label>
                                        <input value="{{isset($inputs['keyword']) ? $inputs['keyword'] : ''}}" autocomplete="off" name="keyword" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Chọn dự án</label>
                                        <select name="project_id" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            @foreach ($projects as $item)
                                                <option @if(isset($inputs['project_id']) && $inputs['project_id'] == $item->id){{'selected'}}@endif value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Từ khóa</label>
                                        <select name="user_id" class="form-control" data-trigger name="choices-single-groups"
                                                id="choices-single-groups">
                                            <option value="">Chọn Nhân viên</option>
                                            @foreach ($users as $item)
                                                <option @if(isset($inputs['user_id']) && $inputs['user_id'] == $item->id){{'selected'}}@endif value="{{ $item->id }}">{{ $item->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Từ ngày</label>
                                        <input value="{{isset($inputs['date_from']) ? $inputs['date_from'] : ''}}" type="date" name="date_from" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Đến ngày</label>
                                        <input value="{{isset($inputs['date_to']) ? $inputs['date_to'] : ''}}" type="date" name="date_to" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <select name="status" class="form-control" id="">
                                            <option @if(isset($inputs['status']) && $inputs['status'] == -1){{'selected'}}@endif value="-1">Tất cả</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 0){{'selected'}}@endif value="0">Đã giao</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 1){{'selected'}}@endif value="1">Hoàn thành</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 2){{'selected'}}@endif value="2">Cần sửa</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 4){{'selected'}}@endif value="4">Đã sửa</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 3){{'selected'}}@endif value="3">Cần đăng</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 5){{'selected'}}@endif value="5">Đã đăng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Loại user</label>
                                        <select name="type_user" class="form-control" id="">
                                            <option value="-1">Tất cả</option>
                                            <option @if(isset($inputs['type_user']) && $inputs['type_user'] == 0){{'selected'}}@endif value="0">Thực tập</option>
                                            <option @if(isset($inputs['type_user']) && $inputs['type_user'] == 1){{'selected'}}@endif value="1">Chính thức</option>
                                            <option @if(isset($inputs['type_user']) && $inputs['type_user'] == 2){{'selected'}}@endif value="2">Quản lý</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        {{-- <a class="btn btn-success" href="{{ route('admin.mission.add') }}">
                                            <i class="fas fa-plus"></i> Thêm mới
                                        </a> --}}
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
                                            <th>Nhân viên</th>
                                            <th>Dự án</th>
                                            <th>Ngày giao</th>
                                            <th>Deadline</th>
                                            <th>Time hoàn thành</th>
                                            <th>Từ khóa giao</th>
                                            <th>URL viết bài</th>
                                            <th>URL publish</th>
                                            <th>Trạng thái</th>
                                            <th style="text-align: center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($missions as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ ($missions->currentpage()-1) * $missions->perpage() + $key + 1 }}
                                                </td>
                                                <td>{{ $item->user->full_name }}</td>
                                                <td>
                                                    {{ !empty($item->project) ? $item->project->name : "" }}
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($item->deadline)) }}
                                                </td>
                                                <td>
                                                    {{ is_null($item->date_done) ? "" : date("d/m/Y", strtotime($item->date_done)) }}
                                                </td>
                                                <td>{{ $item->keyword }}</td>
                                                <td>
                                                    @if (!is_null($item->url))
                                                    <a href="{{ $item->url }}" target="_blank">
                                                        Chuyển tới
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->url_publish))
                                                    <a href="{{ $item->url_publish }}" target="_blank">
                                                        Chuyển tới
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 0)
                                                        <div class="badge badge-soft-warning">Đã nhận việc</div>
                                                    @elseif ($item->status == 1)
                                                        <div class="badge badge-soft-success">Hoàn thành</div>
                                                    @elseif ($item->status == 2)
                                                        <div class="badge badge-soft-danger">Cần sửa</div>
                                                    @elseif ($item->status == 4)
                                                        <div class="badge badge-soft-success">Đã sửa</div>
                                                    @elseif ($item->status == 3)
                                                        <div class="badge badge-soft-danger">Cần đăng</div>
                                                    @elseif ($item->status == 5)
                                                        <div class="badge badge-soft-primary">Đã đăng</div>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a class="btn btn-warning" href="{{ route('admin.mission.edit', ['id' => $item->id, 'url_pre' => base64_encode(request()->fullUrlWithQuery($inputs))]) }}">Sửa</a>
                                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger" href="{{ route('admin.mission.delete', ['id' => $item->id]) }}">Xóa</a>
                                                    {{-- <a class="btn btn-primary"  href="{{route('admin.mission.comment', ['id' => $item->id])}}">Trao đổi</a> --}}
                                                    <button onclick="openModel({{$item->id}}, '{{$item->keyword}}')" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">
                                                        Trao đổi
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                                {{$missions->appends($inputs)->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    Chi tiết trao đổi cho từ khóa - <b id="keyword"></b>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-comment">

                </div>
                <div>
                    <textarea id="message-send" placeholder="Nhập nội dung ở đây..." class="form-control" name="" id="" cols="30" rows="5"></textarea><br>
                    <button id="send-cmt" class="btn btn-success">
                        Gửi
                    </button>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> --}}
        </div>
    </div>
</div>
<input type="hidden" id="mission-id">
<style>
    .modal-comment .active {
        color: green;
    }
    div#staticBackdrop {
        z-index: 4444444;
    }
</style>
@endsection
@section('scripts')
<!-- choices js -->
<script src="{{asset('libs/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/assets/js/pages/form-advanced.init.js')}}"></script>
<script>
    function openModel(id, keyword) {
        $('#keyword').html(keyword);
        $('.modal-comment').html("<center><img width='50px' src='/images/loading-waiting.gif'></center>");
        $.ajax({
            url: "/customer/mission/" + id + "/comments",
            method: 'GET',
            success: function(data) {
                if (data.success) {
                    $('#mission-id').val(id);
                    var comments = data.data;
                    var div = "";
                    for (var i = 0; i < comments.length; i++) {
                        var className = comments[i].is_user ? "active" : "in-active";
                        div+= "<div class='row'>" + "<p>" + "<b class='" + className + "'>" + comments[i].sender_name + " - " + "<span>" + comments[i].time + "</span>" + "</b>" + "</p>" + "<p>" + comments[i].message + "</p>" + "</div><hr style='margin-top: 0px'>";
                    }
                    setTimeout(() => {
                        $('.modal-comment').html(div);
                    }, 300);
                } else {
                    Swal.fire({
                        title: data.message,
                        showCancelButton: true,
                        icon: 'warning',
                    });
                }
            }
        })
    }
    $('#send-cmt').click(function () {
        var message = $('#message-send').val();
        if (message == '') {
            Swal.fire({
                title: "Bạn cần nhập nội dung",
                showCancelButton: true,
                icon: 'warning',
            });
        } else {
            $.ajax({
                url: "{{route('admin.mission.store-comment')}}",
                method: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    message: message,
                    mission_id: $('#mission-id').val()
                },
                success: function(data) {
                    if (data.success) {
                        $('#message-send').val("");
                        var comment = data.data;
                        $('.modal-comment').append("<div class='row'>" + "<p>" + "<b class='active'>" + comment.sender_name + " - " + "<span>" + comment.time + "</span>" + "</b>" + "</p>" + "<p>" + comment.message + "</p>" + "</div><hr style='margin-top: 0px'>");
                    } else {
                        Swal.fire({
                            title: data.message,
                            showCancelButton: true,
                            icon: 'warning',
                        });
                    }
                }
            })
        }
    });
</script>
@endsection
