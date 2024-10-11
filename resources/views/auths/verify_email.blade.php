@extends('auths.layouts.index')

@section('title', 'Xác thực Email')

@section('content')
<div class="col-xxl-3 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                @include('auths.elements.logo')
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <div class="avatar-lg mx-auto">
                            <div class="avatar-title rounded-circle bg-light">
                                <i class="bx bx-mail-send h2 mb-0 text-primary"></i>
                            </div>
                        </div>
                        <div class="p-2 mt-4">
                            <h4 class="text text-{{$success ? 'success' : 'danger'}}">
                                {{$title}}
                            </h4>
                            <p class="text-muted">
                                {{$message}}
                            </p>
                            <div class="mt-4">
                                <a href="{{route('login')}}" class="btn btn-primary w-100">Quay lại đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© 2022 Web89.vn</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
