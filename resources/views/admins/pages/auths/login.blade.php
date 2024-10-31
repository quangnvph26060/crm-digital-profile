@extends('auths.layouts.index')

@section('title', 'Đăng nhập Ship Viêt')

@section('content')
<div class="col-xxl-5 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100 d-flex justify-content-center">
            <div class="d-flex flex-column h-100 w-420">
                @include('auths.elements.logo')
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Đăng nhập Admin</h5>
                    </div>
                    @include('auths.elements.alert')
                    <form method="POST" class="mt-4 pt-2" action="{{route('post-login-admin')}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
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
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth full page content -->
</div>
<style scoped>
    .w-420{
        width: 420px;
    }
</style>
@endsection
