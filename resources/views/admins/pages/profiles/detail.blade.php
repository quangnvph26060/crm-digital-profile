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
                        {{-- <div class="card-header">
                            <h4 class="card-title">Thông tin hồ sơ</h4>
                        </div> --}}

                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.update', ['id' => $profile->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                                                            class="text text-danger">*</span></label>
                                                    <select class="form-select" name="ma_coquan" id="agency_code-select"
                                                        required>
                                                        <option value="">Chọn mã cơ quan</option>
                                                        @foreach ($macoquan as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $profile->config_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->agency_name }} -
                                                                {{ $item->agency_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('ma_coquan')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="ma-phong-select" class="form-label">Mã phông <span
                                                            class="text text-danger">*</span></label>
                                                    <select class="form-select ma_phong" name="ma_phong" required
                                                        id="ma-phong-select">
                                                        <option value="">Chọn mã phông</option>

                                                    </select>
                                                    @error('ma_phong')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã mục lục <span
                                                            class="text text-danger">*</span></label>
                                                    <select class="form-select" name="ma_mucluc" id="agency_code-select"
                                                        required>
                                                        <option value="">Chọn mã mục lục</option>
                                                        @foreach ($mamucluc as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $profile->ma_muc_luc == $item->id ? 'selected' : '' }}>{{ $item->ten_mucluc }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ma_mucluc')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hộp số<span
                                                            class="text text-danger">*</span></label>
                                                    <input required value="{{ $profile->hop_so }}" required
                                                        class="form-control" name="hop_so" type="text"
                                                        id="example-text-input" placeholder="Hộp số">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Hồ sơ số<span
                                                            class="text text-danger">*</span></label>
                                                    <input required value="{{ $profile->ho_so_so }}" required
                                                        class="form-control" name="ho_so_so" type="text"
                                                        id="example-text-input" placeholder="Hồ sơ số">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label">Số tờ <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ $profile->so_to }}" required class="form-control"
                                                        name="so_to" type="text" id="example-text-input"
                                                        placeholder="số tờ">
                                                    @error('so_to')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="example-text-input" class="form-label"> THBQ <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ $profile->thbq }}" required class="form-control"
                                                        name="thbq" type="text" id="example-text-input"
                                                        placeholder="THBQ">
                                                    @error('thbq')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Tiêu đề hồ sơ <span
                                                        class="text text-danger">*</span></label>
                                                <input required value="{{ $profile->tieu_de_ho_so }}" required
                                                    class="form-control" name="tieu_de_ho_so" type="text"
                                                    id="example-text-input" placeholder="Tiêu đề hồ sơ ">
                                                @error('tieu_de_ho_so')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Ngày bắt đầu <span
                                                            class="text text-danger">*</span></label>
                                                    <input required value="{{  date('Y-m-d', strtotime($profile->ngay_bat_dau)) }}" required
                                                        class="form-control" name="date_start" type="date"
                                                        id="example-text-input">
                                                    @error('date_start')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class=" col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Ngày kết thúc <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ date('Y-m-d', strtotime($profile->ngay_ket_thuc)) }}" required class="form-control"
                                                        name="date_end" type="date" id="example-text-input">
                                                    @error('date_end')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-12 "
                                                style="display: flex !important;flex-direction: column;">

                                                <p>
                                                    Ghi chú <span class="text text-danger">*</span>
                                                </p>
                                                <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                                                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{$profile->ghi_chu}}</textarea>
                                                @error('ghi_chu')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-12 mt-4">
                                        <div>
                                            <button type="submit" class="btn btn-primary w-md">
                                                Xác nhận
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                       
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
                                                {{-- <th>Hộp số</th>
                                                <th>Hồ sơ số</th> --}}
                                                <th>Số và ký hiệu văn bản</th>
                                                <th>Ngày tháng văn bản</th>
                                                <th>Tác giả</th>
                                                <th>Nội dung văn bản</th>
                                                <th>Tờ số</th>
                                                {{-- <th>Đường dẫn</th> --}}
                                                <th>Ghi chú</th>
                                                <th>Trạng thái</th>
                                                @if (auth('admin')->user()->level === 2)
                                                    <th>Hành động</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($vanban as $index =>  $item )
                                                    <tr>
                                                        <td>{{$loop->index + 1 }}</td>
                                                        {{-- <td>{{ $item->config->agency_code }}</td>
                                                        <td> {{ $item->maPhong->ten_phong  ?? ''}} - {{ $item->maPhong->ma_phong ?? '' }}</td>
                                                        <td>{{ $item->maMucLuc->ten_mucluc }} - {{ $item->maMucLuc->ma_mucluc }}</td> --}}
                                                            {{-- <td>{{ $item->hop_so }}</td>
                                                            <td>{{ $item->ho_so_so }}</td> --}}
                                                        <td>{{ $item->so_kh_vb }}</td>
                                                        <td>{{ $item->time_vb	 }}</td>
                                                        <td>{{ $item->tac_gia }}</td>
                                                        <td>{!! $item->noi_dung !!}</td>
                                                        <td>{{ $item->to_so }}</td>
                                                        {{-- <td>{{ $item->duong_dan }}</td> --}}
                                                        <td>{{ $item->ghi_chu }}</td>
                                                        <td>
                                                            {!! $item->getStatus !!}
                                                        </td>
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
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#agency_code-select').change(function() {
                var selectedId = $(this).val();
                if (selectedId) {
                    getPhong(selectedId)
                }
            });
        });
        $(document).ready(function() {
            var selectedId = $('#agency_code-select').val();
            getPhong(selectedId)


        });

        function getPhong(selectedValue) {
            var ma_phong = "{{ $profile->ma_phong }}";
            var url = "{{ route('phong-to-config') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var selectElement = $('#ma-phong-select');

                        selectElement.find('option').remove();

                        selectElement.append('<option value="">Chọn mã phông</option>');

                        response.data.forEach(function(item) {
                            var option = $('<option>', {
                                value: item.id,
                                text: item.ten_phong
                            });

                            if (item.id == ma_phong) {
                                option.prop('selected', true);
                            }

                            selectElement.append(option);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
