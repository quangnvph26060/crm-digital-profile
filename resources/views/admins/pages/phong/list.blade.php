@extends('admins.layouts.index')
@section('title',$title)
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-3 mb-3">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
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
                                        <label for="">Tên cơ quan và Mã cơ quan </label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên cơ quan và mã cơ quan" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{route('admin.phong.add')}}">
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
                                            <th>Mã cơ quan</th>
                                            <th>Tên Phông</th>
                                            <th>Mã phông</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach ($phong as $key => $item)
                                          
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    {{ $item->coquan->agency_name}} 
                                                </td>
                                                <td>
                                                    {{ $item->ten_phong}}
                                                </td>
                                                <td>
                                                    {{ $item->ma_phong}}
                                                </td>
                                               
                                                <td class="d-flex gap-1">
                                                    <a href="{{ route('admin.phong.edit', ['id' => $item->id]) }}" class="btn btn-warning">
                                                        Sửa
                                                    </a>
                                                    <form method="post" action="{{ route('admin.phong.delete', ['id' => $item->id]) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$phong->links()}}
                        </div>

                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
