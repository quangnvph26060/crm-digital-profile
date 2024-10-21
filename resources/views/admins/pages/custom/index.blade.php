
@extends('admins.layouts.index')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3 mb-3">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        {{-- <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4> --}}
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
                          
                                <h2>Thêm Cột Mới</h2>
                                <form action="{{ route('admin.column.store') }}" method="post" class="">
                                    @csrf
                                    <div class="form-group col-lg-5">
                                        <label for="column_name">Tên Cột</label>
                                        <input type="text" class="form-control" id="column_name" name="column_name" placeholder="Ví dụ: Mô Tả" required>
                                    </div>
                                    <div class="form-group col-lg-5">
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
                        <div class="card-body">
                            @include('globals.alert')
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                {{-- <th>Mã Cơ quan</th>
                                                <th>Mã Phông</th>
                                                <th>Mã mục lục</th> --}}


                                                <th>Tên cột</th>
                                                @if (auth('admin')->user()->level === 2)
                                                    <th>Hành động</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($columns as $key => $item)
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>

                                                
                                                    <td>
                                                        {{ $item }}
                                                    </td>


                                                    <td class="d-flex gap-1">
                                                        @if (auth('admin')->user()->level === 2)
                                                            <form method="post"
                                                                action="{{ route('admin.column.delete', $item) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                                            </form>
                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

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
