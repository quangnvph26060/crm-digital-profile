@extends('admins.layouts.index')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Sửa thành viên {{ $user->full_name }}</h4>
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
                            <h4 class="card-title">Sửa nhân viên - {{ $user->full_name }}</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Họ tên <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ $user->full_name }}" required class="form-control"
                                                    name="full_name" type="text" id="example-text-input">
                                                @error('full_name')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-search-input" class="form-label">Email <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ $user->email }}" required class="form-control"
                                                    name="email" type="text" id="example-search-input">
                                                @error('email')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label">SĐT <span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ $user->phone }}" required class="form-control"
                                                    name="phone" type="text" id="example-email-input">
                                                @error('phone')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label">Số bài viết giao mỗi ngày
                                                    <span class="text text-danger">*</span></label>
                                                <input value="{{ $user->post_number_per_day }}" required
                                                    class="form-control" name="post_number_per_day" type="text"
                                                    id="example-email-input">
                                                @error('post_number_per_day')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Mật khẩu mới <span
                                                        class="text text-danger">(nếu có)</span></label>
                                                <input class="form-control" name="password" type="password"
                                                    id="example-text-input">
                                                @error('password')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Loại user <span
                                                        class="text text-danger">*</span></label>
                                                <select name="type" class="form-control" id="">
                                                    <option @if ($user->type == USER_INTERN) {{ 'selected' }} @endif
                                                        value="0">Thực tập</option>
                                                    <option @if ($user->type == USER_FRESHER) {{ 'selected' }} @endif
                                                        value="1">Chính thức</option>
                                                    <option @if ($user->type == USER_JUNIOR) {{ 'selected' }} @endif
                                                        value="2">Quản lý</option>
                                                </select>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label">Mức lương<span
                                                        class="text text-danger">*</span></label>
                                                <input value="{{ $user->salary }}" required class="form-control"
                                                    name="salary" type="text" id="example-salary-input">
                                                @error('salary')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label">Ngân hàng</label>
                                                <input value="{{ $user->bank }}" required class="form-control"
                                                    name="bank" type="text" id="example-bank-input">
                                                @error('bank')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="example-url-input" class="form-label"> Số tài khoản</label>
                                                <input value="{{ $user->account_number }}" required class="form-control"
                                                    name="account_number" type="text"
                                                    id="example-account_number-input">
                                                @error('account_number')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Thời gian thực tập <span
                                                    class="text text-danger">*</span></label>
                                                    <select required class="form-select" name="internship_duration" id="example-select">
                                                        <option value="">Chọn thời gian thực tập</option>
                                                        <option value="1" {{ $user->internship_duration == 1 ? 'selected' : '' }}>1 tháng</option>
                                                        <option value="2" {{ $user->internship_duration == 2 ? 'selected' : '' }}>2 tháng</option>
                                                        <option value="3" {{ $user->internship_duration == 3 ? 'selected' : '' }}>3 tháng</option>
                                                        <option value="4" {{ $user->internship_duration == 4 ? 'selected' : '' }}>4 tháng</option>
                                                    </select>
                                            @error('internship_duration')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 " style="    flex-direction: column;
    display: flex;">
                                                <label for="example-url-input" class="form-label"> Căn cước công dân mặt trước </label>
                                                <img src="{{ asset('storage/' . $user->font_identification_card) }}" alt="Căn cước công dân mặt trước" class="img-fluid" style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-lg-6" style="    flex-direction: column;
    display: flex;">
                                                <label for="example-url-input" class="form-label"> Căn cước công dân mặt sau </label>
                                                <img src="{{ asset('storage/' . $user->back_identification_card) }}" alt="Căn cước công dân mặt trước" class="img-fluid" style="max-width: 100%; height: auto;">
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
