@extends('admins.layouts.index')
@section('title', $title)
@section('content')
    <style>
        .cke_notifications_area {
            display: none;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
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
                            <h4 class="card-title">Thông tin văn bản</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.vanban.storeTemplates') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="row">
                                                <div class=" col-lg-12 mb-3">
                                                    <div class=" col-lg-12 mb-3">
                                                        <label for="example-text-input" class="form-label">Tiêu đề Form<span class="text text-danger">*</span></label>
                                                        <select name="title_form" id="" class="form-control">
                                                            <option value="">Chọn Templates</option>
                                                            @foreach($templates as $item)
                                                                <option value="{{$item->id}}" {{$item->id == $templateActive->id ? "selected":""}}>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 "
                                                        style="display: flex !important;flex-direction: column;">

                                                        <label for="example-text-input" class="form-label">Form <span
                                                                class="text text-danger">*</span></label>
                                                        <textarea name="content_form" id="content" class="content-main" style="padding: 10px" cols="30" rows="20" placeholder="Form"
                                                            style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ $templateActive->template_form }}</textarea>
                                                        @error('content_form')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 mt-4">
                                                        <iframe id="previewFrame" width="100%" height="100%"
                                                            style="border: 1px solid #ccc; padding: 10px"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-4">
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
    <script>
     const textarea = document.getElementById('content');
    const previewFrame = document.getElementById('previewFrame');

    function updatePreview() {
        const content = textarea.value;
        const iframeDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
        iframeDoc.open();
        iframeDoc.write(content);
        iframeDoc.close();

        // Bao gồm các tài nguyên CSS từ Bootstrap vào iframe
        const head = iframeDoc.head;
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'; // Đường dẫn đến CSS của Bootstrap
        head.appendChild(link);
    }

    textarea.addEventListener('input', function() {
        updatePreview();
    });

    // Initialize preview on page load
    updatePreview();
    </script>
@endsection
