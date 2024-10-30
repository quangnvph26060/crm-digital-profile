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

        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    @include('globals.alert')
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">


                            @extends('admins.layouts.index')
                            @section('title', $title)
                            @section('content')
                            <div class="page-content">
                                <div class="container-fluid">

                                    <!-- start page title -->
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between mt-3 mb-3">
                                            <div
                                                class="page-title-box d-sm-flex align-items-center justify-content-between">
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

                                    <div class="">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @include('globals.alert')
                                            </div>
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">

                                                        <form action="{{ route('admin.vanban.addcolumn') }}" method="POST" class="container mt-4">
                                                            @csrf

                                                            <div class="mb-3">
                                                                <label for="column_name" class="form-label">Tên cột:</label>
                                                                <input type="text" class="form-control" name="column_name" id="column_name" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="data_type" class="form-label">Kiểu dữ liệu:</label>
                                                                <select name="data_type" id="data_type" class="form-select" required>
                                                                    <option value="">Chọn kiểu dữ liệu</option>
                                                                    <option value="varchar">VARCHAR(255)</option>
                                                                    <option value="int">INT</option>
                                                                    <option value="text">TEXT</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="is_required" class="form-label">Yêu cầu bắt buộc:</label>
                                                                <select name="is_required" id="is_required" class="form-select">
                                                                    <option value="1">Có</option>
                                                                    <option value="0" selected>Không</option>
                                                                </select>
                                                            </div>


                                                            <button type="submit" class="btn btn-primary">Thêm cột</button>
                                                        </form>

                                                    </div>
                                                    <div class="container mt-5">
                                                        <h1>{{ $title }}</h1>
                                                        <table class="table table-bordered mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th>STT</th>
                                                                    <th>Tên cột</th>
                                                                    <th>Kiểu dữ liệu</th>
                                                                    <th>Ghi chú</th>
                                                                    <th>Trạng thái yêu cầu</th>
                                                                    <th>Hành động</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($columnDataPaginated as $index => $column)
                                                                <tr>
                                                                    <td>{{ $index + 1 +
                                                                        ($columnDataPaginated->currentPage() - 1) *
                                                                        $columnDataPaginated->perPage() }}</td>
                                                                    <td>{{ $column['name'] }}</td>
                                                                    <td>{{ $column['type'] }}</td>
                                                                    <td>{{ $column['comment'] }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $column['is_required'] === 'Có' ? 'bg-danger' : 'bg-success' }}">
                                                                            {{ $column['is_required'] === 'Có' ? 'Bắt
                                                                            buộc' : 'Không bắt buộc' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <form
                                                                            action="{{ route('admin.column.deleteColumn', $column['name']) }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm">Xóa</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        <!-- Phân trang -->
                                                        <div class="mt-3">
                                                            {{ $columnDataPaginated->links() }}
                                                        </div>
                                                    </div>



                                                </div>
                                                <!-- end card -->
                                            </div> <!-- end col -->
                                        </div>
                                    </div>

                                </div> <!-- container-fluid -->
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
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

                            @endsection

                        </div>
                        <div class="container mt-5">
                            <h1>{{ $title }}</h1>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên cột</th>
                                        <th>Kiểu dữ liệu</th>
                                        <th>Ghi chú</th>
                                        <th>Trạng thái yêu cầu</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($columnDataPaginated as $index => $column)
                                    <tr>
                                        <td>{{ $index + 1 + ($columnDataPaginated->currentPage() - 1) *
                                            $columnDataPaginated->perPage() }}</td>
                                        <td>{{ $column['name'] }}</td>
                                        <td>{{ $column['type'] }}</td>
                                        <td>{{ $column['comment'] }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $column['is_required'] === 'Có' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $column['is_required'] === 'Có' ? 'Bắt buộc' : 'Không bắt buộc' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.vanban.delete.column', $column['name']) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Phân trang -->
                            <div class="mt-3">
                                {{ $columnDataPaginated->links() }}
                            </div>
                        </div>



                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

@endsection
