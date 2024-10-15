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
                                            <label for="">Tiêu đề hồ sơ và Mã Cơ quan</label>
                                            <input value="{{ isset($inputs['name']) ? $inputs['name'] : '' }}"
                                                autocomplete="off" name="name" placeholder="Tìm kiếm..." type="text"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Phông</label>
                                            <select class="form-select"  name="phong" id="phong">
                                                <option value="">Chọn Phông</option>
                                                @foreach($phongdata as $item)
                                                    <option value="{{$item->id}}" {{ isset($inputs['phong']) ?  $inputs['phong'] == $item->id ? "selected" : "" : ""}}>{{$item->ten_phong}}</option>
                                                @endforeach
                                                <!-- Thêm các tùy chọn phòng khác nếu cần -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Mục lục</label>
                                            <select class="form-select" name="muc_luc" id="muc_luc">
                                                <option value="">Chọn mục lục</option>
                                                @foreach($muclucdata as $item)
                                                    <option value="{{$item->id}}" {{ isset($inputs['muc_luc']) ? $inputs['muc_luc'] == $item->id ? "selected" :"" : ""}}>{{$item->ten_mucluc}}</option>
                                                @endforeach
                                                <!-- Thêm các tùy chọn mục lục khác nếu cần -->
                                            </select>
                                        </div>   
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="" style="opacity: 0">1</label> <br>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm
                                                kiếm</button>
                                            <a href="{{ url()->current() }}" class="btn btn-danger"><i
                                                    class="fas fa-history"></i> Tải lại</a>
                                            <a class="btn btn-success" href="{{ route('admin.profile.add') }}">
                                                <i class="fas fa-plus"></i> Thêm mới
                                            </a>
                                          
                                        </div>
                                    </div>  
                                </div>
                            </form>
                            <div class="col-lg-6 mt-2">
                              <div class="row">
                                <div class="col-lg-2">
                                    <a class="btn btn-success" href="{{ route('admin.profile.add') }}">
                                        <i class="fas fa-plus"></i> Xuất Excel
                                    </a>
                               </div>
                               <div class="col-lg-2">
                                    <a class="btn btn-success" href="{{ route('admin.profile.add') }}">
                                        <i class="fas fa-plus"></i> Nhập Excel
                                    </a>
                                </div>
                              </div>
                            </div>
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
                                                <th>Tiêu đề hồ sơ</th>
                                                <th>Ngày tháng BĐ-KT</th>
                                                <th>Số tờ</th>
                                                <th>THBQ</th>
                                                <th>Ghi chú</th>
                                                @if (auth('admin')->user()->level === 2)
                                                    <th>Hành động</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profiles as $key => $item)
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>

                                                    <td>
                                                        {{ $item->config->agency_code }}
                                                    </td>
                                                    <td>
                                                        Phông:{{ $item->maPhong->ten_phong }} <br>
                                                        Mã phông:{{ $item->maPhong->ma_phong }}
                                                    </td>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ $item->hop_so }}
                                                    </td>
                                                    <td>
                                                        {{ $item->ho_so_so }}
                                                    </td>
                                                    <td>
                                                        {{ $item->tieu_de_ho_so }}
                                                    </td>
                                                    <td>
                                                        {{ $item->ngay_bat_dau }} - {{ $item->ngay_ket_thuc }}
                                                    </td>
                                                    <td>
                                                        {{ $item->so_to }}
                                                    </td>
                                                    <td>
                                                        {{ $item->thbq }}
                                                    </td>
                                                    <td>
                                                        {{ $item->ghi_chu }}
                                                    </td>
                                                   
                                                        <td class="d-flex gap-1"> 
                                                            @if (auth('admin')->user()->level === 2)
                                                                <a href="{{ route('admin.config.edit', ['id' => $item->id]) }}"
                                                                    class="btn btn-warning">
                                                                    Sửa
                                                                </a>
                                                                <form method="post"
                                                                    action="{{ route('admin.config.delete', ['id' => $item->id]) }}"
                                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                                </form>
                                                             @endif
                                                             <a href="{{ route('admin.config.edit', ['id' => $item->id]) }}"
                                                                class="btn btn-primary">
                                                                Thông tin hồ sơ
                                                            </a>
                                                        </td>
                                                   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $profiles->links() }}
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
