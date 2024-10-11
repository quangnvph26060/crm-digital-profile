@extends('auths.layouts.index')

@section('title', 'Đặt lại mật khẩu Ship Viêt')

@section('content')
<div class="col-xxl-3 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                @include('auths.elements.logo')
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Đặt lại mật khẩu</h5>
                    </div>
                    @include('auths.elements.alert')
                    <form class="mt-4" method="POST" action="{{route('post-reset-password', ['token' => $token])}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" required class="form-control">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" required class="form-control">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                Xác nhận
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 text-center">
                        <p class="text-muted mb-0">Bạn đã nhớ mật khẩu ?  <a href="{{route('login')}}"
                                class="text-primary fw-semibold"> Đăng nhập </a> </p>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© 2023 Web89.vn</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth full page content -->
</div>
@endsection
