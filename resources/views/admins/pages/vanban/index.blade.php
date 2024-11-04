@extends('admins.layouts.index')
@section('title', $title)
@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/vanban.css') }}">
@endsection
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3 mb-3">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                </div>
                {{-- <div class="" style="float: right">
                    <a class="btn btn-success" href="{{ route('admin.config.add') }}">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Số và ký hiệu văn bản</label>
                                        <input value="{{ isset($inputs['name']) ? $inputs['name'] : '' }}"
                                            autocomplete="off" name="name" placeholder="Tìm kiếm..." type="text"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Cơ quan</label>
                                        <select class="form-select" name="coquan" id="coquan">
                                            <option value="">Chọn cơ quan</option>
                                            @foreach ($configdata as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($inputs['coquan']) ? ($inputs['coquan'] == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->agency_name }}</option>
                                            @endforeach
                                            <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Phông</label>
                                        <select class="form-select" name="phong" id="phong" disabled>
                                            <option value="">Chọn Phông</option>

                                            @foreach ($phongdata as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($inputs['phong']) ? ($inputs['phong'] == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->ten_phong }}</option>
                                            @endforeach
                                            <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Mục lục</label>
                                        <select class="form-select" name="muc_luc" id="muc_luc" disabled>
                                            <option value="">Chọn mục lục</option>
                                            @foreach ($muclucdata as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($inputs['muc_luc']) ? ($inputs['muc_luc'] == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->ten_mucluc }}</option>
                                            @endforeach

                                            <!-- Thêm các tùy chọn mục lục khác nếu cần -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Hộp số</label>
                                        <select class="form-select" name="hop_so" id="hop_so" disabled>
                                            <option value="{{ isset($inputs['hop_so']) ? $inputs['hop_so'] : '' }}">
                                                {{ isset($inputs['hop_so']) ? $inputs['hop_so'] : 'Chọn hộp số' }}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm
                                            kiếm</button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger "
                                            style="margin: 0px 10px"><i class="fas fa-history"></i> Tải lại</a>
                                        @if (auth('admin')->user()->level === 2)
                                            <a class="btn btn-success" href="{{ route('admin.vanban.add') }}">
                                                <i class="fas fa-plus"></i> Thêm mới
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="row mt-3">
                            <div class="form-group">
                                <!-- Nút Import -->
                                @if (auth('admin')->user()->level === 2)
                                    <button type="button" class="btn btn-primary" style="margin-right: 20px"
                                        data-bs-toggle="modal" data-bs-target="#importModal">
                                        Import Excel
                                    </button>
                                @endif

                                <!-- Modal -->
                                <div class="modal fade @if ($errors->any()) show @endif" id="importModal"
                                    tabindex="-1" aria-labelledby="importModalLabel"
                                    aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importModalLabel">Import File</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form Import -->
                                                <form action="{{ route('admin.vanban.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="importFile" class="form-label">Chọn file
                                                            Excel</label>
                                                        <input
                                                            class="form-control @error('importexcel') is-invalid @enderror"
                                                            type="file" id="importFile" name="importexcel" required>
                                                        @error('importexcel')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Import</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nút Export -->
                                <a href="{{ route('admin.vanban.export') }}" class="btn btn-success">Export Excel</a>

                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-3 main-option">
                                <label for="column-select">Chọn cột để hiển thị:</label>
                                <div class="selectBox form-select" id="toggleBtn">

                                    <option>Chọn cột</option>

                                    <div class="overSelect"></div>
                                </div>
                                <div class="checkboxes" id="checkboxes">
                                    <form id="applyForm" action="{{ route('admin.vanban.column') }}" method="post">
                                        <input type="hidden" id="selectedValuesInput" name="selectedValues">
                                        @csrf
                                        @if ($fillableFields)
                                            @forelse ($fillableFields as $key => $value)
                                                @if ($value !== 'ma_co_quan' && $value !== 'ma_phong' && $value !== 'ma_mucluc' && $value !== 'hop_so'&& $value !== 'ho_so_so' && $value !== 'profile_id')
                                                    @php
                                                        $isChecked = in_array($value, $selectedProfiles);
                                                    @endphp
                                                    <label>
                                                        <input type="checkbox" style="margin-right: 5px"
                                                            value="{{ $value }}"
                                                            {{ $isChecked ? 'checked' : '' }}>
                                                        {{ $columnComments[$value] ?? $key }}
                                                    </label>
                                                @endif
                                            @empty
                                                <label>Không có dữ liệu</label>
                                            @endforelse
                                        @else
                                            <label>Không có dữ liệu</label>
                                        @endif
                                        <button id="applyBtn"
                                            class="btn btn-primary"style="margin-top: 10px;">Lưu</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            @include('globals.alert')
                        </div>
                        <div class="card-body" style="overflow-x: auto; max-width: 100%; padding: 20px 0px;">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        {{-- @dd($vanban); --}}
                                        {{-- Hiển thị tiêu đề cho các cột bạn muốn --}}
                                        @if ($vanban && $vanban->first())
                                            <th>STT</th>
                                            @foreach ($vanban->first()->getAttributes() as $column => $value)
                                                @if (
                                                    !in_array($column, [
                                                        'ma_co_quan',
                                                        'ma_mucluc',
                                                        'hop_so',
                                                        'ho_so_so',
                                                        'ma_phong',
                                                        'created_at',
                                                        'updated_at',
                                                        'profile_id',
                                                        'duong_dan',
                                                        'id',
                                                    ]))
                                                    <th>{{ $columnComments[$column] ?? $column }}</th>
                                                @endif
                                            @endforeach
                                            <th>Thao tác</th>
                                        @endif


                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentProfileId = null;
                                        $currentPhong = null;
                                    @endphp
                                    {{-- @dd($vanban); --}}
                                    @forelse ($vanban as $index => $item)
                                        @if ($currentProfileId != $item->profile_id || $currentPhong != $item->maPhong)
                                            @php
                                                $currentProfileId = $item->profile_id;
                                                $currentPhong = $item->maPhong;
                                            @endphp

                                            <tr class="row-header">
                                                <td style="padding: 0px 10px"
                                                    colspan="{{ count($item->getAttributes()) - count(['ma_co_quan', 'ma_mucluc', 'hop_so', 'ho_so_so', 'ma_phong', 'created_at', 'updated_at', 'profile_id', 'duong_dan', 'id']) + 2 }}">
                                                    <strong>Cơ quan : {{ $item->config->agency_code ?? "" }} / Phông:
                                                        {{ $item->maPhong->ten_phong ?? "" }} / Mục lục:
                                                        {{ $item->maMucLuc->ten_mucluc ?? "" }} / Hộp số:
                                                        {{ $item->hop_so }} / Hồ sơ số: {{ $item->ho_so_so }} / Hồ
                                                        sơ: {{ $item->profile->tieu_de_ho_so }}</strong>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            @foreach ($item->getAttributes() as $column => $value)
                                                {{-- Kiểm tra xem cột có nằm trong danh sách cần ẩn không --}}
                                                @if (
                                                    !in_array($column, [
                                                        'ma_co_quan',
                                                        'ma_mucluc',
                                                        'hop_so',
                                                        'ho_so_so',
                                                        'ma_phong',
                                                        'created_at',
                                                        'updated_at',
                                                        'profile_id',
                                                        'duong_dan',
                                                        'id',
                                                    ]))
                                                    <td>
                                                        @if ($column === 'status')
                                                            {{-- Kiểm tra cột status --}}
                                                            {!! $value === 'active' ? 'Công khai' : 'Không công khai' !!}
                                                        @else
                                                            {!! $value !!}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="d-flex gap-1">
                                                @if (auth('admin')->user()->level === 2)
                                                    <a href="{{ route('admin.vanban.edit', ['id' => $item->id]) }}"
                                                        class="btn btn-warning">
                                                        <img src="{{ asset('svg/detail.svg') }}" alt="SVG Image">
                                                    </a>
                                                    <form method="post"
                                                        action="{{ route('admin.vanban.delete', ['id' => $item->id]) }}"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('admin.vanban.view', ['id' => $item->id]) }}"
                                                    class="btn btn-primary">
                                                    <img src="{{ asset('svg/edit.svg') }}" alt="SVG Image">
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <p> Chưa có dữ liệu</p>
                                            {{-- <td
                                            colspan="{{ count($item->getAttributes()) - count(['ma_co_quan', 'ma_mucluc', 'hop_so_so', 'ho_so_so', 'ma_phong', 'created_at', 'updated_at']) }}">
                                            Không có dữ liệu</td> --}}
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4" style="margin: 0px auto">
                            {{ $vanban->links() }}
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function getSelectedValues() {
                var selectedCoQuan = $('#coquan').val();
                var selectedPhong = $('#phong').val();
                var selectedMucLuc = $('#muc_luc').val();

                return {
                    coquan: selectedCoQuan,
                    phong: selectedPhong,
                    muc_luc: selectedMucLuc
                };
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

            // Lấy giá trị khi trang được tải lại
            var selectedValues = getSelectedValues();

            // Kiểm tra và gửi yêu cầu AJAX nếu có đủ giá trị
            if (selectedValues.coquan && selectedValues.phong && selectedValues.muc_luc) {
                sendAjaxRequest(selectedValues);
            }


            if (selectedValues.coquan && selectedValues.phong) {
                // var url = new URL(window.location.href);
                // var params = new URLSearchParams(url.search);
                // var phong = params.get('phong');
                // var coquan = params.get('coquan');
                searchPhong(selectedValues.coquan)
                searchMucLuc(selectedValues.phong)
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
                            var selectElement = document.getElementById('phong');

                            selectElement.innerHTML = '';

                            Object.keys(data).forEach(function(key) {
                                var option = document.createElement('option');
                                option.value = data[key];
                                option.text = key;
                                selectElement.add(option);
                            });

                            selectElement.disabled = false;
                            var selectedPhong = $('#phong').val();
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
                            var selectElement = document.getElementById('muc_luc');

                            selectElement.innerHTML = '';

                            Object.keys(data).forEach(function(key) {
                                var option = document.createElement('option');
                                option.value = data[key];
                                option.text = key;
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
            $('#coquan').on('change', function() {
                var selectedCoQuan = $('#coquan').val();
                searchPhong(selectedCoQuan);
            });
            $('#phong').on('change', function() {
                var selectedMucLuc = $('#phong').val();
                searchMucLuc(selectedMucLuc)
            });


            // Xử lý sự kiện thay đổi
            $('#coquan, #phong, #muc_luc').on('change', function() {
                var selectedValues = getSelectedValues();
                if (selectedValues.coquan && selectedValues.phong && selectedValues.muc_luc) {
                    sendAjaxRequest(selectedValues);
                }
            });
        });


        $(document).ready(function() {
            $("#applyBtn").on("click", function(e) {
                e.preventDefault();
                var selectedValues = [];
                $("input[type='checkbox']:checked").each(function() {
                    selectedValues.push($(this).val());
                });
                var selectedValuesJSON = JSON.stringify(selectedValues);

                $("#selectedValuesInput").val(selectedValuesJSON);


                $("#applyForm").submit();
            });
        });
        $(document).ready(function() {
            $('#column-select').on('change', function() {
                var selectedColumns = $(this).val() || [];

                // Ẩn tất cả các cột trước khi hiển thị các cột đã chọn
                $('#userTable th, #userTable td').addClass('hidden');

                // Hiển thị các cột đã chọn
                selectedColumns.forEach(function(column) {
                    $('#userTable .column-' + column).removeClass('hidden');
                });
            });
        });
        $(document).ready(function() {
            let show = true;

            $("#toggleBtn").on("click", function() {
                let checkboxes = $("#checkboxes");

                if (show) {
                    checkboxes.css("display", "block");
                    show = false;
                } else {
                    checkboxes.css("display", "none");
                    show = true;
                }
            });
        });
        $(document).ready(function() {
            $('#exportExcelBtn').on('click', function() {
                $('<input type="file">').change(function() {
                    var selectedFile = this.files[0];
                    console.log('File đã chọn:', selectedFile);


                    var formData = new FormData();
                    formData.append('file', selectedFile);
                    var url = "{{ route('import') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log('Kết quả:', response);

                        },
                        error: function(xhr, status, error) {
                            console.error('Đã xảy ra lỗi khi gửi file.');
                        }
                    });
                }).click();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let show = true;
            $("#toggleBtn").on("click", function() {
                let checkboxes = $("#checkboxes");

                if (show) {
                    checkboxes.css("display", "block");
                    show = false;
                } else {
                    checkboxes.css("display", "none");
                    show = true;
                }
            });
        });
        $(document).ready(function() {
            $("#applyBtn").on("click", function(e) {
                e.preventDefault();
                var selectedValues = [];
                $("input[type='checkbox']:checked").each(function() {
                    selectedValues.push($(this).val());
                });
                var selectedValuesJSON = JSON.stringify(selectedValues);

                $("#selectedValuesInput").val(selectedValuesJSON);


                $("#applyForm").submit();
            });
        });
        $(document).ready(function() {
            $('#column-select').on('change', function() {
                var selectedColumns = $(this).val() || [];

                $('#userTable th, #userTable td').addClass('hidden');

                selectedColumns.forEach(function(column) {
                    $('#userTable .column-' + column).removeClass('hidden');
                });
            });
        });

    </script>
    <script>
         document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var importModal = new bootstrap.Modal(document.getElementById('importModal'));
                importModal.show();
            @endif
        });
    </script>
@endsection
