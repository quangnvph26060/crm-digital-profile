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
                        <form action="{{ route('admin.form_template.store.template') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('globals.alert')
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        <div class="row">
                                            <div class=" col-lg-12 mb-3">
                                                <label for="example-text-input" class="form-label">Tên Form
                                                    <span class="text text-danger">*</span></label>
                                                <input value="{{ old('name') }}" required
                                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                    name="name" type="text" placeholder="Tên Form" id="example-text-input">
                                                @error('name')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 "
                                                    style="display: flex !important;flex-direction: column;">

                                                    <label for="example-text-input" class="form-label">Template Form
                                                        <span class="text text-danger">*</span></label>
                                                    <textarea name="template_form" id="content" cols="30" rows="5" required
                                                        placeholder="template_form" class="form_template"
                                                        style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ old('template_form') }}</textarea>
                                                    @error('template_form')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 "
                                                    style="display: flex !important;flex-direction: column;">
                                                    <div id="preview" style=" padding: 10px;">
                                                        <!-- Kết quả sẽ hiển thị ở đây -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    CKEDITOR.replace('content', {
            toolbar: [{
                    name: 'document',
                    items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']
                },
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'editing',
                    items: ['Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt']
                },
                {
                    name: 'forms',
                    items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button',
                        'ImageButton', 'HiddenField'
                    ]
                },
                '/',
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', '-', 'Subscript', 'Superscript', '-', 'Strike',
                        'RemoveFormat'
                    ]
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                        'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
                        '-', 'BidiLtr', 'BidiRtl', 'Language'
                    ]
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink', 'Anchor']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak',
                        'Iframe'
                    ]
                },
                '/',
                {
                    name: 'styles',
                    items: ['Styles', 'Format', 'Font', 'FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'tools',
                    items: ['Maximize', 'ShowBlocks', '-']
                },
                {
                    name: 'about',
                    items: ['About']
                }
            ],
            extraPlugins: 'font,colorbutton,justify',
            fontSize_sizes: '11px;12px;13px;14px;15px;16px;18px;20px;22px;24px;26px;28px;30px;32px;34px;36px',
            on: {
                change: function() {
                    // Cập nhật nội dung của div preview với nội dung từ CKEditor
                    const preview = document.getElementById('preview');
                    preview.innerHTML = this.getData();
                }
            }
        });
</script>

<script>
    // Lắng nghe sự thay đổi trong textarea
document.getElementById('content').addEventListener('input', function () {
    // Lấy nội dung HTML từ textarea
    const content = this.value;

    // Tạo phần tử div tạm để chuyển đổi nội dung HTML thành DOM
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = content;

    // Xóa nội dung hiện tại trong phần preview
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    // Thêm các phần tử form từ tempDiv vào phần preview
    while (tempDiv.firstChild) {
        preview.appendChild(tempDiv.firstChild);
    }
});

</script>
<style scoped>
    .form_template{
        border-radius: 5px;border:1px solid var(--bs-input-border);
    }
</style>
@endsection
