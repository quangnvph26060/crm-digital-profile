@extends('auths.layouts.index')

@section('title', 'Đăng ký Ship Viêt')

@section('content')
<div class="col-xxl-3 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                @include('auths.elements.logo')
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Đăng ký tài khoản</h5>
                    </div>
                    @include('auths.elements.alert')
                    <form method="POST" class="needs-validation mt-4 pt-2" action="{{route('post-register')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Mã giới thiệu (nếu có)</label>
                            <input type="text" value="{{old('ref_code')}}" name="ref_code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Tên shop/công ty <span class="text text-danger">*</span></label>
                            <input type="text" value="{{old('shop_name')}}" name="shop_name" class="form-control">
                            @error('shop_name')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Họ và tên <span class="text text-danger">*</span></label>
                            <input type="text" value="{{old('full_name')}}" name="full_name" class="form-control">
                            @error('full_name')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email <span class="text text-danger">*</span></label>
                            <input type="email" value="{{old('email')}}" name="email" class="form-control" required>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">SĐT <span class="text text-danger">*</span></label>
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control" id="username" required>
                            @error('phone')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="userpassword" class="form-label">Mật khẩu <span class="text text-danger">*</span></label>
                            <input type="password" class="form-control" id="userpassword" name="password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="userpassword" class="form-label">Xác nhận mật khẩu <span class="text text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                Đăng ký
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 text-center">
                        <p class="text-muted mb-0">Bạn đã có tài khoản ? <a href="{{route('login')}}"
                                class="text-primary fw-semibold"> Đăng nhập </a> </p>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© 2023 Web89.vn</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
