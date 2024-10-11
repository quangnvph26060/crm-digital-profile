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
                    <h4 class="mb-sm-0 font-size-18">Thêm nhiệm vụ cho nhân viên</h4>
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
                        <h4 class="card-title">Thông tin nhiệm vụ</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.mission.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">
                                        <b>Chú ý:</b> Chọn file import thì không cần nhập từ khóa
                                    </div>
                                    <div>
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">Import excel (Tải file mẫu <a href="/keyword.xlsx">tại đây</a>)</label>
                                            <input class="form-control" type="file" name="file_import" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">Từ khóa (mỗi từ khóa ấn enter)</label>
                                            <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ old('keyword') }}" name="keyword" placeholder="Enter something" />
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
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                    <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline viết bài <span class="text text-danger">*</span></label>
                                            <input type="date" required class="form-control" name="deadline">
                                            @error('deadline')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline sửa bài</label>
                                            <input type="date" class="form-control" name="deadline_edit">
                                            @error('deadline_edit')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Deadline publish</label>
                                            <input type="date" class="form-control" name="deadline_publish">
                                            @error('deadline_publish')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Ghi chú cho nhân viên</label>
                                            <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận thêm
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
