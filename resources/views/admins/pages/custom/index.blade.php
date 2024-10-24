
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

          <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                          
                                <form action="{{ route('admin.column.store') }}" method="post" class="">
                                    @csrf
                                    <div class="form-group ">
                                        <label for="column_name">Tên Cột</label>
                                        <input type="text" class="form-control" id="column_name" name="column_name" placeholder="Ví dụ: Mô Tả (mo_ta)" required>
                                    </div>
                                    <div class="form-group ">
                                        <label for="column_type">Kiểu Dữ Liệu</label>
                                        <select class="form-control" id="column_type" name="column_type" required>
                                            <option value="string">Chuỗi (string)</option>
                                            <option value="integer">Số Nguyên (integer)</option>
                                            <option value="text">Văn Bản (text)</option>
                                            <!-- Thêm các kiểu dữ liệu khác nếu cần -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mt-2 mb-2">Thêm Cột</button>
                                    </div>
                                </form>
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
                                            <form action="{{ route('admin.column.deleteColumn', $column['name']) }}" method="POST"
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
