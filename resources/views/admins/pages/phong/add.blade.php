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
                            <h4 class="card-title">Thông tin phông</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.phong.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Tên phông <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ old('ten_phong') }}" required class="form-control"
                                                    name="ten_phong" type="text" id="example-text-input">
                                                @error('ten_phong')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-search-input" class="form-label">Mã phông <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ old('ma_phong') }}" required class="form-control"
                                                    name="ma_phong" type="text" id="agency_code-search-input"
                                                    list="agency-codes">
                                                @error('ma_phong')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <datalist id="agency-codes">

                                                </datalist>
                                            </div>
                                            <div class="mb-3">
                                                <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                                                        class="text text-danger">*</span></label>
                                                <select class="form-select" name="ma_coquan" id="agency_code-select">
                                                    <option value="">Chọn mã cơ quan</option>
                                                    @foreach ($macoquan as $item)
                                                        <option value="{{ $item->id }}">{{ $item->agency_name }} -
                                                            {{ $item->agency_code }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ma_coquan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
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
                        $('#agency-codes').append('<option value="' + item.agency_code +
                            '">');

                    });
                });
            });
        });
    </script>
@endsection
