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
                        <h4 class="card-title">Thông tin hộp số</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.hop.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="">Cơ quan</label>
                                            <select class="form-select" name="coquan_id" id="coquan" required>
                                                <option value="">Chọn cơ quan</option>
                                                @foreach ($coquan as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->agency_name }} - Cơ quan : {{ $item->agency_code }}
                                                </option>
                                                @endforeach
                                                <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Phông</label>
                                            <select class="form-select" name="phong_id" id="phong" required>
                                                <option value="">Chọn phông</option>
                                                {{-- @foreach ($phongdata as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->ten_phong }} - Cơ quan : {{ $item->coquan->agency_code }}
                                                </option>
                                                @endforeach --}}
                                                <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Mục lục</label>
                                            <select class="form-select" name="mucluc_id" id="mucluc" required>
                                                <option value="">Chọn mục lục</option>
                                                {{-- @foreach ($phongdata as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->ten_phong }} - Cơ quan : {{ $item->coquan->agency_code }}
                                                </option>
                                                @endforeach --}}
                                                <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="hop_so" class="form-label">Hộp số <span
                                                    class="text text-danger">*</span></label>
                                            <input value="{{ old('hop_so') }}" required class="form-control"
                                                name="hop_so" type="text" id="hop_so" list="agency-codes">
                                            @error('hop_so')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <datalist id="agency-codes">

                                            </datalist>
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
        $('#coquan').change(function() {
            var selectedValue = $(this).val();
            // alert(selectedValue);
            $('#phong').find('option').remove().end().append('<option value="">Chọn phông</option>').val('');
            $('#mucluc').find('option').remove().end().append('<option value="">Chọn mục lục</option>').val('');
            if (selectedValue) {
                var url = "{{ route('hop-so-phong-by-config_id') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: selectedValue
                    },
                    success: function(response) {

                        if (response.status === 'success') {
                            var selectElement = $('#phong');
                            selectElement.find('option').remove();
                            selectElement.append('<option value="">Chọn phông</option>');
                            response.data.forEach(function(item) {
                                selectElement.append('<option value="' + item.id +'">' + item.ten_phong + '</option>' );
                            });
                            selectElement.val('{{ old('phong_id') }}');
                            $('#phong').change(function() {
                                var selectedMaPhongValue = $(this).val();
                                $('#mucluc').find('option').remove().end().append('<option value="">Chọn mục lục</option>').val('');

                                if (selectedMaPhongValue) {
                                    var url = "{{ route('hop-so-mucluc-by-phong_id') }}";
                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        data: {
                                            id: selectedValue,
                                            phongId: selectedMaPhongValue
                                        },
                                        success: function(response) {

                                            if (response.status ==='success') {
                                                var selectElement = $('#mucluc');
                                                selectElement.find('option').remove();
                                                selectElement.append(
                                                    '<option value="">Chọn mục lục</option>'
                                                );
                                                response.data.forEach(
                                                    function(item) {
                                                        selectElement.append( '<option value="' +item.id +'">' +item.ten_mucluc + ' - ' + item.ma_mucluc +'</option>');
                                                    });
                                            }

                                        },
                                        error: function(xhr, status,
                                            error) {
                                            console.error(error);
                                        }
                                    });
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });


    });
</script>

@endsection
