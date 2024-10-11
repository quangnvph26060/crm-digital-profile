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
                    <h4 class="mb-sm-0 font-size-18">Thêm nhiệm vụ cho nhân viên</h4>
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
                                    <a class="btn btn-success" href="{{ route('admin.project.import', ['id' => $projectId]) }}">
                                        <i class="fas fa-plus"></i> Import từ khóa mơi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Thông tin nhiệm vụ</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('admin.project.store-mission', ['id' => $projectId])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Ngày giao <span class="text text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                                            @error('date')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-multiple-default" class="form-label font-size-13 text-muted">
                                                Chọn từ khóa
                                            </label>
                                            <select class="form-control" data-trigger
                                                name="keyword[]" id="choices-multiple-default"
                                                placeholder="This is a placeholder" multiple>
                                                @foreach ($keywords as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                            {{-- <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ $keywords }}" name="keyword" placeholder="Enter something" /> --}}
                                            @error('keyword')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Chọn nhân viên <span class="text text-danger">*</span></label>
                                            <select name="user_id" class="form-control" data-trigger name="choices-single-groups"
                                                id="choices-single-groups">
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="choices-single-groups" class="form-label font-size-13 text-muted">Ngày hết hạn <span class="text text-danger">*</span></label>
                                            <input type="date" required class="form-control" name="deadline">
                                            @error('deadline')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Ghi chú cho nhân viên</label>
                                            <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận thêm
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
