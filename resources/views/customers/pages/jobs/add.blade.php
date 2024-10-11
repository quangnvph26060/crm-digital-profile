@extends('customers.layouts.index')

@section('css')
<link href="{{asset('libs/assets/libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin nhiệm vụ</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route("customer.store-job") }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            @include('globals.alert')
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Chọn dự án</label>
                                    <select class="form-control" name="project_id" id="">
                                        @foreach ($projects as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('keyword')
                                        <div class="invalid-feedback d-block">
                                            {{$message}}
                                        </div>
                                    @enderror
                                    {{-- <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ $keywords }}" name="keyword" placeholder="Enter something" />
                                    @error('keyword')
                                        <div class="invalid-feedback d-block">
                                            {{$message}}
                                        </div>
                                    @enderror --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="choices-text-remove-button" class="form-label">Từ khóa (mỗi từ khóa ấn enter)</label>
                                    <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ old('keyword') }}" name="keyword" placeholder="Enter something" />
                                    @error('keyword')
                                        <div class="invalid-feedback d-block">
                                            {{$message}}
                                        </div>
                                    @enderror
                                    {{-- <input data-trigger class="form-control" id="choices-text-remove-button" type="text" value="{{ $keywords }}" name="keyword" placeholder="Enter something" />
                                    @error('keyword')
                                        <div class="invalid-feedback d-block">
                                            {{$message}}
                                        </div>
                                    @enderror --}}
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
