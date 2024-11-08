
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
                                <form action="{{ route('admin.column.updateColumn',['column'=>$profiles['name']]) }}" method="post" class="">
                                    @csrf
                                    <div class="form-group mt-3 ">
                                        <label for="column_name">Tên Cột</label>
                                        <input type="text" class="form-control" id="column_name" name="column_name" value="{{old('column_name') ?? $profiles['comment']}}" placeholder="Ví dụ: Mô Tả (mo_ta)" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="column_type">Kiểu Dữ Liệu</label>
                                        <select class="form-control" id="column_type" name="column_type" required>
                                            <option value="string" {{ $profiles['type'] === "varchar(255)" ? "selected" : "" }}>Chuỗi (string)</option>
                                            <option value="integer" {{ $profiles['type'] === "int" ? "selected" : "" }}>Số Nguyên (integer)</option>
                                            <option value="text" {{ $profiles['type'] === "text" ? "selected" : "" }}>Văn Bản (text)</option>
                                            <!-- Thêm các kiểu dữ liệu khác nếu cần -->
                                        </select>
                                    </div>
                                    <div class=" form-group mt-3">
                                        <label for="is_required" class="form-label">Yêu cầu bắt buộc</label>
                                        <select name="is_required" id="is_required" class="form-select">
                                            <option value="1" {{$profiles['nullable'] === true ? "selected" : ""}}>Có</option>
                                            <option value="0" {{$profiles['nullable'] !== true ? "" : "selected"}}>Không</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary mt-2 mb-2">Cập nhật</button>
                                    </div>
                                </form>
                        </div>
                        <div class="container mt-5">
                            @include('admins/pages/custom/table', ['title' => $title, 'columnDataPaginated' => $columnDataPaginated, 'comment' => $comment])
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
    <style scoped>
        .css__column{
            padding: 9px;
            width: 40px;
        }
    </style>
@endsection
