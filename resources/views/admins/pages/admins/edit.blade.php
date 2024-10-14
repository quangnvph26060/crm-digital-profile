@extends('admins.layouts.index')
@section('title','Sửa thông tin người dùng')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Sửa thông tin người dùng</h4>
                  
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sửa thông tin người dùng</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.admin.update',['id'=>$user->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Họ tên <span class="text text-danger">*</span></label>
                                            <input value="{{$user->full_name}}" required class="form-control" name="full_name" type="text" id="example-text-input">
                                            @error('full_name')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-search-input" class="form-label">Email <span class="text text-danger">*</span></label>
                                            <input value="{{$user->email}}" required class="form-control" name="email" type="text" id="example-search-input">
                                            @error('email')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="example-text-input" class="form-label">Mật khẩu <span class="text text-danger">*</span></label>
                                            <input required class="form-control" name="password" type="password" id="example-text-input">
                                            @error('password')
                                                <div class="invalid-feedback d-block">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="example-select" class="form-label">Vai trò<span class="text text-danger">*</span></label>
                                        <select required class="form-select" name="level" id="example-select">
                                            <option value="1" {{$user->level == 1 ? 'selected' : ""   }}> User </option>
                                            <option value="2" {{$user->level == 2 ? 'selected' : ""   }}> Admin </option>
                                          
                                        </select>
                                        @error('level')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
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
