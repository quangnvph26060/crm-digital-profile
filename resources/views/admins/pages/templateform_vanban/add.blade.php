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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin văn bản 1</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.form_template_vanban.store.template') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>

                                <div class="col-lg-12">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label for="example-text-input" class="form-label">Tên Form <span
                                                        class="text text-danger">*</span></label>
                                                <input value=""
                                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                    name="name" type="text" id="example-text-input">
                                                @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 "
                                                style="display: flex !important;flex-direction: column;">

                                                <label for="example-text-input" class="form-label">Form <span
                                                        class="text text-danger">*</span></label>
                                                <textarea name="template_form" id="content" class="content-main"
                                                    cols="30" rows="20" placeholder="Form" required placeholder="Form"
                                                    class="template_main"></textarea>
                                                @error('template_form')
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

                                        <div class="col-lg-12 mt-3" style="display: flex !important;flex-direction: column;">

                                            <label for="example-text-input" class="form-label">Trạng thái <span
                                                    class="text text-danger">*</span></label>
                                            <select name="status" id="status-select" class="form-control ">
                                                <option value="active">Hoạt động</option>
                                                <option value="unactive" selected>Không hoạt động</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-md">Xác nhận</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<style scoped>
    .template_main{
        border-radius: 5px;border:1px solid var(--bs-input-border); padding:10px
    }
</style>
<script>
    const textarea = document.getElementById('content');
    const previewFrame = document.getElementById('previewFrame');

    function updatePreview() {
        const content = textarea.value;
        const iframeDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
        iframeDoc.open();
        iframeDoc.write(content);
        iframeDoc.close();

        const head = iframeDoc.head;
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css';
        head.appendChild(link);
    }

    textarea.addEventListener('input', function() {
        updatePreview();
    });

    updatePreview();
</script>
@endsection
