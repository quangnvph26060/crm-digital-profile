@extends('admins.layouts.index')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
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
                            <h4 class="card-title">Thông tin cơ quan</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.config.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Tên cơ quan <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ old('agency_name') }}" required class="form-control"
                                                    name="agency_name" type="text" id="example-text-input">
                                                @error('agency_name')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-search-input" class="form-label">Mã cơ quan <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ old('agency_code') }}" required class="form-control"
                                                    name="agency_code" type="text" id="agency_code-search-input"
                                                    list="agency-codes">
                                                @error('agency_code')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <datalist id="agency-codes">

                                                </datalist>
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label">Tên phông <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ old('font_name') }}" required class="form-control"
                                                    name="font_name" type="text" id="example-email-input">
                                                @error('font_name')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="example-url-input" class="form-label">Mã phông<span
                                                    class="text text-danger">*</span></label>
                                            <input value="{{ old('font_code') }}" required class="form-control"
                                                name="font_code" type="number" id="example-email-input">
                                            @error('font_code')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Tên mục lục <span
                                                    class="text text-danger">*</span></label>
                                            <select name="toc_name" class="form-control" data-trigger
                                                name="choices-single-groups"id="choices-single-groups">
                                                <option value="Vĩnh viễn">Vĩnh viễn</option>
                                                <option value="Có thời hạn">Có thời hạn</option>
                                            </select>
                                            @error('toc_name')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#agency_code-search-input').on('input', function() {
                var query = $(this).val();
                $.get('{{ route('admin.config.get-agency-code') }}', {
                    query: query
                }, function(data) {
                    $('#agency-codes').empty();
                    data.forEach(function(item) {
                        $('#agency-codes').append('<option value="' + item.agency_code +'">');
                            
                    });
                });
            });
        });
    </script>
@endsection
