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
                                <form action="{{ route('admin.vanban.updateColumn',['column'=> $information_vb['name']]) }}"
                                method="POST" class="container mt-4">
                                @csrf

                                <div class="mb-3">
                                    <label for="column_name" class="form-label">Tên
                                        cột:</label>
                                    <input type="text" class="form-control"
                                        name="column_name" id="column_name" placeholder="Ví dụ: Mô tả (mo_ta)" required value="{{old('column_name') ?? $information_vb['comment']}}">
                                </div>

                                <div class="mb-3">
                                    <label for="data_type" class="form-label">Kiểu dữ
                                        liệu:</label>
                                    <select name="data_type" id="data_type"
                                        class="form-select" required>
                                        <option value="string" {{ $information_vb['type'] === "varchar(255)" ? "selected" : "" }}>Chuỗi (string)</option>
                                        <option value="integer" {{ $information_vb['type'] === "int" ? "selected" : "" }}>Số Nguyên (integer)</option>
                                        <option value="text" {{ $information_vb['type'] === "text" ? "selected" : "" }}>Văn Bản (text)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="is_required" class="form-label">Yêu cầu bắt
                                        buộc:</label>
                                    <select name="is_required" id="is_required"
                                        class="form-select">
                                        <option value="1" {{$information_vb['nullable'] === true ? "selected" : ""}}>Có</option>
                                        <option value="0" {{$information_vb['nullable'] !== true ? "" : "selected"}}>Không</option>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                        
                        </div>
                        <div class="container mt-5">
                            @include('admins/pages/vanban/tablecolumn', ['title' => $title, 'columnDataPaginated' => $columnDataPaginated, 'comment' => $comment])
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
