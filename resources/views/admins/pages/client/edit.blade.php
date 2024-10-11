@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Sửa khách hàng {{$clients->full_name}}</h4>
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
                        <h4 class="card-title">Sửa khách hàng - {{ $clients->full_name }}</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.client.update', ['id' => $clients->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Họ tên <span class="text text-danger">*</span></label>
                                            <input value="{{$clients->name}}" required class="form-control" name="name" type="text" id="example-text-input">
                                            @error('name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Email <span class="text text-danger">*</span></label>
                                            <input value="{{$clients->email}}" required class="form-control" name="email" type="text" id="example-search-input">
                                            @error('email')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label">SĐT <span class="text text-danger">*</span></label>
                                            <input value="{{$clients->phone}}" required class="form-control" name="phone" type="text" id="example-email-input">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Tên công ty <span class="text text-danger">*</span></label>
                                            <input value="{{$clients->company_name}}" required class="form-control" name="company_name" type="text" id="example-email-input">
                                            @error('company_name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Mã số thuế <span class="text text-danger">*</span></label>
                                            <input value="{{$clients->tax_number}}" required class="form-control" name="tax_number" type="tax_number" id="example-text-input">
                                            @error('tax_number')
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
