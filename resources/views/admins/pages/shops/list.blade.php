@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Quản lý shop</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Tên, email hoặc mã shop</label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên, mã nhân viên" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Trạng thái hoạt động</label>
                                        <select name="status" class="form-control" id="">
                                            <option @if(isset($inputs['status']) && $inputs['status'] == -1){{'selected'}}@endif value="-1">Tất cả trạng thái</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 0){{'selected'}}@endif value="0">Không hoạt động</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 1){{'selected'}}@endif value="1">Hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Trạng thái xác thực</label>
                                        <select name="verify" class="form-control" id="">
                                            <option @if(isset($inputs['verify']) && $inputs['verify'] == -1){{'selected'}}@endif value="-1">Tất cả</option>
                                            <option @if(isset($inputs['verify']) && $inputs['verify'] == 0){{'selected'}}@endif value="0">Chưa xác thực</option>
                                            <option @if(isset($inputs['verify']) && $inputs['verify'] == 1){{'selected'}}@endif value="1">Đã xác thực</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Loại tk</label>
                                        <select class="form-control" name="type_account" id="">
                                            <option value="-1">Tất cả</option>
                                            <option @if(isset($inputs['type_account']) && $inputs['type_account'] == 'shop'){{'selected'}}@endif value="shop">Shop</option>
                                            <option @if(isset($inputs['type_account']) && $inputs['type_account'] == 'agency'){{'selected'}}@endif value="agency">Đại lý</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{route('admin.user.shop.add')}}">
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
                                            <th data-priority="1">Mã, người giới thiệu</th>
                                            <th data-priority="2">Thông tin</th>
                                            <th data-priority="6">Trạng thái</th>
                                            <th>Cấp</th>
                                            <th>Số dư</th>
                                            <th data-priority="7">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $key => $employeeItem)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    {{$employeeItem->ref_code}} <br>
                                                    @if ($employeeItem->parent_id > 0 && !empty($employeeItem->parent))
                                                        Người giới thiệu: <b>{{$employeeItem->parent->full_name}}</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p>
                                                        Shop: <b>{{$employeeItem->shop_name}}</b>
                                                    </p>
                                                    <p>Tên: <b>{{$employeeItem->full_name}}</b></p>
                                                    <p>Mail: <b>{{$employeeItem->email}}</b></p>
                                                    <p>SĐT: <b>{{$employeeItem->phone}}</b></p>
                                                </td>
                                                <td>
                                                    @if($employeeItem->status)
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-danger">Hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$employeeItem->type}}
                                                </td>
                                                <td align="right">
                                                    {{number_format($employeeItem->balance)}}
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.user.shop.change-status', ['user_id' => $employeeItem->id, 'status' => 0])}}" class="confirm btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Khóa tài khoản">
                                                        <i class="fas fa-lock"></i>
                                                    </a>
                                                    <a href="{{route('admin.user.shop.change-status', ['user_id' => $employeeItem->id, 'status' => 1])}}" class="confirm btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Mở khóa">
                                                        <i class="fas fa-lock-open"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$employees->appends($inputs)->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>
@endsection
