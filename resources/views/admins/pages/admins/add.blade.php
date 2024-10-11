@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Thêm admin</h4>
                  
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin admin</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.admin.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Họ tên <span class="text text-danger">*</span></label>
                                            <input value="{{old('full_name')}}" required class="form-control" name="full_name" type="text" id="example-text-input">
                                            @error('full_name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Email <span class="text text-danger">*</span></label>
                                            <input value="{{old('email')}}" required class="form-control" name="email" type="text" id="example-search-input">
                                            @error('email')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="example-url-input" class="form-label">SĐT <span class="text text-danger">*</span></label>
                                            <input value="{{old('phone')}}" required class="form-control" name="phone" type="text" id="example-email-input">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        {{-- <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Số bài viết giao mỗi ngày <span class="text text-danger">*</span></label>
                                            <input value="{{old('post_number_per_day')}}" required class="form-control" name="post_number_per_day" type="text" id="example-email-input">
                                            @error('post_number_per_day')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Mật khẩu <span class="text text-danger">*</span></label>
                                            <input required class="form-control" name="password" type="password" id="example-text-input">
                                            @error('password')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Loại user <span class="text text-danger">*</span></label>
                                            <select class="form-control" name="type" id="">
                                                <option value="0">Thực tập</option>
                                                <option value="1">Chính thức</option>
                                                <option value="2">Quản lý</option>
                                            </select>
                                            @error('password')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        {{-- <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Mức lương <span class="text text-danger">*</span></label>
                                            <input value="{{old('salary')}}" required class="form-control" name="salary" type="text" id="example-salary-input">
                                            @error('salary')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        {{-- <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Ngân hàng </label>
                                            <input value="{{old('bank')}}" required class="form-control" name="bank" type="text" id="example-bank-input">
                                            @error('bank')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label"> Số tài khoản</label>
                                            <input value="{{old('account_number')}}" required class="form-control" name="account_number" type="text" id="example-account_number-input">
                                            @error('account_number')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="example-select" class="form-label">Vai trò <span class="text text-danger">*</span></label>
                                        <select required class="form-select" name="level" id="example-select">
                                            <option value="1">User </option>
                                            <option value="2">Admin </option>
                                          
                                        </select>
                                        @error('level')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
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
