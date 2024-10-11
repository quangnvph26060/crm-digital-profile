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
                    <h4 class="mb-sm-0 font-size-18">Cài đặt KPI</h4>
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <a class="btn btn-success" href="{{ route('admin.setting-kpi.add') }}">
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
                                            <th>Nhân viên</th>
                                            {{-- <th>Tuần</th> --}}
                                            <th>Ngày</th>
                                            {{-- <th>Kết thúc</th> --}}
                                            <th>SL bài mới</th>
                                            {{-- <th>SL bài sửa</th>
                                            <th>SL bài đăng</th> --}}
                                            <th style="text-align: center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kpis as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ !empty($item->user) ? $item->user->full_name : ""}}
                                                </td>
                                                {{-- <td>
                                                    {{ $item->week }}
                                                </td> --}}
                                                <td>
                                                    {{ $item->date }}
                                                </td>
                                                {{-- <td>
                                                    {{ $item->date_to }}
                                                </td> --}}
                                                <td>
                                                    {{ $item->post_new_num }}
                                                </td>
                                                {{-- <td>
                                                    {{ $item->post_edit_num }}
                                                </td>
                                                <td>
                                                    {{ $item->post_publish_num }}
                                                </td> --}}
                                                <td align="center">
                                                    <a class="btn btn-warning" href="{{route('admin.setting-kpi.edit', ["id" => $item->id])}}">
                                                        Sửa
                                                    </a>
                                                    <a onclick="return confirm('Bạn có chắc chắn muôn xóa?')" class="btn btn-danger" href="{{route('admin.setting-kpi.delete', ["id" => $item->id])}}">
                                                        Xóa
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$kpis->appends($inputs)->links()}}
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
@section('scripts')
<!-- choices js -->
<script src="{{asset('libs/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/assets/js/pages/form-advanced.init.js')}}"></script>
@endsection
