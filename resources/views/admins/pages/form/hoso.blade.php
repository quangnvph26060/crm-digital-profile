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
                            <h4 class="card-title">Thông tin hồ sơ</h4>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.storeTemplates') }}" method="POST" enctype="multipart/form-data">
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
                                                        <textarea name="content_form" id="content" class="content-main" cols="30" rows="20" placeholder="Form"
                                                            style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ $templateActive->template_form }}</textarea>
                                                        @error('content_form')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <iframe id="previewFrame" width="100%" height="100%"
                                                            style="border: 1px solid #ccc;"></iframe>
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
        // CKEDITOR.replace('content', {
        //     toolbar: [{
        //             name: 'document',
        //             items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']
        //         },
        //         {
        //             name: 'clipboard',
        //             items: ['Undo', 'Redo']
        //         },
        //         {
        //             name: 'editing',
        //             items: ['Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt']
        //         },
        //         {
        //             name: 'forms',
        //             items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button',
        //                 'ImageButton', 'HiddenField'
        //             ]
        //         },
        //         '/',
        //         {
        //             name: 'basicstyles',
        //             items: ['Bold', 'Italic', 'Underline', '-', 'Subscript', 'Superscript', '-', 'Strike',
        //                 'RemoveFormat'
        //             ]
        //         },
        //         {
        //             name: 'paragraph',
        //             items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
        //                 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
        //                 '-', 'BidiLtr', 'BidiRtl', 'Language'
        //             ]
        //         },
        //         {
        //             name: 'links',
        //             items: ['Link', 'Unlink', 'Anchor']
        //         },
        //         {
        //             name: 'insert',
        //             items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak',
        //                 'Iframe'
        //             ]
        //         },
        //         '/',
        //         {
        //             name: 'styles',
        //             items: ['Styles', 'Format', 'Font', 'FontSize']
        //         },
        //         {
        //             name: 'colors',
        //             items: ['TextColor', 'BGColor']
        //         },
        //         {
        //             name: 'tools',
        //             items: ['Maximize', 'ShowBlocks', '-']
        //         },
        //         {
        //             name: 'about',
        //             items: ['About']
        //         }
        //     ],
        //     extraPlugins: 'font,colorbutton,justify',
        //     fontSize_sizes: '11px;12px;13px;14px;15px;16px;18px;20px;22px;24px;26px;28px;30px;32px;34px;36px',
        // });
      //  Lấy thẻ textarea theo id
     //   Lấy tất cả các phần tử có các lớp CSS tương ứng
       
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
