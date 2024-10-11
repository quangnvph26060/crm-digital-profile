@extends('admins.layouts.index')
@section('css')
<link href="{{asset('libs/assets/libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Danh sách dự án</h4>
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
                                    <a class="btn btn-success" href="{{ route('admin.project.add') }}">
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
                                            <th>Dự án</th>
                                            <th>Đã giao</th>
                                            <th>Hoàn thành</th>
                                            <th>Đang sửa</th>
                                            <th>Chờ đăng</th>
                                            <th>Đã publish</th>
                                            <th style="text-align: center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td style="width: 30%;">
                                                    <div >
                                                        <b>Tên:</b> {{ $item->name }} 
                                                    </div>
                                                   
                                                    {{-- <b>Mô tả:</b> {{ $item->description }} --}}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.mission.list', ['project_id' => $item->id, 'status' => 0]) }}">
                                                        {{ $item->total_mission }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.mission.list', ['project_id' => $item->id, 'status' => 1]) }}">
                                                        {{ $item->total_done }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.mission.list', ['project_id' => $item->id, 'status' => 2]) }}">
                                                        {{ $item->total_edit }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.mission.list', ['project_id' => $item->id, 'status' => 3]) }}">
                                                        {{ $item->total_wait_publish }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.mission.list', ['project_id' => $item->id, 'status' => 5]) }}">
                                                        {{ number_format($item->missions_count) }}
                                                    </a>
                                                </td>
                                                <td align="center">
                                                    <a class="btn btn-warning" href="{{ route('admin.project.edit', ['id' => $item->id]) }}">Sửa</a>
                                                    <a class="btn btn-success" href="{{ route('admin.project.import', ['id' => $item->id]) }}">Import</a><br><br>
                                                    <a class="btn btn-primary" href="{{ route('admin.project.add-mission', ['id' => $item->id]) }}">Thêm nhiệm vụ</a>
                                                    <a href="{{ route('admin.project.export', ['id' => $item->id]) }}" class="btn btn-success">
                                                        Xuất excel
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
