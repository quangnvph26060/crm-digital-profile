@extends('admins.layouts.index')

@section('content')
    <!-- Thêm CSS để căn giữa modal -->
    <style>
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
    </style>

    <div class="page-content" id="content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Danh sách khách hàng</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Tìm kiếm</label>
                                        <input value="{{ request('query') }}" autocomplete="off" name="query"
                                            placeholder="Nhập từ khóa tìm kiếm" type="text" class="form-control"
                                            id="search-query">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="button" id="search-btn" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tìm kiếm
                                        </button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger">
                                            <i class="fas fa-history"></i> Tải lại
                                        </a>
                                        <button type="button" class="btn btn-success" id="open-add-modal">
                                            <i class="fas fa-plus"></i> Thêm mới
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('globals.alert')
                            <div id="alert-container"></div>
                            <div id="table-content">
                                @include('admins.pages.client.table', ['clients' => $clients])
                            </div>
                            <div id="pagination-links">
                                {{ $clients->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Thêm khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-client-form">
                        @csrf
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div id="name-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div id="email-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <div id="phone-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            <div id="address-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="field" class="form-label">Ngành nghề</label>
                            <input type="text" class="form-control" id="field" name="field">
                            <div id="field-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Tên công ty </label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                            <div id="company_name-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tax_number" class="form-label">Mã số thuế </label>
                            <input type="text" class="form-control" id="tax_number" name="tax_number">
                            <div id="tax_number-error" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Client Modal -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Sửa thông tin khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-client-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-client-id" name="id">
                        <!-- Form fields (similar to add form but with IDs prefixed with 'edit-') -->
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                            <div id="edit-name-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                            <div id="edit-email-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-phone" name="phone" required>
                            <div id="edit-phone-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Địa chỉ <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-address" name="address" required>
                            <div id="edit-address-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-field" class="form-label">Ngành nghề</label>
                            <input type="text" class="form-control" id="edit-field" name="field">
                            <div id="edit-field-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-company_name" class="form-label">Tên công ty</label>
                            <input type="text" class="form-control" id="edit-company_name" name="company_name">
                            <div id="edit-company_name-error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-tax_number" class="form-label">Mã số thuế</label>
                            <input type="text" class="form-control" id="edit-tax_number" name="tax_number">
                            <div id="edit-tax_number-error" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Thông tin khách hàng</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Tên:</strong> <span id="client-name"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="client-phone"></span></p>
                    <p><strong>Tên công ty:</strong> <span id="client-company"></span></p>
                    <p><strong>Ngành nghề:</strong> <span id="client-field"></span></p>
                    <p><strong>Email:</strong> <span id="client-email"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="client-address"></span></p>
                    <p><strong>Mã số thuế:</strong> <span id="client-tax-number"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Thêm khách hàng mới
            $('#add-client-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.client.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response); // Xem dữ liệu trả về
                        if (response.success) {
                            $('#addClientModal').modal('hide');
                            toastr.success(response.success, 'Thành công');
                            $('#table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                        } else if (response.error) {
                            toastr.error(response.error, 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $('#' + field + '-error').text(errors[field][0]).show();
                        }
                    }
                });
            });

            $('#edit-client-form').on('submit', function(e) {
                e.preventDefault();
                let clientId = $('#edit-client-id').val();
                let url = "{{ route('admin.client.update', ':id') }}";
                url = url.replace(':id', clientId);

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response); // Kiểm tra dữ liệu trả về
                        if (response.success) {
                            $('#editClientModal').modal('hide');
                            toastr.success(response.success, 'Thành công');
                            $('#table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                        } else if (response.error) {
                            toastr.error(response.error, 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $('#edit-' + field + '-error').text(errors[field][0]);
                        }
                    }
                });
            });


            // Tìm kiếm khách hàng
            $('#search-btn').on('click', function() {
                updateTableAndPagination();
            });

            $('#search-query').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    updateTableAndPagination();
                }
            });

            // Xóa khách hàng
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let url = $(this).data('url');
                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            toastr.success('Khách hàng đã được xóa thành công!', 'Thành công');
                            updateTableAndPagination();
                        },
                        error: function(xhr) {
                            toastr.error('Xóa khách hàng thất bại', 'Lỗi');
                        }
                    });
                }
            });

            // Hiển thị modal sửa thông tin khách hàng
            $(document).on('click', '.open-edit-modal', function() {
                let clientId = $(this).data('id');
                let url = "{{ route('admin.client.edit', ':id') }}";
                url = url.replace(':id', clientId);

                $.get(url, function(data) {
                    $('#edit-client-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-email').val(data.email);
                    $('#edit-phone').val(data.phone);
                    $('#edit-address').val(data.address);
                    $('#edit-field').val(data.field);
                    $('#edit-company_name').val(data.company_name);
                    $('#edit-tax_number').val(data.tax_number);
                    $('#editClientModal').modal('show');
                });
            });

            // Hiển thị modal thêm khách hàng
            $('#open-add-modal').on('click', function() {
                $('#add-client-form')[0].reset();
                $('.invalid-feedback').hide();
                $('#addClientModal').modal('show');
            });

            // Cập nhật bảng khách hàng và phân trang
            function updateTableAndPagination() {
                let query = $('#search-query').val();
                $.ajax({
                    url: "{{ route('admin.client.search') }}",
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $('#table-content').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Xử lý sự kiện click vào liên kết phân trang
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let query = $('#search-query').val();
                let newUrl = url + (url.includes('?') ? '&' : '?') + 'query=' + encodeURIComponent(query);
                $.ajax({
                    url: newUrl,
                    type: 'GET',
                    success: function(response) {
                        $('#table-content').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
            // Xử lý sự kiện khi nhấp vào tên khách hàng
            document.addEventListener('click', function(e) {
                if (e.target.matches('.client-name')) {
                    e.preventDefault();
                    const clientId = e.target.dataset.id;

                    fetch(`/admin/receipt/client/${clientId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('client-name').textContent = data.name || '';
                            document.getElementById('client-phone').textContent = data.phone || '';
                            document.getElementById('client-company').textContent = data.company_name ||
                                'Chưa có công ty';
                            document.getElementById('client-field').textContent = data.field ||
                                'Chưa có ngành nghề';
                            document.getElementById('client-email').textContent = data.email ||
                                'Chưa có email';
                            document.getElementById('client-address').textContent = data.address ||
                                '';
                            document.getElementById('client-tax-number').textContent = data
                                .tax_number || 'Chưa có mã số thuế';

                            $('#clientModal').modal('show');
                        });
                }
            });
        });
    </script>
@endsection
