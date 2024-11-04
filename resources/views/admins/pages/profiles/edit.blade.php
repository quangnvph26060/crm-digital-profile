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
                                                                {{ (isset($profile) ? $profile->config_id : old('config_id') == $item->id) == $item->id ? 'selected' : '' }}>
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
                                                    {{-- <input
                                                        value="{{ isset($profile) ? $profile->hop_so : old('hop_so') }}"
                                                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }}"
                                                        name="hop_so" type="text" id="example-text-input"
                                                        placeholder="Hộp số"> --}}
                                                    <select
                                                        class="form-select ma_phong {{ $errors->has('hop_so') ? 'is-invalid' : '' }}"
                                                        name="hop_so" id="hop_so">
                                                        <option value="">Chọn hộp số</option>
                                                    </select>

                                                    @error('hop_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hồ sơ số<span
                                                            class="text text-danger">*</span></label>
                                                    <input
                                                        value="{{ isset($profile) ? $profile->ho_so_so : old('ho_so_so') }}"
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
                                                    <input value="{{ isset($profile) ? $profile->so_to : old('so_to') }}"
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
                                                    <input value="{{ isset($profile) ? $profile->thbq : old('thbq') }}"
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
                                                <input
                                                    value="{{ isset($profile) ? $profile->tieu_de_ho_so : old('tieu_de_ho_so') }}"
                                                    class="form-control {{ $errors->has('tieu_de_ho_so') ? 'is-invalid' : '' }}"
                                                    name="tieu_de_ho_so" type="text" id="example-text-input"
                                                    placeholder="Tiêu đề hồ sơ ">
                                                @error('tieu_de_ho_so')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            {{-- @php

                                            use Illuminate\Support\Facades\Blade;

                                            $template = $template_form_hoso->template_form ?? null;


                                            if (!empty($template)) {
                                                    $compiled = Blade::compileString($template);
                                                    eval('?>'.$compiled);
                                                } else {
                                                 
                                                    echo "";
                                                }
                                        @endphp --}}
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label for="date_start-text-input" class="form-label">Ngày bắt đầu
                                                        <span class="text text-danger">*</span></label>
                                                    <input
                                                        value="{{ isset($profile) ? date('Y-m-d', strtotime($profile->ngay_bat_dau)) : old('ngay_bat_dau') }}"
                                                        class="form-control {{ $errors->has('ngay_bat_dau') ? 'is-invalid' : '' }}"
                                                        name="ngay_bat_dau" type="date" id="date_start-text-input">

                                                </div>
                                                <div class=" col-lg-6 mb-3">
                                                    <label for="date_end-text-input" class="form-label">Ngày kết thúc
                                                        <span class="text text-danger">*</span></label>
                                                    <input
                                                        value="{{ isset($profile) ? date('Y-m-d', strtotime($profile->ngay_ket_thuc)) : old('ngay_ket_thuc') }}"
                                                        class="form-control {{ $errors->has('ngay_ket_thuc') ? 'is-invalid' : '' }}"
                                                        name="ngay_ket_thuc" type="date" id="date_end-text-input">

                                                </div>

                                            </div>
                                            <div class="col-lg-12 "
                                                style="display: flex !important;flex-direction: column;">

                                                <p>
                                                    Ghi chú <span class="text text-danger">*</span>
                                                </p>
                                                <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                                                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ isset($profile) ? $profile->ghi_chu : old('ghi_chu') }}</textarea>

                                            </div>

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
            function getSelectedValues() {
                var selectedCoQuan = $('#agency_code-select').val();
                var phong = '{{ $profile->ma_phong }}';
                var mucluc = '{{ $profile->ma_muc_luc }}';
                var hop_so = '{{ $profile->hop_so }}';

                return {
                    coquan: selectedCoQuan,
                    phong: phong,
                    mucluc: mucluc,
                    hop_so: hop_so
                };
            }
            var selectedValues = getSelectedValues();

            if (selectedValues.coquan) {
                searchPhong(selectedValues.coquan)
            }

            $('#agency_code-select').on('change', function() {
                var selectedCoQuan = $('#agency_code-select').val();
                
                searchPhong(selectedCoQuan);
            });

            function searchMucLuc(selectedMucLuc) {
                var url = "{{ route('admin.profile.searchMucLuc') }}"
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        coquan: selectedMucLuc
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var data = response.data;
                            var selectElement = document.getElementById('mucluc-select');

                            selectElement.innerHTML = '';
                            var selectedValues = getSelectedValues();
                            Object.keys(data).forEach(function(key) {
                                var option = document.createElement('option');
                                option.value = data[key];
                                option.text = key;
                                if (data[key] == selectedValues.mucluc) {
                                    option.selected = true;
                                }
                                selectElement.add(option);
                            });

                            selectElement.disabled = false;
                            sendAjaxRequest(selectedValues);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi AJAX:', error);
                    }
                });
            }

            function handleAjaxSuccess(response) {
                if (response.status === 'success') {
                    var data = response.data;
                    var selectElement = document.getElementById('hop_so');

                    selectElement.innerHTML = '';

                    Object.keys(data).forEach(function(key) {
                        var option = document.createElement('option');
                        option.value = data[key];
                        option.text = data[key];
                        selectElement.add(option);
                    });

                    selectElement.disabled = false;
                }
            }
            function sendAjaxRequest(selectedValues) {
                var url = "{{ route('admin.profile.searchHoSo') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: selectedValues,
                    success: function(response) {
                        handleAjaxSuccess(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi AJAX:', error);
                    }
                });
            }
            function searchPhong(selectedCoQuan) {
                var url = "{{ route('admin.profile.searchPhong') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        coquan: selectedCoQuan
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var data = response.data;
                            var selectElement = document.getElementById('ma-phong-select');
                            selectElement.innerHTML = '';
                            Object.keys(data).forEach(function(key) {
                                var option = document.createElement('option');
                                option.value = data[key];
                                option.text = key;
                                if (data[key] == selectedValues.phong) {
                                    option.selected = true;
                                }
                                selectElement.add(option);
                            });

                            selectElement.disabled = false;
                            var selectedPhong = $('#ma-phong-select').val();
                            searchMucLuc(selectedPhong)
                            // var selectedValues = getSelectedValues();
                            // sendAjaxRequest(selectedValues);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi AJAX:', error);
                    }
                });
            }
            function searchHopSo(selectedCoQuan, selectedPhong, selectedMucLuc) {
                var url = "{{ route('admin.profile.searchHopSo') }}"
                console.log('123');
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        coquan: selectedCoQuan,
                        phong: selectedPhong,
                        mucluc: selectedMucLuc
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var data = response.data;
                           
                            var selectElement = document.getElementById('hop_so');

                            selectElement.innerHTML = '';

                            Object.keys(data).forEach(function(key) {
                                var option = document.createElement('option');
                                option.value = data[key];
                                option.text = key;
                                // if (data[key] == params.muc_luc) {
                                //     option.selected = true;
                                // }
                                selectElement.add(option);
                            });

                            selectElement.disabled = false;


                            var selectedValues = getSelectedValues();

                            sendAjaxRequest(selectedValues);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi AJAX:', error);
                    }
                });
            }
            $('#agency_code-select, #ma-phong-select, #mucluc-select').on('change', function() {
                var selectedCoQuan = $('#agency_code-select').val();
                var selectedPhong = $('#ma-phong-select').val();
                var selectedMucLuc = $('#mucluc-select').val();
             
                if (selectedCoQuan && selectedPhong && selectedMucLuc) {
                    searchHopSo(selectedCoQuan, selectedPhong, selectedMucLuc);
                }
            });
        });
    </script>



@endsection
