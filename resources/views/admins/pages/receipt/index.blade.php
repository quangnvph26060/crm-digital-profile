@extends('admins.layouts.index')

@section('content')
    <style>
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
            /* Adjust if necessary */
        }

        /* Căn giữa các phần tử trong form-group */
        .form-group {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Tạo khoảng cách đều giữa các phần tử */
            flex-wrap: wrap;
            /* Đảm bảo các phần tử tự động xuống dòng nếu không đủ không gian */
        }

        /* Tùy chỉnh kích thước ô tìm kiếm */
        .search-input,
        #start-date,
        #end-date {
            max-width: 250px;
            /* Đặt kích thước tối đa cho các input */
            width: 100%;
            /* Đảm bảo input chiếm hết chiều rộng có sẵn */
            padding: 5px 10px;
            /* Tạo khoảng đệm cho nội dung */
            border-radius: 5px;
            /* Bo góc mềm mại */
            border: 1px solid #ced4da;
            /* Đặt viền cho input */
        }

        /* Tùy chỉnh button tìm kiếm và các button khác */
        .form-group .btn {
            padding: 7px 15px;
            /* Tạo kích thước vừa phải cho button */
            border-radius: 5px;
            /* Bo góc mềm mại cho button */
        }

        /* Tùy chỉnh khoảng cách giữa các nút */
        .form-group .btn+.btn {
            margin-left: 0;
            /* Loại bỏ margin cũ */
        }

        /* Tạo giao diện tương thích với các thiết bị di động */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                /* Chuyển thành cột trên màn hình nhỏ */
                align-items: stretch;
                /* Đảm bảo các phần tử full width */
            }

            .form-group .btn {
                width: 100%;
                /* Đảm bảo nút full width trên màn hình nhỏ */
            }

            .search-input,
            #start-date,
            #end-date {
                max-width: 100%;
                /* Full width cho các input trên màn hình nhỏ */
            }
        }
    </style>

    <div class="page-content" id="content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Danh sách phiếu thu</h4>
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
                                    <div class="form-group d-flex align-items-end">
                                        <input value="{{ request('query') }}" autocomplete="off" name="query"
                                            placeholder="Nhập từ khóa tìm kiếm" type="text"
                                            class="form-control search-input" id="search-query">
                                        <input value="{{ request('start_date') }}" autocomplete="off" name="start_date"
                                            placeholder="Ngày bắt đầu" type="date" class="form-control ml-2"
                                            id="start-date">
                                        <input value="{{ request('end_date') }}" autocomplete="off" name="end_date"
                                            placeholder="Ngày kết thúc" type="date" class="form-control ml-2"
                                            id="end-date">
                                        <button type="button" id="search-btn" class="btn btn-primary ml-2">
                                            <i class="fas fa-search"></i> Tìm kiếm
                                        </button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger ml-2">
                                            <i class="fas fa-history"></i> Tải lại
                                        </a>
                                        <a class="btn btn-success ml-2" href="{{ route('admin.receipt.add') }}">
                                            <i class="fas fa-plus"></i> Thêm mới
                                        </a>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="show-today-receipts">
                                        <label class="form-check-label" for="show-today-receipts">Hiển thị phiếu chi của
                                            ngày hôm nay</label>
                                    </div>
                                </div> --}}
                            </div>

                        </div>
                        <div class="card-body">
                            @include('globals.alert')
                            <div id="alert-container"></div>
                            <div id="table-content">
                                @include('admins.pages.receipt.table', [
                                    'receipts' => $receipts,
                                    'totalAmount' => $totalAmount,
                                ])
                            </div>
                            <div id="pagination-links">
                                {{ $receipts->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <!-- Modal -->
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
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Cập nhật bảng và phân trang dựa trên tham số tìm kiếm.
            function updateTableAndPagination(query, startDate, endDate, showToday) {
                $.ajax({
                    url: "{{ route('admin.receipt.search') }}",
                    type: 'GET',
                    data: {
                        query: query,
                        start_date: startDate,
                        end_date: endDate,
                        show_today: showToday
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

            // Sự kiện thay đổi trạng thái checkbox.
            $('#show-today-receipts').on('change', function() {
                let query = $('#search-query').val();
                let startDate = $('#start-date').val();
                let endDate = $('#end-date').val();
                let showToday = $(this).is(':checked');
                updateTableAndPagination(query, startDate, endDate, showToday);
            });

            // Sự kiện nhấp vào nút tìm kiếm.
            $('#search-btn').on('click', function() {
                let query = $('#search-query').val();
                let startDate = $('#start-date').val();
                let endDate = $('#end-date').val();
                let showToday = $('#show-today-receipts').is(':checked');
                updateTableAndPagination(query, startDate, endDate, showToday);
            });

            // Nhấn Enter để tìm kiếm.
            document.getElementById('search-query').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('search-btn').click();
                }
            });

            // Nhấp vào phân trang.
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let query = $('#search-query').val();
                let startDate = $('#start-date').val();
                let endDate = $('#end-date').val();
                let showToday = $('#show-today-receipts').is(':checked');
                let newUrl = url + (url.includes('?') ? '&' : '?') + 'query=' + encodeURIComponent(query) +
                    '&start_date=' + encodeURIComponent(startDate) +
                    '&end_date=' + encodeURIComponent(endDate) +
                    '&show_today=' + encodeURIComponent(showToday);

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

            // Đặt giá trị ô tìm kiếm từ URL nếu có.
            $('#search-query').val(new URLSearchParams(window.location.search).get('query') || '');
            $('#start-date').val(new URLSearchParams(window.location.search).get('start_date') || '');
            $('#end-date').val(new URLSearchParams(window.location.search).get('end_date') || '');

            // Hiển thị thông tin khách hàng trong modal.
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
                            document.getElementById('client-address').textContent = data.address || '';
                            document.getElementById('client-tax-number').textContent = data
                                .tax_number || 'Chưa có mã số thuế';

                            $('#clientModal').modal('show');
                        });
                }
            });

            // Xóa phiếu thu và cập nhật bảng.
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var url = $(this).data('url');

                if (confirm('Bạn có chắc chắn muốn xóa phiếu thu này không?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success);
                                $(e.target).closest('tr').remove();
                                updateTableAndPagination(
                                    $('#search-query').val(),
                                    $('#start-date').val(),
                                    $('#end-date').val(),
                                    $('#show-today-receipts').is(':checked')
                                );
                            } else {
                                toastr.error(response.error);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Có lỗi xảy ra khi xóa phiếu thu.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
