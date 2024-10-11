@extends('customers.layouts.index')

@section('css')
<link href="{{asset('libs/assets/libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin khách hàng</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route("customer.store") }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            @include('globals.alert')
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Tên <span class="text text-danger">*</span></label>
                                    <input value="{{ old('info.name') }}" type="text" class="form-control" name="info[name]">
                                    @error("info.name")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">SĐT <span class="text text-danger">*</span></label>
                                    <input value="{{ old('info.phone') }}" type="text" class="form-control" name="info[phone]">
                                    @error("info.phone")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Email</label>
                                    <input value="{{ old('info.email') }}" type="email" class="form-control" name="info[email]">
                                    @error("info.phone")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Ngành nghề/lĩnh vực <span class="text text-danger">*</span></label>
                                    <input value="{{ old('info.position') }}" type="text" class="form-control" name="info[position]">
                                    @error("info.position")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Website</label>
                                    <input value="{{ old('info.website') }}" type="text" class="form-control" name="info[website]">
                                    @error("info.website")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Fanpage</label>
                                    <input value="{{ old('info.fanpage') }}" type="text" class="form-control" name="info[fanpage]">
                                    @error("info.fanpage")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Nội dung tư vấn <span class="text text-danger">*</span></label>
                                    <textarea id="" class="form-control" name="info[content]" cols="30" rows="10">{{ old('info.content') }}</textarea>
                                    @error("info.content")
                                        <span class="text text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
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
@endsection
@section('scripts')
<!-- choices js -->
<script src="{{asset('libs/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/assets/js/pages/form-advanced.init.js')}}"></script>
@endsection
