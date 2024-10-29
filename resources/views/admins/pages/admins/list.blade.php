@extends('admins.layouts.index')
@section('title',$title)
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
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
                                        <label for="">Tên và email</label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên, mã nhân viên" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{route('admin.admin.add')}}">
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
                                            <th>Vai trò</th>
                                            @if (auth('admin')->user()->level === 2)
                                            <th>Trạng thái</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $userItem)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $userItem->full_name }}</td>
                                                <td>{{ $userItem->email }}</td>
                                                <td>{{$userItem->level === 1 ? "User" :"Admin"}}</td>
                                               
                                                 @if (auth('admin')->user()->level === 2)
                                                    <td  class="d-flex gap-1">
                                                        <a  href="{{ route('admin.admin.edit', ['id' => $userItem->id]) }}" class="btn btn-warning">
                                                            <img src="{{ asset('svg/detail.svg') }}" alt="SVG Image">
                                                        </a>
                                                        <form method="GET" action="{{ route('admin.admin.delete', ['id' => $userItem->id]) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                            @csrf
                                                        
                                                            <button type="submit" class="btn btn-danger">
                                                                <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">
                                                            </button>
                                                        </form>
                                                    </td>  
                                               @endif
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
