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
                                        <label for="">Số và ký hiệu văn bản </label>
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 21h16M5.666 13.187A2.278 2.278 0 0 0 5 14.797V18h3.223c.604 0 1.183-.24 1.61-.668l9.5-9.505a2.278 2.278 0 0 0 0-3.22l-.938-.94a2.277 2.277 0 0 0-3.222.001l-9.507 9.52Z"/></svg>
                                                </a>
                                                <form method="post"
                                                    action="{{ route('admin.vanban.delete', ['id' => $item->id]) }}"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26"><path fill="currentColor" d="M11.5-.031c-1.958 0-3.531 1.627-3.531 3.594V4H4c-.551 0-1 .449-1 1v1H2v2h2v15c0 1.645 1.355 3 3 3h12c1.645 0 3-1.355 3-3V8h2V6h-1V5c0-.551-.449-1-1-1h-3.969v-.438c0-1.966-1.573-3.593-3.531-3.593h-3zm0 2.062h3c.804 0 1.469.656 1.469 1.531V4H10.03v-.438c0-.875.665-1.53 1.469-1.53zM6 8h5.125c.124.013.247.031.375.031h3c.128 0 .25-.018.375-.031H20v15c0 .563-.437 1-1 1H7c-.563 0-1-.437-1-1V8zm2 2v12h2V10H8zm4 0v12h2V10h-2zm4 0v12h2V10h-2z"/></svg>
                                                    </button>
                                                </form>
                                                @endif
                                                <a href="{{ route('admin.vanban.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M0 4.13v1.428a.5.5 0 0 0 .725.446l.886-.446l.377-.19L2 5.362l1.404-.708l.07-.036l.662-.333l.603-.304a.5.5 0 0 0 0-.893l-.603-.305l-.662-.333l-.07-.036L2 1.706l-.012-.005l-.377-.19l-.886-.447A.5.5 0 0 0 0 1.51v2.62ZM7.25 2a.75.75 0 0 0 0 1.5h7a.25.25 0 0 1 .25.25v8.5a.25.25 0 0 1-.25.25h-9.5a.25.25 0 0 1-.25-.25V6.754a.75.75 0 0 0-1.5 0v5.496c0 .966.784 1.75 1.75 1.75h9.5A1.75 1.75 0 0 0 16 12.25v-8.5A1.75 1.75 0 0 0 14.25 2h-7Zm-.5 4a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5ZM6 9.25a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5A.75.75 0 0 1 6 9.25Z" clip-rule="evenodd"/></svg>
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
