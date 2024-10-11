@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Danh sách quyền truy cập</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" style="opacity: 0">1</label> <br>
                                    <a class="btn btn-success" href="{{route('admin.permission.create')}}">
                                        <i class="fas fa-plus"></i> Thêm mới
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
                                            <th>Mã quyền truy cập</th>
                                            <th>Tên quyền truy cập</th>
                                            <th style="text-align:center" data-priority="7">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $key => $permissionItem)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>{{$permissionItem->code}}</td>
                                                <td>{{$permissionItem->name}}</td>
                                                <td align="center">
                                                    <a href="{{route('admin.permission.edit', ['id' => $permissionItem->id])}}" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Sửa">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    <a href="{{route('admin.permission.delete', ['id' => $permissionItem->id])}}" class="confirm btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
