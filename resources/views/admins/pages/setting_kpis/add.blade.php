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
                    <h4 class="mb-sm-0 font-size-18">Thêm KPI cho nhân viên</h4>
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
                        <h4 class="card-title">Thông tin KPI</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.setting-kpi.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Ngày
                                            </label>
                                            <input value="{{ date('Y-m-d') }}" type="date" class="form-control" name="date" id="">
                                            {{-- <select name="week" class="form-control" id="">
                                                <option value="1">Tuần 1 (Từ 01->07)</option>
                                                <option value="2">Tuần 2 (Từ 08-14)</option>
                                                <option value="3">Tuần 3 (Từ 15-21)</option>
                                                <option value="4">Tuần 4 (Từ 22->)</option>
                                            </select> --}}
                                            @error('date')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Chọn tháng
                                            </label>
                                            <select name="month" class="form-control" id="">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">
                                                        Tháng {{$i}}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('week')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Chọn tuần
                                            </label>
                                            <select name="year" class="form-control" id="">
                                                @for ($i = 2023; $i <= date("Y"); $i++)
                                                    <option value="{{$i}}">
                                                        Năm {{$i}}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('year')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Số lượng bài viết
                                            </label>
                                            <input class="form-control" type="text" value="{{ old('post_new_num') }}" name="post_new_num" />
                                            @error('post_new_num')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Số lượng bài viết sửa
                                            </label>
                                            <input class="form-control" type="text" value="{{ old('post_edit_num') }}" name="post_edit_num" />
                                            @error('post_edit_num')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-text-remove-button" class="form-label">
                                                Số lượng bài viết đăng
                                            </label>
                                            <input class="form-control" type="text" value="{{ old('post_publish_num') }}" name="post_publish_num" />
                                            @error('post_publish_num')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
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
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận
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
