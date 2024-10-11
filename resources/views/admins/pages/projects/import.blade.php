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
                    <h4 class="mb-sm-0 font-size-18">Import từ khóa</h4>
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
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a class="btn btn-success" href="{{ route('admin.project.add-mission', ['id' => $projectId]) }}">
                                        <i class="fas fa-plus"></i> Thêm nhiệm vụ cho nhân viên
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Import file</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.project.store-import', ['id' => $projectId])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="choices-text-remove-button" class="form-label">Import excel (Tải file mẫu <a href="/keyword.xlsx">tại đây</a>)</label>
                                                <input class="form-control" type="file" name="file_import" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Import thủ công</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.project.store-handle', ['id' => $projectId])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="choices-text-remove-button" class="form-label">Từ khóa (mỗi từ khóa ấn enter)</label>
                                                <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ old('keyword') }}" name="keyword" placeholder="Enter something" />
                                                @error('keyword')
                                                    <div class="invalid-feedback d-block">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
@section('scripts')
<!-- choices js -->
<script src="{{asset('libs/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/assets/js/pages/form-advanced.init.js')}}"></script>
@endsection
