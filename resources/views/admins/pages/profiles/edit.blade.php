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
                        {{-- <div class="card-header">
                            <h4 class="card-title">Thông tin hồ sơ</h4>
                        </div> --}}

                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.update', ['id' => $profile->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('config_id ') ? 'is-invalid' : '' }}"
                                                        name="config_id" id="agency_code-select">
                                                        <option value="">Chọn mã cơ quan</option>
                                                        @foreach ($macoquan as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{(isset($profile) ?  $profile->config_id :  old('config_id') == $item->id) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->agency_name }} -
                                                                {{ $item->agency_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('ma_coquan')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="ma-phong-select" class="form-label">Mã phông <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select ma_phong {{ $errors->has('ma_phong') ? 'is-invalid' : '' }}"
                                                        name="ma_phong" id="ma-phong-select">
                                                        <option value="">Chọn mã phông</option>
                                                    </select>
                                                    @error('ma_phong')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã mục lục <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('ma_muc_luc') ? 'is-invalid' : '' }}"
                                                        name="ma_muc_luc" id="mucluc-select">
                                                        <option value="">Chọn mã mục lục</option>
                                                        {{-- @foreach ($mamucluc as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{(isset($profile) ?  $profile->ma_muc_luc :  old('ma_muc_luc') == $item->id) ? 'selected' : '' }}>
                                                                {{ $item->ten_mucluc }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('ma_muc_luc')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hộp số<span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{isset($profile) ?  $profile->hop_so : old('hop_so') }}"
                                                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }}"
                                                        name="hop_so" type="text" id="example-text-input"
                                                        placeholder="Hộp số">
                                                    @error('hop_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hồ sơ số<span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ isset($profile) ?  $profile->ho_so_so : old('ho_so_so') }}"
                                                        class="form-control {{ $errors->has('ho_so_so') ? 'is-invalid' : '' }}"
                                                        name="ho_so_so" type="text" id="example-text-input"
                                                        placeholder="Hồ sơ số">
                                                    @error('ho_so_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Số tờ <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ isset($profile) ?  $profile->so_to : old('so_to') }}"
                                                        class="form-control {{ $errors->has('so_to') ? 'is-invalid' : '' }}"
                                                        name="so_to" type="text" id="example-text-input"
                                                        placeholder="số tờ">
                                                    @error('so_to')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label"> THBQ <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{isset($profile) ?  $profile->thbq :  old('thbq') }}"
                                                        class="form-control {{ $errors->has('thbq') ? 'is-invalid' : '' }}"
                                                        name="thbq" type="text" id="example-text-input"
                                                        placeholder="THBQ">
                                                    @error('thbq')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Tiêu đề hồ sơ <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ isset($profile) ?  $profile->tieu_de_ho_so : old('tieu_de_ho_so') }}"
                                                    class="form-control {{ $errors->has('tieu_de_ho_so') ? 'is-invalid' : '' }}"
                                                    name="tieu_de_ho_so" type="text" id="example-text-input"
                                                    placeholder="Tiêu đề hồ sơ ">
                                                @error('tieu_de_ho_so')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            @php
                                                use Illuminate\Support\Facades\Blade;

                                                $template = $template_form_hoso->template_form;

                                                $compiled = Blade::compileString($template);

                                                eval('?>'.$compiled);
                                            @endphp
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4">
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

            // Sự kiện thay đổi cho #agency_code-select
            $('#agency_code-select').change(function() {
                var selectedId = $(this).val();
                if (selectedId) {
                    getPhong(selectedId);
                }
            });

            // Gọi hàm getPhong khi trang tải
            var selectedId = $('#agency_code-select').val();
            getPhong(selectedId);

            // Sự kiện thay đổi cho #ma-phong-select
            $('#ma-phong-select').change(function() {
                var selectedphong = $(this).val();
                if (selectedphong) {
                    getMucluc(selectedphong);
                }
            });
        });

        // Hàm getPhong
        function getPhong(selectedValue) {
            var ma_phong = "{{ $profile->ma_phong }}";
            var url = "{{ route('phong-to-config') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var selectElement = $('#ma-phong-select');
                        selectElement.find('option').remove();
                        selectElement.append('<option value="">Chọn mã phông</option>');
                        response.data.forEach(function(item) {
                            var option = $('<option>', {
                                value: item.id,
                                text: item.ten_phong
                            });
                            if (item.id == ma_phong) {
                                option.prop('selected', true);
                                // Gọi getMucluc cho mã phông đã chọn
                                getMucluc(item.id);
                            }
                            selectElement.append(option);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Hàm getMucluc
        function getMucluc(selectedphong) {
            var ma_mucluc = "{{ $profile->ma_muc_luc }}";  // Mã mục lục từ profile
            var url = "{{ route('mucluc-to-phong') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedphong
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var selectMucluc = $('#mucluc-select');
                        selectMucluc.find('option').remove();
                        selectMucluc.append('<option value="">Chọn mã mục lục</option>');
                        response.data.forEach(function(item) {
                            var option = $('<option>', {
                                value: item.id,
                                text: item.ten_mucluc
                            });
                            if (item.id == ma_mucluc) { // Kiểm tra và chọn mã mục lục theo profile
                                option.prop('selected', true);
                            }
                            selectMucluc.append(option);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>



@endsection
