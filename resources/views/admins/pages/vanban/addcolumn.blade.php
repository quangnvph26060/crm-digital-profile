@extends('admins.layouts.index')
@section('title', $title)
@section('content')
<style>
    .cke_notifications_area {
        display: none;
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                @include('globals.alert')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin trường văn bản</h4>
                    </div>

                    <div class="card-body p-4">
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
                </div>
            </div> <!-- end col -->
        </div>

        {{-- <div class="container mt-5">
            <h1>Danh sách cột trong bảng</h1>
            <div class="row mt-3">
                @foreach($columnData as $column)
                <div class="col-md-2 mb-3">
                    <div class="column-box">
                        <div>
                            {{ $column['comment'] }} <br>
                        </div>
                        <div style="display: flex; justify-content: starts">

                            <p style="margin: 0px">{{ $column['name'] }}</p>
                            <span class="">( {{ $column['type'] }} )</span>
                        </div>
                        <div>

                            <form action="{{ route('admin.vanban.delete.column', $column['name']) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
                @if(($loop->index + 1) % 6 == 0)
            </div>
            <div class="row mt-3">
                @endif
                @endforeach
            </div>
        </div> --}}
        <div class="container mt-5">
            <h3>Danh sách các trường thông tin</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên trường</th>
                        <th>Ký hiệu</th>
                        <th>Kiểu dữ liệu</th>

                        <th>Yêu cầu bắt buộc</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($columnDataPaginated as $index => $column)
                        @if($column['name'] == 'created_at' || $column['name'] == 'updated_at' || $column['name'] == 'id')
                            @continue
                        @endif

                        <tr>
                            <td>{{ $index  + ($columnDataPaginated->currentPage() - 1) * $columnDataPaginated->perPage() }}</td>
                            <td>{{ htmlspecialchars($column['comment'], ENT_QUOTES, 'UTF-8') }}</td>
                            <td>{{ $column['name'] }}</td>
                            <td>{{ $column['type'] }}</td>
                            <td>
                                <span class="badge {{ $column['is_required'] === 'Có' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $column['is_required'] === 'Có' ? 'Bắt buộc' : 'Không bắt buộc' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.vanban.delete.column', $column['name']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Hiển thị các liên kết phân trang -->
            <div class="mt-3">
                {{ $columnDataPaginated->links() }} <!-- Sử dụng phương thức links() để hiển thị các liên kết phân trang -->
            </div>
        </div>


        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>



@endsection
