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
                            <h4 class="card-title">Thông tin hồ sơ</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.storeProfile') }}" method="POST">
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
                                                        class="form-select {{ $errors->has('config_id ') ? 'is-invalid' : '' }} select2"
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
                                                        class="form-select ma_phong {{ $errors->has('ma_phong') ? 'is-invalid' : '' }} select2"
                                                        name="ma_phong" id="ma-phong-select">
                                                        <option value="">Chọn mã phông</option>
                                                    </select>
                                                    {{-- @error('ma_phong')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror --}}
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã mục lục <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('ma_muc_luc') ? 'is-invalid' : '' }} select2"
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
                                            <div class="row mb-3">
                                                <div class="col-lg-12">
                                                    <label for="example-text-input" class="form-label">Hộp số<span
                                                            class="text text-danger">*</span></label>
                                                    {{-- <input value="{{ isset($profile) ? $profile->hop_so : old('hop_so') }}"
                                                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }}"
                                                        name="hop_so" type="text" id="example-text-input"
                                                        placeholder="Hộp số"> --}}

                                                    <select
                                                        class="form-select ma_phong {{ $errors->has('hop_so') ? 'is-invalid' : '' }} select2a"
                                                        name="hop_so" id="hop_so">
                                                        <option value="">Chọn hộp số</option>
                                                    </select>
                                                    {{-- @error('hop_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror --}}
                                                </div>

                                        </div>
                                    </div>
                                    @foreach ($columns as $key => $column)
                                        <div class="row mb-3 ">
                                            <div class="col-lg-12 mb-3">
                                                <label for="example-text-input-{{ $column['name'] }}" class="form-label">
                                                    {{ $column['comment'] }} <span class="text text-danger">*</span>
                                                </label>

                                                @if ($column['type'] === 'text')
                                                    <textarea class="form-control {{ $errors->has($column['name']) ? 'is-invalid' : '' }}" name="{{ $column['name'] }}"
                                                        id="example-text-input-{{ $column['name'] }}" placeholder="{{ $column['comment'] }}">{{ isset($profile) ? $profile->{$column['name']} : old($column['name']) }}</textarea>
                                                @else
                                                    <input
                                                        value="{{ isset($profile) ? $profile->{$column['name']} : old($column['name']) }}"
                                                        class="form-control {{ $errors->has($column['name']) ? 'is-invalid' : '' }}"
                                                        name="{{ $column['name'] }}" type="{{ $column['type'] }}"
                                                        id="example-text-input-{{ $column['name'] }}"
                                                        placeholder="{{ $column['comment'] }}">
                                                @endif

                                                @error($column['name'])
                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        var $jq = jQuery.noConflict();
        $jq(document).ready(function() {
            console.log("Kích hoạt Select2");
            $jq('.select2').select2({
                width: '100%',
                // tags: true,
                // allowClear: true

            });

            $jq('.select2a').select2({
                width: '100%',
                tags: true,
                // allowClear: true

            });
        });
    </script>
    <script>
        $jq(document).ready(function() {
            $jq('#date_end-text-input').on('change', function() {
                var startDate = new Date($jq('#date_start-text-input').val());
                var endDate = new Date($jq(this).val());
                if (endDate < startDate) {
                    alert('Ngày kết thúc không thể nhỏ hơn ngày bắt đầu!');
                    $jq(this).val('');
                }
            });
        });
        $jq(document).ready(function() {

            $jq('#agency_code-select').change(function() {
                var selectedValue = $jq(this).val();
                if (selectedValue) {
                    var url = "{{ route('phong-to-config') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: selectedValue
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                var selectElement = $jq(
                                    '#ma-phong-select'); // Lấy đối tượng select

                                // Xóa tất cả các option hiện có trong select
                                selectElement.find('option').remove();

                                // Thêm option mặc định
                                selectElement.append('<option value="">Chọn mã phông</option>');
                                response.data.forEach(function(item) {
                                    selectElement.append('<option value="' + item.id +
                                        '" >' + item
                                        .ten_phong + '</option>')
                                });

                                $jq('#ma-phong-select').change(function() {
                                    var selectedphong = $jq(this).val();
                                    if (selectedValue) {

                                        var url = "{{ route('mucluc-to-phong') }}";
                                        $.ajax({
                                            url: url,
                                            type: 'GET',
                                            data: {
                                                id: selectedphong
                                            },
                                            success: function(response) {

                                                if (response.status ===
                                                    'success') {
                                                    var selectMucluc = $jq(
                                                        '#mucluc-select'
                                                    );

                                                    selectMucluc.find(
                                                            'option')
                                                        .remove();

                                                    selectMucluc.append(
                                                        '<option value="">Chọn mã mục lục</option>'
                                                    );
                                                    response.data.forEach(
                                                        function(item) {
                                                            selectMucluc
                                                                .append(
                                                                    '<option value="' +
                                                                    item
                                                                    .id +
                                                                    '" >' +
                                                                    item
                                                                    .ten_mucluc +
                                                                    '</option>'
                                                                );

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
            $jq('#ma-phong-select').change(function() {
                var selectedValue = $jq(this).val();

            })
            $jq('#mucluc-select').change(function() {
                var selectedMucLuc = $jq(this).val();


            })
        });

        $jq(document).ready(function() {
            function getSelectedValues() {
                var selectedCoQuan = $jq('#agency_code-select').val();
                var selectedPhong = $jq('#ma-phong-select').val();
                var selectedMucLuc = $jq('#mucluc-select').val();

                return {
                    coquan: selectedCoQuan,
                    phong: selectedPhong,
                    muc_luc: selectedMucLuc
                };
            }
            var selectedValues = getSelectedValues();

            function searchHopSo(selectedCoQuan, selectedPhong, selectedMucLuc) {
                var url = "{{ route('admin.profile.searchHopSo') }}"
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
                            selectElement.append('<option value="">Chọn hộp số</option>');
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
            $jq('#agency_code-select, #ma-phong-select, #mucluc-select').on('change', function() {
                var selectedCoQuan = $jq('#agency_code-select').val();
                var selectedPhong = $jq('#ma-phong-select').val();
                var selectedMucLuc = $jq('#mucluc-select').val();
                if (selectedCoQuan && selectedPhong && selectedMucLuc) {
                    searchHopSo(selectedCoQuan, selectedPhong, selectedMucLuc);
                }
            });
        });
    </script>
@endsection
