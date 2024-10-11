@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Sửa quyền <b>{{$role->name}}</b></h4>
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
                        <h4 class="card-title">Thông tin quyền</h4>
                    </div>
                    <div class="card-body p-4">
                        {{-- {{dd($errors->all())}} --}}
                        <form action="{{route('admin.role.update', ['id' => $role->id])}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Tên quyền<span class="text text-danger">*</span></label>
                                            <input value="{{$role->name}}" placeholder="Ví dụ: Admin" required class="form-control" name="name" type="text" id="example-text-input">
                                            @error('name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Mã quyền <span class="text text-danger">*</span></label>
                                            <input value="{{$role->code}}" readonly placeholder="Ví dụ: admin" class="form-control" name="code" type="text" id="example-search-input">
                                            @error('code')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Quyền truy cập @error('permissions')<span class="text text-danger">{{$message}}</span>@endif</label>
                                </div>
                                @foreach (array_chunk($permissions, 3) as $permissionGroups)
                                    <div class="col-lg-4">
                                        @foreach ($permissionGroups as $permissionItem)
                                            <div>
                                                <div class="form-check mb-3">
                                                    <input name="permissions[]" @if(in_array($permissionItem['id'], $permission_role_olds)){{'checked'}}@endif value="{{$permissionItem['id']}}" class="form-check-input" type="checkbox" id="formCheck{{$permissionItem['id']}}">
                                                    <label class="form-check-label" for="formCheck{{$permissionItem['id']}}">
                                                        {{$permissionItem['name']}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
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