@extends('admins.layouts.index')
@section('title',$title)
@section('content')
<style>
     .switch {
            position: relative;
            display: inline-block;
            width: 40px;  /* Chiều rộng nút nhỏ hơn */
            height: 20px; /* Chiều cao nút nhỏ hơn */
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px; /* Bo tròn góc */
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px; /* Chiều cao phần trượt */
            width: 16px; /* Chiều rộng phần trượt */
            left: 2px; /* Khoảng cách từ bên trái */
            bottom: 2px; /* Khoảng cách từ dưới lên */
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50; /* Màu khi bật */
        }

        input:checked + .slider:before {
            transform: translateX(20px); /* Di chuyển phần trượt khi bật */
        }
</style>
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
                                        <label for="">Tên Form và Template Form </label>
                                        <input value="{{isset($inputs['name_form']) ? $inputs['name_form'] : ''}}" autocomplete="off" name="name_form" placeholder="Tên Form và Template Form ss" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label> <br>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                        <a class="btn btn-success" href="{{route('admin.form_template.add.template')}}">
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
                                            <th>Tên Form</th>
                                            <th>Nội dung Form</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($template as $key =>  $item )
                                        <tr>
                                            <td>
                                                {{$key + 1}}
                                            </td>

                                            <td>
                                                {{ $item->name}}
                                            </td>
                                            <td>
                                                {!!  $item->template_form  !!}
                                            </td>

                                            <td>
                                                <div class="container">

                                                    <form action="{{ route('admin.form_template.updatestatus.template', ['id' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <label class="switch">
                                                            <input type="checkbox" name="status" value="active" onchange="this.form.submit()" {{ $item->status === 'active' ? 'checked' : '' }}>
                                                            <span class="slider"></span>
                                                        </label>
                                                        <p>Status: {{ $item->status }}</p>
                                                    </form>
                                                </div>
                                            </td>

                                            <td class="d-flex gap-1">
                                                <a href="{{ route('admin.form_template.edit.template', ['id' => $item->id]) }}" class="btn btn-warning">
                                                    <img src="{{ asset('svg/detail.svg') }}" alt="SVG Image">

                                                </a>
                                                <form method="post" action="{{ route('admin.form_template.delete.template', ['id' => $item->id]) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{$template->links()}}
                        </div>

                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection

