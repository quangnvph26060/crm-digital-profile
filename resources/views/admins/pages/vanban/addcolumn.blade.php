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

                            <button type="submit" class="btn btn-primary">Thêm cột</button>
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

        <div class="container mt-5">
            <h1>Danh sách cột trong bảng</h1>
            <div class="row mt-3">
                @foreach($columnData as $column)
                <div class="col-md-2 mb-3">
                    <div class="column-box">
                        <div style="display: flex; justify-content: startss">
                            <p>{{ $column['name'] }}</p>
                            <span class="">( {{ $column['type'] }} )</span>
                        </div>
                        <div>
                            {{-- <a href="" class="btn btn-warning btn-sm" style="margin-right: 10px">Sửa</a> --}}
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
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>



@endsection
