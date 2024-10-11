@extends('auths.layouts.index')

@section('title', 'Đăng nhập')

@section('content')
<div class="col-xxl-3 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                @include('auths.elements.logo')
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Đăng nhập</h5>
                    </div>
                    @include('auths.elements.alert')
                    <form method="POST" class="mt-4 pt-2" action="{{route('post-login')}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">SĐT hoặc Email</label>
                            <input name="email" type="text" class="form-control" id="username">
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <label class="form-label">Mật khẩu</label>
                                </div>
                                {{-- <div class="flex-shrink-0">
                                    <div class="">
                                        <a href="{{route('forget-password')}}" class="text-muted">Quên mật khẩu?</a>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="input-group auth-pass-inputgroup">
                                <input type="password" name="password" class="form-control" aria-label="Password" aria-describedby="password-addon">
                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-check">
                                    <input name="remember" class="form-check-input" type="checkbox" id="remember-check">
                                    <label class="form-check-label" for="remember-check">
                                        Ghi nhớ
                                    </label>
                                </div>  
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Đăng nhập</button>
                        </div>
                    </form>

                    {{-- <div class="mt-4 pt-2 text-center">
                        <div class="signin-other-title">
                            <h5 class="font-size-14 mb-3 text-muted fw-medium">- Sign in with -</h5>
                        </div>

                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void()"
                                    class="social-list-item bg-primary text-white border-primary">
                                    <i class="mdi mdi-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void()"
                                    class="social-list-item bg-info text-white border-info">
                                    <i class="mdi mdi-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void()"
                                    class="social-list-item bg-danger text-white border-danger">
                                    <i class="mdi mdi-google"></i>
                                </a>
                            </li>
                        </ul>
                    </div> --}}

                    {{-- <div class="mt-5 text-center">
                        <p class="text-muted mb-0">Bạn chưa có tài khoản ? <a href="{{route('register')}}"
                                class="text-primary fw-semibold">Đăng ký ngay </a> </p>
                    </div> --}}
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© 2023</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth full page content -->
</div>
@endsection