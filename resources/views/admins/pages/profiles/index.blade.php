@extends('admins.layouts.index')
@section('title', $title)
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/profiles.css') }}">
@endsection
@section('content')
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
                        <div class="card-header h-190">
                            <form method="GET">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Tiêu đề hồ sơ và Mã Cơ quan</label>
                                            <input value="{{ isset($inputs['name']) ? $inputs['name'] : '' }}"
                                                autocomplete="off" name="name" placeholder="Tìm kiếm..." type="text"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-8 mt-2">
                                        <div class="form-group">
                                            <label for="" style="opacity: 0">1</label> <br>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm
                                                kiếm</button>
                                            <a href="{{ url()->current() }}" class="btn btn-danger"><i
                                                    class="fas fa-history"></i> Tải lại</a>
                                            @if (auth('admin')->user()->level === 2)
                                                <a class="btn btn-success" href="{{ route('admin.profile.add') }}">
                                                    <i class="fas fa-plus"></i> Thêm mới
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-lg-6 mt-2 hoso__position">
                                <div class="d-flex  flex-wrap" style="gap: 5px">
                                    @if (auth('admin')->user()->level === 2)
                                    <div class="">
                                        <button class="btn btn-primary" style="margin-right: 20px"
                                            data-bs-toggle="modal" data-bs-target="#importModal">
                                            Import Excel
                                        </button>
                                    </div>
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
                                                <form id="importForm" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="importFile" class="form-label">Chọn file Excel</label>
                                                        <input class="form-control @error('file') is-invalid @enderror" type="file" id="importFile" name="file" required>
                                                        @error('file')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="button" id="exportExcelBtn" class="btn btn-primary">Import</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="">
                                        <form action="{{ route('admin.profile.export') }}" method="POST"
                                            class="float-inline-end">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Export Excel
                                            </button>
                                        </form>
                                    </div>


                                    <div class="col-lg-3 main-option mtop-28">
                                        <label for="column-select">Chọn cột để hiển thị:</label>
                                        <div class="selectBox form-select" id="toggleBtn">

                                            <option>Chọn cột</option>

                                            <div class="overSelect"></div>
                                        </div>
                                        <div class="checkboxes" id="checkboxes">
                                            <form id="applyForm" action="{{ route('column') }}" method="post">
                                                <input type="hidden" id="selectedValuesInput" name="selectedValues">
                                                @csrf
                                                @if ($fillableFields)
                                                    @forelse ($fillableFields as $key => $value)
                                                        @if ($value !== 'config_id' && $value !== 'ma_muc_luc')
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
                            </div>
                        </div>
                        <div class="card-body">
                            @include('globals.alert')
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">

                                    <!-- Bảng dữ liệu -->
                                    <table id="userTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                @if ($profiles && $profiles->first())
                                                    @forelse ($profiles->first()->getAttributes() as $key => $value)
                                                        @if (
                                                            $key !== 'updated_at' &&
                                                                $key !== 'created_at' &&
                                                                $key !== 'id' &&
                                                                $key !== 'config_id' &&
                                                                $key !== 'ma_muc_luc' &&
                                                                $key !== 'ma_phong'
                                                                &&  $key !== 'ngay_ket_thuc')

                                                            <th class="column-{{ $key }}"> {{ $columnComments[$key] ?? $key }}</th>
                                                               

                                                        @endif
                                                    @empty
                                                        <option value="">Không có dữ liệu</option>
                                                    @endforelse
                                                    <th class="">Thao tác</th>
                                                @else
                                                    <option value="">Không có dữ liệu</option>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($profiles && $profiles->first())
                                                @forelse ($profiles as $user)
                                                    <tr>
                                                        @foreach ($user->getAttributes() as $key => $value)
                                                            @if (
                                                                $key !== 'updated_at' &&
                                                                    $key !== 'created_at' &&
                                                                    $key !== 'id' &&
                                                                    $key !== 'config_id' &&
                                                                    $key !== 'ma_muc_luc' &&
                                                                    $key !== 'ma_phong' &&  $key !== 'ngay_ket_thuc')
                                                                <td class="column-{{ $key }}">

                                                                    @if ($key == 'hop_so')
                                                                        {{ $user->hopso->hop_so ?? '' }}
                                                                    @else
                                                                         @if($key == 'ngay_bat_dau')
                                                                            {{ $value }} - {{$user->ngay_ket_thuc}}
                                                                        @else 
                                                                            {{ $value }} 
                                                                        @endif
                                                                    @endif

                                                                </td>
                                                                {{-- @if ($key == 'hop_so')
                                                                <td class="column-{{ $key }}">
                                                                    {{ $user->hopso->hop_so }}

                                                                </td>
                                                                @endif --}}
                                                            @endif
                                                        @endforeach
                                                        <td class="d-flex gap-1 justify-content-center">
                                                            @if (auth('admin')->user()->level === 2)
                                                                <a href="{{ route('admin.profile.edit', ['id' => $user->id]) }}"
                                                                    class="btn btn-warning main-action">
                                                                    <img src="{{ asset('svg/detail.svg') }}"
                                                                        alt="SVG Image">
                                                                </a>
                                                                <form method="post"
                                                                    action="{{ route('admin.profile.delete.hoso', ['id' => $user->id]) }}"
                                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <img src="{{ asset('svg/delete.svg') }}"
                                                                            alt="SVG Image">
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('admin.profile.detail', ['id' => $user->id]) }}"
                                                                class="btn btn-primary  main-action">
                                                                <img src="{{ asset('svg/edit.svg') }}" alt="SVG Image">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <p>không có dữ liệu</p> --}}
                                                @endforelse
                                            @else
                                                <option value="">Không có dữ liệu</option>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                                {{ $profiles->links() }}
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>



@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function getUrlParams(url) {
            var params = {};
            var urlParts = url.split("?");

            if (urlParts.length > 1) {
                var queryString = urlParts[1];
                var paramArray = queryString.split("&");

                paramArray.forEach(function(param) {
                    var keyValue = param.split("=");
                    params[keyValue[0]] = keyValue[1];
                });
            }

            return params;
        }
        var currentUrl = window.location.href;


        var params = getUrlParams(currentUrl);

        var phong = document.getElementById('phong');
        var muc_luc = document.getElementById('muc_luc');
        var hop_so = document.getElementById('hop_so');

        if (params && Object.keys(params).length > 0) {


            if (params.coquan !== "") {
                phong.disabled = false;
                muc_luc.disabled = false;
                hop_so.disabled = false;
            }else{
                console.log('rỗng');

            }
        }


        function sendAjaxRequest(selectedValues) {
            var url = "{{ route('admin.profile.searchHopSo') }}";

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

                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Chọn Hộp Số';
                selectElement.add(defaultOption);

                Object.keys(data).forEach(function(key) {
                    var option = document.createElement('option');
                    option.value = data[key];
                    option.text = key;
                    if (data[key] == params.hop_so) {
                        option.selected = true;
                    }
                    selectElement.add(option);
                });


                selectElement.disabled = false;
            }
        }

        function getSelectedValues() {
            var selectedCoQuan = $('#coquan').val();
            var selectedPhong = $('#phong').val();
            var selectedMucLuc = $('#muc_luc').val();
            return {
                coquan: selectedCoQuan,
                phong: selectedPhong,
                mucluc: selectedMucLuc,
            };
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
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'Chọn Phông';
                        selectElement.add(defaultOption);
                        Object.keys(data).forEach(function(key) {
                            var option = document.createElement('option');
                            option.value = data[key];
                            option.text = key;
                            if (data[key] == params.phong) {
                                option.selected = true;
                            }
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

                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'Chọn Mục Lục';
                        selectElement.add(defaultOption);

                        Object.keys(data).forEach(function(key) {
                            var option = document.createElement('option');
                            option.value = data[key];
                            option.text = key;
                            if (data[key] == params.muc_luc) {
                                option.selected = true;
                            }
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
            if(selectedCoQuan === ""){
                var selectElement = document.getElementById('muc_luc');
                selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Chọn Mục Lục';
                selectElement.add(defaultOption);
                selectElement.disabled = true;

                var selectElement1 = document.getElementById('phong');
                selectElement1.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Chọn phông';
                selectElement1.add(defaultOption);
                selectElement1.disabled = true;

                var selectElement2 = document.getElementById('hop_so');
                selectElement2.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Chọn Hộp số';
                selectElement2.add(defaultOption);
                selectElement2.disabled = true;
            }else{
                searchPhong(selectedCoQuan);
            }


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
        // Lấy file từ input có sẵn
        var selectedFile = $('#importFile')[0].files[0];

        // Kiểm tra nếu người dùng đã chọn file
        if (selectedFile) {
            var formData = new FormData();
            formData.append('file', selectedFile);

            // Lấy URL từ route Laravel
            var url = "{{ route('import') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Kết quả:', response);
                    // Xử lý logic thành công ở đây
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Đã xảy ra lỗi khi gửi file.');
                }
            });
        } else {
            alert("Vui lòng chọn một file trước khi import.");
        }
    });
});

</script>
<style scoped>
    .h-190{
        height: 190px;
    }
    .hoso__position {
        position: relative;
        left: 313px;
        bottom: 52px;
    }

    .float-inline-end {
        float: inline-end;
    }

    .mtop-28 {
        margin-top: -28px !important;
    }

    .selectBox,
    .checkboxes {
        width: 300px !important;
    }
    td,th {
    text-align: center !important;
    vertical-align: middle;
}
    @media(max-width:768px) {
        .hoso__position {
            position: unset !important;
        }
        .h-190{
            height: auto;
        }
        .float-inline-end {
            float: unset;
        }

        .mtop-28 {
            margin-top: 3px !important;
        }
    }
</style>
