@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cấu hình SMTP gửi Email</h4>
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
                        <h4 class="card-title">Thông tin cấu hình</h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{route('admin.setting.store-smtp')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Driver</label>
                                            <input required class="form-control" name="driver" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->driver}}" id="example-text-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Host</label>
                                            <input required class="form-control" name="host" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->host}}" id="example-search-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-email-input" class="form-label">Port</label>
                                            <input required class="form-control" name="port" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->port}}" id="example-email-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Encryption</label>
                                            <input required class="form-control" name="encryption" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->encryption}}" id="example-email-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Tài khoản</label>
                                            <input required class="form-control" name="account" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->account}}" id="example-text-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">From Email</label>
                                            <input required class="form-control" name="from_email" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->from_email}}" id="example-text-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">From Name</label>
                                            <input required class="form-control" name="from_name" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->from_name}}" id="example-text-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Mật khẩu ứng dụng</label>
                                            <input required class="form-control" name="password" type="text" value="{{empty($smtpConfig) ? '' : $smtpConfig->password}}" id="example-text-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận lưu
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