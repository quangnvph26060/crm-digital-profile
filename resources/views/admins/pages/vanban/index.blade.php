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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Tiêu đề hồ sơ </label>
                                            <input value="{{ isset($inputs['name']) ? $inputs['name'] : '' }}"
                                                autocomplete="off" name="name" placeholder="Tìm kiếm..." type="text"
                                               class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" style="opacity: 0">1</label> <br>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm
                                                kiếm</button>
                                            <a href="{{ url()->current() }}" class="btn btn-danger"><i
                                                    class="fas fa-history"></i> Tải lại</a>
                                            <a class="btn btn-success" href="{{ route('admin.config.add') }}">
                                                <i class="fas fa-plus"></i> Thêm mới
                                            </a>
                                        </div>
                                    </div>
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
                                                <th>Mã Cơ quan</th>
                                                <th>Mã Phông</th>
                                                <th>Mã mục lục</th>
                                                <th>Hộp số</th>
                                                <th>Hồ sơ số</th>
                                                <th>Số và ký hiệu văn bản</th>
                                                <th>Ngày tháng văn bản</th>
                                                <th>Tác giả</th>
                                                <th>Nội dung văn bản</th>
                                                <th>Tờ số</th>
                                                <th>Đường dẫn</th>
                                                <th>Ghi chú</th>
                                                @if (auth('admin')->user()->level === 2)
                                                    <th>Hành động</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                {{ $vanban->links() }}
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
