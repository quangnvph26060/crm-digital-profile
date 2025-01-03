@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Danh sách nhân viên</h4>
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Tên, email hoặc SĐT</label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên, mã nhân viên" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{route('admin.user.add')}}">
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
                                            <th data-priority="2">Họ tên</th>
                                            <th data-priority="3">Email</th>
                                            <th data-priority="3">Mức lương</th>
                                            <th data-priority="6">Số điện thoại</th>
                                            <th>Kpi</th>
                                            <th>Loại user</th>
                                            <th>Trạng thái</th>
                                            <th style="text-align: center" data-priority="7">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $userItem)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $userItem->full_name }}</td>
                                                <td>{{ $userItem->email }}</td>
                                                <td>{{ number_format($userItem->salary, 0, ',', '.') }}</td>
                                                <td>{{ $userItem->phone }}</td>
                                                <td>
                                                    {{ $userItem->post_number_per_day }} bài/ngày
                                                </td>
                                                <td>
                                                    @if ($userItem->type == USER_INTERN)
                                                    <div class="badge badge-soft-warning">Thực tập</div>
                                                    @elseif ($userItem->type == USER_FRESHER)
                                                    <div class="badge badge-soft-success">Chính thức</div>
                                                    @elseif ($userItem->type == USER_JUNIOR)
                                                    <div class="badge badge-soft-primary">Quản lý</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($userItem->status)
                                                    <div class="badge badge-soft-success">Hoạt động</div>
                                                    @else
                                                    <div class="badge badge-soft-danger">Đã khóa</div>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('admin.user.edit', ['id' => $userItem->id]) }}" class="btn btn-warning">Sửa</a>
                                                    <a  onclick="return confirm('Bạn có chắc chắn muốn khóa?')"
                                                        href="{{ route('admin.user.delete', ['id' => $userItem->id]) }}"
                                                        class="{{$userItem->status === 1 ? "btn btn-danger" : "btn btn-primary"}}">

                                                         {{$userItem->status === 1 ? "Khóa" : "Mở"}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$users->appends($inputs)->links()}}
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
