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
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger"><i
                                                class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{ route('admin.vanban.add') }}">
                                            <i class="fas fa-plus"></i> Thêm mới
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="row mt-3">
                            <div class="form-group">
                                <!-- Nút Import -->
                                <button type="button" class="btn btn-primary" style="margin-right: 20px" data-bs-toggle="modal" data-bs-target="#importModal">
                                    Import
                                </button>

                                <!-- Modal -->
                                <div class="modal fade @if ($errors->any()) show @endif" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importModalLabel">Import File</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form Import -->
                                                <form action="{{ route('admin.vanban.import') }}" method="POST" enctype="multipart/form-data"  >
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="importFile" class="form-label">Chọn file Excel</label>
                                                        <input class="form-control @error('importexcel') is-invalid @enderror" type="file" id="importFile" name="importexcel" required>
                                                        @error('importexcel')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Import</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                    <!-- Nút Export -->
                                    <button type="button" class="btn btn-success">
                                        Export
                                    </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('globals.alert')
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    @php
                                        $currentProfileId = null;
                                        $currentPhong = null;
                                    @endphp
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            {{-- <th>Mã Cơ quan</th>
                                            <th>Mã Phông</th>
                                            <th>Mã mục lục</th>
                                            <th>Hộp số</th>
                                            <th>Hồ sơ số</th> --}}
                                            <th>Số và ký hiệu văn bản</th>
                                            <th>Ngày tháng văn bản</th>
                                            <th>Tác giả</th>
                                            <th>Nội dung văn bản</th>
                                            <th>Tờ số</th>
                                            {{-- <th>Đường dẫn</th> --}}
                                            <th>Ghi chú</th>
                                            @if (auth('admin')->user()->level === 2)
                                            <th>Hành động</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vanban as $index => $item )
                                        @if ($currentProfileId != $item->profile_id || $currentPhong != $item->maPhong)
                                        @php
                                            $currentProfileId = $item->profile_id;
                                            $currentPhong = $item->maPhong;  // Cập nhật mã phòng hiện tại
                                        @endphp
                                        <!-- Hiển thị tiêu đề hồ sơ khi profile_id hoặc maPhong->ten_phong thay đổi -->
                                        <tr>
                                            <td colspan="14">
                                                <strong>Phông: {{ $item->maPhong->ten_phong }}/Mục lục: {{ $item->maMucLuc->ten_mucluc }}/Hộp số: {{ $item->hop_so }}/Hồ sơ số: {{ $item->ho_so_so }}/Hồ sơ: {{ $item->profile->tieu_de_ho_so }}</strong>
                                            </td>
                                        </tr>
                                    @endif
                                        <tr>
                                            <td>{{$loop->index + 1 }}</td>
                                            {{-- <td>{{ $item->config->agency_code }}</td>
                                            <td> {{ $item->maPhong->ten_phong ?? ''}} - {{ $item->maPhong->ma_phong ??
                                                '' }}</td>
                                            <td>{{ $item->maMucLuc->ten_mucluc }} - {{ $item->maMucLuc->ma_mucluc }}
                                            </td>
                                            <td>{{ $item->hop_so }}</td>
                                            <td>{{ $item->ho_so_so }}</td> --}}
                                            <td>{{ $item->so_kh_vb }}</td>
                                            <td>{{ $item->time_vb }}</td>
                                            <td>{{ $item->tac_gia }}</td>
                                            <td>{!! $item->noi_dung !!}</td>
                                            <td>{{ $item->to_so }}</td>
                                            {{-- <td>{{ $item->duong_dan }}</td> --}}
                                            <td>{{ $item->ghi_chu }}</td>
                                            <td class="d-flex gap-1">
                                                @if (auth('admin')->user()->level === 2)
                                                <a href="{{ route('admin.vanban.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-warning">
                                                    Sửa
                                                </a>
                                                <form method="post"
                                                    action="{{ route('admin.vanban.delete', ['id' => $item->id]) }}"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                </form>
                                                @endif
                                                <a href="{{ route('admin.vanban.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-primary">
                                                    Thông tin văn bản
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>Chưa có dữ liệu</tr>
                                        @endforelse
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var importModal = new bootstrap.Modal(document.getElementById('importModal'));
            importModal.show();
        @endif
    });
</script>

@endsection
