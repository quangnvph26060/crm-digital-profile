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
                                                    <select class="form-select" name="ma_coquan" id="agency_code-select"
                                                        required>
                                                        <option value="">Chọn mã cơ quan</option>
                                                        @foreach ($macoquan as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $profile->config_id == $item->id ? 'selected' : '' }}>
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
                                                    <select class="form-select ma_phong" name="ma_phong" required
                                                        id="ma-phong-select">
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
                                                    <select class="form-select" name="ma_mucluc" id="agency_code-select"
                                                        required>
                                                        <option value="">Chọn mã mục lục</option>
                                                        @foreach ($mamucluc as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $profile->ma_muc_luc == $item->id ? 'selected' : '' }}>{{ $item->ten_mucluc }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ma_mucluc')
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
                                                    <input required value="{{ $profile->hop_so }}" required
                                                        class="form-control" name="hop_so" type="text"
                                                        id="example-text-input" placeholder="Hộp số">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hồ sơ số<span
                                                            class="text text-danger">*</span></label>
                                                    <input required value="{{ $profile->ho_so_so }}" required
                                                        class="form-control" name="ho_so_so" type="text"
                                                        id="example-text-input" placeholder="Hồ sơ số">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Số tờ <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ $profile->so_to }}" required class="form-control"
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
                                                    <input value="{{ $profile->thbq }}" required class="form-control"
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
                                                <input required value="{{ $profile->tieu_de_ho_so }}" required
                                                    class="form-control" name="tieu_de_ho_so" type="text"
                                                    id="example-text-input" placeholder="Tiêu đề hồ sơ ">
                                                @error('tieu_de_ho_so')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Ngày bắt đầu <span
                                                            class="text text-danger">*</span></label>
                                                    <input required value="{{  date('Y-m-d', strtotime($profile->ngay_bat_dau)) }}" required
                                                        class="form-control" name="date_start" type="date"
                                                        id="example-text-input">
                                                    @error('date_start')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class=" col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Ngày kết thúc <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ date('Y-m-d', strtotime($profile->ngay_ket_thuc)) }}" required class="form-control"
                                                        name="date_end" type="date" id="example-text-input">
                                                    @error('date_end')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-12 "
                                                style="display: flex !important;flex-direction: column;">

                                                <p>
                                                    Ghi chú <span class="text text-danger">*</span>
                                                </p>
                                                <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                                                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{$profile->ghi_chu}}</textarea>
                                                @error('ghi_chu')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
            $('#agency_code-select').change(function() {
                var selectedId = $(this).val();
                if (selectedId) {
                    getPhong(selectedId)
                }
            });
        });
        $(document).ready(function() {
            var selectedId = $('#agency_code-select').val();
            getPhong(selectedId)


        });

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
    </script>
@endsection
