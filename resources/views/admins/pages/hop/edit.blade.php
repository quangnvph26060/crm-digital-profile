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
                        <form action="{{ route('admin.mucluc.store') }}" method="POST">
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
                                                    <option value="{{ $item->id }}" {{ (isset($hopso) && $hopso->coquan_id == $item->id) ? 'selected': '' }}>
                                                        {{ $item->agency_name }} - {{ $item->agency_code }}
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
                                            <input value="{{ isset($hopso) ? $hopso->hop_so : old('hop_so') }}" required
                                                class="form-control" value="" name="hop_so" type="text" id="hop_so"
                                                list="agency-codes">
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
        // Sự kiện thay đổi cho Agency Code (thẻ cha)
        $('#coquan').on('change', function() {
            var selectedValue = $(this).val();
            loadMaPhong(selectedValue, null); // Khi chọn lại thẻ cha, reset các giá trị con
        });

        // Hàm load Ma Phong khi có Agency Code
        function loadMaPhong(selectedValue, selectedMaPhong) {
            var selectElementMaPhong = $('#phong');
            var selectElementMucLuc = $('#mucluc');


            // Reset tất cả các select box
            selectElementMaPhong.find('option').remove().append('<option value="">Chọn mã phòng</option>');
            selectElementMucLuc.find('option').remove().append('<option value="">Chọn mục lục</option>');


            if (selectedValue) {
                var url = "{{ route('hop-so-phong-by-config_id') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: selectedValue
                    },
                    success: function(response) {
                        console.log(response.data);
                        if (response.status === 'success') {
                            selectElementMaPhong.append('<option value="">Chọn mã phòng</option>');
                            selectElementMucLuc.append('<option value="">Chọn mục lục</option>');

                            response.data.forEach(function(item) {
                                var isSelected = item.id == selectedMaPhong ? 'selected' : '';
                                selectElementMaPhong.append('<option value="' + item.id + '" ' + isSelected + '>' + item.ten_phong + '</option>');
                            });

                            // Gắn sự kiện change cho Ma Phong sau khi đổ dữ liệu
                            selectElementMaPhong.off('change').on('change', function() {
                                var selectedMaPhong = $(this).val();
                                loadMucLuc(selectedValue, selectedMaPhong, null); // Reset Mục Lục khi thay đổi Ma Phong
                            });

                            // Nếu có giá trị sẵn, gọi loadMucLuc
                            if (selectedMaPhong) {
                                loadMucLuc(selectedValue, selectedMaPhong, `{{ $hopso->mucluc_id }}`);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }else{
                selectElementMaPhong.append('<option value="">Chọn mã phòng</option>');
                selectElementMucLuc.append('<option value="">Chọn mục lục</option>');

            }
        }

        // Hàm load Muc Luc khi có Ma Phong
        function loadMucLuc(selectedValue, selectedMaPhong, selectedMucLuc) {
            var selectElementMucLuc = $('#mucluc');
            // Reset tất cả các select box con
            selectElementMucLuc.find('option').remove().append('<option value="">Chọn mục lục</option>');

            if (selectedMaPhong) {
                var url = "{{ route('hop-so-mucluc-by-phong_id') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: selectedValue,
                        phongId: selectedMaPhong
                    },
                    success: function(response) {
                        if (response.status === 'success') {

                            selectElementMucLuc.append('<option value="">Chọn mục lục</option>');
                            response.data.forEach(function(item) {
                                var isSelected = item.id == selectedMucLuc ? 'selected' : '';
                                selectElementMucLuc.append('<option value="' + item.id + '" ' + isSelected + '>' + item.ten_mucluc + '</option>');
                            });

                            // Gắn sự kiện change cho Muc Luc sau khi đổ dữ liệu
                            selectElementMucLuc.off('change').on('change', function() {
                                var selectedMucLuc = $(this).val();

                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }else{

                selectElementMucLuc.append('<option value="">Chọn mục lục</option>');

            }
        }

        // Khi trang được load lần đầu, tự động gọi loadMaPhong nếu đã có sẵn giá trị
        var initialConfigId = $('#coquan').val();
        var initialMaPhong = `{{ $hopso->phong_id }}`; // Giá trị mã phòng có sẵn

        if (initialConfigId) {
            loadMaPhong(initialConfigId, initialMaPhong); // Load mã phòng ban đầu
        }
    });



</script>


@endsection
