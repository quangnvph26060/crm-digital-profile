@extends('admins.layouts.index')
@section('title', $title)
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
                    <div class="card-header">
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
                                            <option value="{{ $item->id }}" {{ isset($inputs['coquan']) ?
                                                ($inputs['coquan']==$item->id ? 'selected' : '') : '' }}>
                                                {{ $item->agency_name }}</option>
                                            @endforeach
                                            <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Phông</label>
                                        <select class="form-select" name="phong" id="phong">
                                            <option value="">Chọn Phông</option>
                                            @foreach ($phongdata as $item)
                                            <option value="{{ $item->id }}" {{ isset($inputs['phong']) ?
                                                ($inputs['phong']==$item->id ? 'selected' : '') : '' }}>
                                                {{ $item->ten_phong }}</option>
                                            @endforeach
                                            <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Mục lục</label>
                                        <select class="form-select" name="muc_luc" id="muc_luc">
                                            <option value="">Chọn mục lục</option>
                                            @foreach ($muclucdata as $item)
                                            <option value="{{ $item->id }}" {{ isset($inputs['muc_luc']) ?
                                                ($inputs['muc_luc']==$item->id ? 'selected' : '') : '' }}>
                                                {{ $item->ten_mucluc }}</option>
                                            @endforeach
                                            <!-- Thêm các tùy chọn mục lục khác nếu cần -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
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
                        <div class="col-lg-6 mt-2">
                            <div class="row">
                                <div class="col-lg-2">

                                    <form action="{{ route('admin.profile.export') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus"></i> Import Excel
                                        </button>
                                    </form>
                                </div>
                                @if (auth('admin')->user()->level === 2)
                                <div class="col-lg-2">
                                    <button class="btn btn-success" id="exportExcelBtn">
                                        <input type="file" style="display: none">
                                        <i class="fas fa-plus"></i> Export Excel
                                    </button>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('globals.alert')
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                {{-- <table id="" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>

                                            <th>Hộp số</th>
                                            <th>Hồ sơ số</th>
                                            <th>Tiêu đề hồ sơ</th>
                                            <th>Ngày tháng BĐ-KT</th>
                                            <th>Số tờ</th>
                                            <th>THBQ</th>
                                            <th>Ghi chú</th>
                                            @if (auth('admin')->user()->level === 2)
                                            <th>Hành động</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profiles as $key => $item)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>


                                            <td>
                                                {{ $item->hop_so }}
                                            </td>
                                            <td>
                                                {{ $item->ho_so_so }}
                                            </td>
                                            <td>
                                                {{ $item->tieu_de_ho_so }}
                                            </td>
                                            <td>
                                                {{ $item->ngay_bat_dau }} - {{ $item->ngay_ket_thuc }}
                                            </td>
                                            <td>
                                                {{ $item->so_to }}
                                            </td>
                                            <td>
                                                {{ $item->thbq }}
                                            </td>
                                            <td>
                                                {{ $item->ghi_chu }}
                                            </td>

                                            <td class="d-flex gap-1">
                                                @if (auth('admin')->user()->level === 2)
                                                <a href="{{ route('admin.profile.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24">
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 21h16M5.666 13.187A2.278 2.278 0 0 0 5 14.797V18h3.223c.604 0 1.183-.24 1.61-.668l9.5-9.505a2.278 2.278 0 0 0 0-3.22l-.938-.94a2.277 2.277 0 0 0-3.222.001l-9.507 9.52Z" />
                                                    </svg>
                                                </a>
                                                <form method="post"
                                                    action="{{ route('admin.profile.delete.hoso', ['id' => $item->id]) }}"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 26 26">
                                                            <path fill="currentColor"
                                                                d="M11.5-.031c-1.958 0-3.531 1.627-3.531 3.594V4H4c-.551 0-1 .449-1 1v1H2v2h2v15c0 1.645 1.355 3 3 3h12c1.645 0 3-1.355 3-3V8h2V6h-1V5c0-.551-.449-1-1-1h-3.969v-.438c0-1.966-1.573-3.593-3.531-3.593h-3zm0 2.062h3c.804 0 1.469.656 1.469 1.531V4H10.03v-.438c0-.875.665-1.53 1.469-1.53zM6 8h5.125c.124.013.247.031.375.031h3c.128 0 .25-.018.375-.031H20v15c0 .563-.437 1-1 1H7c-.563 0-1-.437-1-1V8zm2 2v12h2V10H8zm4 0v12h2V10h-2zm4 0v12h2V10h-2z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                                <a href="{{ route('admin.profile.detail', ['id' => $item->id]) }}"
                                                    class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 16 16">
                                                        <path fill="currentColor" fill-rule="evenodd"
                                                            d="M0 4.13v1.428a.5.5 0 0 0 .725.446l.886-.446l.377-.19L2 5.362l1.404-.708l.07-.036l.662-.333l.603-.304a.5.5 0 0 0 0-.893l-.603-.305l-.662-.333l-.07-.036L2 1.706l-.012-.005l-.377-.19l-.886-.447A.5.5 0 0 0 0 1.51v2.62ZM7.25 2a.75.75 0 0 0 0 1.5h7a.25.25 0 0 1 .25.25v8.5a.25.25 0 0 1-.25.25h-9.5a.25.25 0 0 1-.25-.25V6.754a.75.75 0 0 0-1.5 0v5.496c0 .966.784 1.75 1.75 1.75h9.5A1.75 1.75 0 0 0 16 12.25v-8.5A1.75 1.75 0 0 0 14.25 2h-7Zm-.5 4a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5ZM6 9.25a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5A.75.75 0 0 1 6 9.25Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table> --}}
                                <div class="main-option">
                                    <label for="column-select">Chọn cột để hiển thị:</label>
                                    <select name="column-select" id="column-select" multiple class="form-control">
                                        @if ($profiles && $profiles->first())
                                        @forelse ($profiles->first()->getAttributes() as $key => $value)
                                        @if ($key !== 'updated_at' && $key !== 'created_at' && $key !== 'id' && $key !==
                                        'config_id' && $key !== 'ma_muc_luc')
                                        <option value="{{ $key }}">{{ $key }}</option>
                                        @endif
                                        @empty
                                        <option value="">Không có dữ liệu</option>
                                        @endforelse
                                        @else
                                        <option value="">Không có dữ liệu</option>
                                        @endif
                                    </select>
                                </div>
                                <!-- Bảng dữ liệu -->
                                <table id="userTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            @if ($profiles && $profiles->first())
                                            @forelse ($profiles->first()->getAttributes() as $key => $value)
                                            @if ($key !== 'updated_at' && $key !== 'created_at' && $key !== 'id' && $key
                                            !== 'config_id' && $key !== 'ma_muc_luc')
                                            <th class="column-{{ $key }}">{{ $key }}
                                            </th>
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
                                            @if ($key !== 'updated_at' && $key !== 'created_at' && $key !== 'id' && $key
                                            !== 'config_id' && $key !== 'ma_muc_luc')
                                            <td class="column-{{ $key }}">{{ $value }}
                                            </td>
                                            @endif
                                            @endforeach
                                            <td class="d-flex gap-1">
                                                @if (auth('admin')->user()->level === 2)
                                                <a href="{{ route('admin.profile.edit', ['id' => $user->id]) }}"
                                                    class="btn btn-warning">
                                                    <img src="{{ asset('svg/detail.svg') }}" alt="SVG Image">
                                                </a>
                                                <form method="post"
                                                    action="{{ route('admin.profile.delete.hoso', ['id' => $user->id]) }}"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">
                                                    </button>
                                                </form>
                                                @endif
                                                <a href="{{ route('admin.profile.detail', ['id' => $user->id]) }}"
                                                    class="btn btn-primary">
                                                    <img src="{{ asset('svg/edit.svg') }}" alt="SVG Image">
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <p>không có dữ liệu</p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
<style scoped>
    .hidden {
        display: none;
    }

    /* Style cho checkbox */
    input[type="checkbox"] {
        display: none;
    }

    /* CSS cho dropdown chọn cột */
    .select-wrapper {
        position: relative;
        display: inline-block;
        width: 200px;
    }

    .select-wrapper select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        color: #333;
        cursor: pointer;
    }

    .select-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 5px 5px;
        background-color: #fff;
    }

    .select-options.open {
        display: block;
    }

    .select-options option {
        padding: 10px;
        cursor: pointer;
    }

    .select-options option:hover {
        background-color: #e9e9e9;
    }

    .select-options option:checked {
        background-color: #a8dadc;
        color: white;
    }

    /* Style cho label của checkbox */
    .checkbox-label {
        display: inline-block;
        cursor: pointer;
        padding: 5px 10px;
        margin-right: 10px;
        background-color: #f4f4f4;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Style khi checkbox được chọn */
    input[type="checkbox"]:checked+.checkbox-label {
        background-color: #3498db;
        color: white;
    }

    .main-option {
        flex-direction: column;
        display: flex;
    }
</style>
@endsection
