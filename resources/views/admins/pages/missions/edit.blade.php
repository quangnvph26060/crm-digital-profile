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
                    <h4 class="mb-sm-0 font-size-18">Sửa từ khóa - {{ $mission->keyword }}</h4>
                    {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Basic Elements</li>
                        </ol>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class ="card-title">Thông tin từ khóa</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.mission.update', ['id' => $mission->id, 'url_pre' => $url_pre])}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label">Từ khóa<span class="text text-danger">*</span></label>
                                            <input class="form-control" type="text" value="{{ $mission->keyword }}" name="keyword" />
                                            @error('keyword')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Chọn dự án <span class="text text-danger">*</span></label>
                                            <select name="project_id" class="form-control" data-trigger name="choices-single-groups"
                                                id="choices-single-groups">
                                                @foreach ($projects as $item)
                                                    <option @if($mission->project_id == $item->id){{'selected'}}@endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Chọn nhân viên <span class="text text-danger">*</span></label>
                                            <select name="user_id" class="form-control" data-trigger name="choices-single-groups"
                                                id="choices-single-groups">
                                                <option value="">Chọn Nhân viên</option>
                                                @foreach ($users as $item)
                                                    <option @if($item->id == $mission->user_id){{'selected'}}@endif value="{{ $item->id }}">{{ $item->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Url viết bài</label>
                                            <input type="text" value="{{$mission->url}}" class="form-control" name="url">
                                            @error('url')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Url publish</label>
                                            <input type="text" value="{{$mission->url_publish}}" class="form-control" name="url_publish">
                                            @error('url')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Trạng thái<span class="text text-danger">*</span></label>
                                            <select class="form-control" name="status" id="">
                                                <option @if($mission->status === 0){{'selected'}}@endif value="0">Tiếp nhận</option>
                                                <option @if($mission->status === 1){{'selected'}}@endif value="1">Hoàn thành</option>
                                                <option @if($mission->status === 2){{'selected'}}@endif value="2">Cần sửa</option>
                                                <option @if($mission->status === 4){{'selected'}}@endif value="4">Đã sửa</option>
                                                <option @if($mission->status === 3){{'selected'}}@endif value="3">Được Publish</option>
                                                <option @if($mission->status === 5){{'selected'}}@endif value="5">Đã Publish</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Ngày giao <span class="text text-danger">*</span></label>
                                            <input type="date" value="{{$mission->date}}" required class="form-control" name="date">
                                            @error('date')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline viết bài <span class="text text-danger">*</span></label>
                                            <input type="date" value="{{$mission->deadline}}" required class="form-control" name="deadline">
                                            @error('deadline')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline sửa bài</label>
                                            <input type="date" value="{{ $mission->deadline_edit }}" class="form-control" name="deadline_edit">
                                            @error('deadline_edit')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline publish</label>
                                            <input type="date" value="{{ $mission->deadline_publish }}" class="form-control" name="deadline_publish">
                                            @error('deadline_publish')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Trao đổi thêm nếu cần</label>
                                            <textarea name="message" class="form-control" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection

@section('scripts')
<!-- choices js -->
<script src="{{asset('libs/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/assets/js/pages/form-advanced.init.js')}}"></script>
@endsection
