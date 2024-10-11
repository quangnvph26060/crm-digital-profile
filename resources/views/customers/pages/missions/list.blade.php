@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Công việc của bạn</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        @include('globals.alert')
        <div class="card card-h-100">
            <div class="card-body">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 0 ? 'active' : ''}}" data-bs-toggle="tab" href="#receive" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Tiếp nhận ({{\App\Models\Mission::where('status', 0)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 1 ? 'active' : ''}}" data-bs-toggle="tab" href="#finish" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Hoàn thành ({{\App\Models\Mission::where('status', 1)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 2 ? 'active' : ''}}" data-bs-toggle="tab" href="#edit" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Cần sửa ({{\App\Models\Mission::where('status', 2)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 4 ? 'active' : ''}}" data-bs-toggle="tab" href="#updated" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Đã sửa ({{\App\Models\Mission::where('status', 4)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 3 ? 'active' : ''}}" data-bs-toggle="tab" href="#publish" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block">Được publish ({{\App\Models\Mission::where('status', 3)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{$inputs['status'] == 5 ? 'active' : ''}}" data-bs-toggle="tab" href="#published" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block">Đã publish ({{\App\Models\Mission::where('status', 5)->where('user_id', auth()->user()->id)->count()}})</span>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane {{$inputs['status'] == 0 ? 'active' : ''}}" id="receive" role="tabpanel">
                        @include('customers.pages.missions.elements.receive')
                    </div>
                    <div class="tab-pane {{$inputs['status'] == 1 ? 'active' : ''}}" id="finish" role="tabpanel">
                        @include('customers.pages.missions.elements.finish')
                    </div>
                    <div class="tab-pane {{$inputs['status'] == 2 ? 'active' : ''}}" id="edit" role="tabpanel">
                        @include('customers.pages.missions.elements.edit')
                    </div>
                    <div class="tab-pane {{$inputs['status'] == 3 ? 'active' : ''}}" id="publish" role="tabpanel">
                        @include('customers.pages.missions.elements.publish')
                    </div>
                    <div class="tab-pane {{$inputs['status'] == 4 ? 'active' : ''}}" id="updated" role="tabpanel">
                        @include('customers.pages.missions.elements.updated')
                    </div>
                    <div class="tab-pane {{$inputs['status'] == 5 ? 'active' : ''}}" id="published" role="tabpanel">
                        @include('customers.pages.missions.elements.published')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Backdrop Modal -->
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
                url: "{{route('customer.mission.comment')}}",
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
