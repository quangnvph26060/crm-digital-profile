@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Thêm quyền truy cập cho hệ thống</h4>
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
                        <h4 class="card-title">Thông tin quyền truy cập</h4>
                    </div>
                    <div class="card-body p-4">
                        @include('globals.alert')
                        <form action="{{route('admin.permission.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Tên quyền<span class="text text-danger">*</span></label>
                                            <input value="{{old('name')}}" placeholder="Ví dụ: Duyệt yêu cầu nạp tiền" required class="form-control" name="name" type="text" id="example-text-input">
                                            @error('name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Mã quyền <span class="text text-danger">*</span></label>
                                            <input value="{{old('code')}}" placeholder="Ví dụ: accept-reuqest-put-money" required class="form-control" name="code" type="text" id="example-search-input">
                                            @error('code')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Mô tả (nếu có)</label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10">{{old('description')}}</textarea>
                                            @error('description')
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
                                            Xác nhận thêm
                                        </button>
                                        <a href="{{route('admin.permission.list')}}" class="btn btn-danger w-md">
                                            Quay lại
                                        </a>
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