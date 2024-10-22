@extends('admins.layouts.index')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                        {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Basic Elements</li>
                        </ol>
                    </div> --}}
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin hồ sơ</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.store') }}" method="POST">
                                @csrf  
                                @include('admins/pages/profiles/form-add')
                            </form>
                          
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date_end-text-input').on('change', function() {


                var startDate = new Date($('#date_start-text-input').val());
                var endDate = new Date($(this).val());
                if (endDate < startDate) {
                    alert('Ngày kết thúc không thể nhỏ hơn ngày bắt đầu!');
                    $(this).val('');
                }
            });
        });
        $(document).ready(function() {

            $('#agency_code-select').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    var url = "{{ route('phong-to-config') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: selectedValue
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                var selectElement = $(
                                    '#ma-phong-select'); // Lấy đối tượng select

                                // Xóa tất cả các option hiện có trong select
                                selectElement.find('option').remove();

                                // Thêm option mặc định
                                selectElement.append('<option value="">Chọn mã phông</option>');
                                response.data.forEach(function(item) {
                                    selectElement.append('<option value="' + item.id +
                                        '" >' + item
                                        .ten_phong + '</option>');



                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
            $('#ma-phong-select').change(function() {
                var selectedValue = $(this).val();


            })
        });
    </script>
@endsection
