@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Thêm tài khoản</h4>
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
                        <h4 class="card-title">Thông tin tài khoản</h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{route('admin.user.shop.store')}}" method="POST">
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
                                            <label for="example-search-input" class="form-label">Tên shop <span class="text text-danger">*</span></label>
                                            <input value="{{old('shop_name')}}" required class="form-control" name="shop_name" type="text" id="example-search-input">
                                            @error('shop_name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Email <span class="text text-danger">*</span></label>
                                            <input value="{{old('email')}}" required class="form-control" name="email" type="email" id="example-email-input">
                                            @error('email')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-email-input" class="form-label">Loại tài khoản <span class="text text-danger">*</span></label>
                                            <select class="form-control" name="type" id="">
                                                @foreach ($types as $typeItem)
                                                    <option value="{{$typeItem}}" @if(old('type') == $typeItem){{'selected'}}@endif>
                                                        {{$typeItem}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="example-email-input" class="form-label">Mã giới thiệu (nếu có)</label>
                                        <input value="{{old('ref_code')}}" class="form-control" name="ref_code" type="text" id="example-email-input">
                                        @error('ref_code')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Số điện thoại <span class="text text-danger">*</span></label>
                                            <input value="{{old('phone')}}" required class="form-control" name="phone" type="text" id="example-text-input">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Mật khẩu <span class="text text-danger">*</span></label>
                                            <input required class="form-control" name="password" type="password" id="example-text-input">
                                            @error('password')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Xác nhận mật khẩu <span class="text text-danger">*</span></label>
                                            <input required class="form-control" name="password_confirmation" type="password" id="example-text-input">
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