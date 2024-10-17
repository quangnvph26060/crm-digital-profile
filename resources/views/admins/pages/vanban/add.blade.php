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
                            <form action="{{ route('admin.vanban.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('globals.alert')
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Đường dẫn <span
                                                            class="text-danger">*</span></label>
                                                    <input value="{{ old('duong_dan') }}"
                                                        class="form-control  {{ $errors->has('duong_dan') ? 'is-invalid' : '' }}"
                                                        name="duong_dan" type="file" id="example-text-input"
                                                        placeholder="Đường dẫn" accept="application/pdf"
                                                        onchange="previewPDF(event)">
                                                    @error('duong_dan')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" id="pdf-preview-container" style="display:none;">
                                                    <label class="form-label">Xem trước PDF:</label>
                                                    <iframe id="pdf-preview" style="width: 100%; height: 850px;"
                                                        frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('config_id') ? 'is-invalid' : '' }}"
                                                        name="config_id" id="agency_code-select">
                                                        <option value="">Chọn mã cơ quan</option>
                                                        @foreach ($macoquan as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('config_id') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->agency_name }} -
                                                                {{ $item->agency_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('config_id')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="ma-phong-select" class="form-label">Mã phông <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select ma_phong {{ $errors->has('ma_phong') ? 'is-invalid' : '' }}"
                                                        name="ma_phong" id="ma-phong-select">
                                                        <option value="">Chọn mã phông</option>
                                                    </select>
                                                    {{-- @error('ma_phong')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror --}}
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="muc-luc-select" class="form-label">Mã mục lục <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('ma_mucluc') ? 'is-invalid' : '' }}"
                                                        name="ma_mucluc" id="muc-luc-select">
                                                        <option value="">Chọn mã mục lục</option>
                                                        {{-- @foreach ($mamucluc as $item)
                                                            <option value="{{ $item->id }}">{{ $item->ten_mucluc }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('ma_mucluc')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-6">
                                                    <label for="hop_so" class="form-label">Hộp số <span
                                                            class="text-danger">*</span></label>
                                                    <select name="hop_so" id="hop_so-select"
                                                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }}">
                                                        <option value="">Chọn hộp số</option>
                                                        <!-- Thêm tùy chọn mặc định -->
                                                        <!-- Thêm các tùy chọn cho hộp số ở đây -->

                                                        <!-- Thêm các tùy chọn khác nếu cần -->
                                                    </select>
                                                    @error('hop_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="ho_so_so" class="form-label">Hồ sơ số <span
                                                            class="text-danger">*</span></label>
                                                    <select name="ho_so_so" id="ho_so_so-select"
                                                        class="form-control {{ $errors->has('ho_so_so') ? 'is-invalid' : '' }}">
                                                        <option value="">Chọn hồ sơ số</option>
                                                        <!-- Thêm tùy chọn mặc định -->
                                                        <!-- Thêm các tùy chọn cho hồ sơ số ở đây -->

                                                        <!-- Thêm các tùy chọn kshác nếu cần -->
                                                    </select>
                                                    @error('ho_so_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Số và ký hiệu văn bản
                                                    <span class="text text-danger">*</span></label>
                                                <input value="{{ old('so_kh_vb') }}"
                                                    class="form-control {{ $errors->has('so_kh_vb') ? 'is-invalid' : '' }}"
                                                    name="so_kh_vb" type="text" id="example-text-input"
                                                    placeholder="Số và ký hiệu văn bản  ">
                                                @error('so_kh_vb')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class=" col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Ngày tháng văn bản
                                                        <span class="text text-danger">*</span></label>
                                                    <input value="{{ old('time_vb') }}"
                                                        class="form-control {{ $errors->has('time_vb') ? 'is-invalid' : '' }}"
                                                        name="time_vb" type="date" id="example-text-input">
                                                    @error('time_vb')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class=" col-lg-6 mb-3">
                                                    <label for="example-text-input" class="form-label">Tờ số <span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ old('to_so') }}"
                                                        class="form-control {{ $errors->has('to_so') ? 'is-invalid' : '' }}"
                                                        name="to_so" type="text" id="example-text-input"
                                                        placeholder="Tờ số : 01-02">
                                                    @error('to_so')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Tác giả văn bản
                                                        <span class="text text-danger">*</span></label>
                                                    <input value="{{ old('tac_gia') }}"
                                                        class="form-control {{ $errors->has('tac_gia') ? 'is-invalid' : '' }}"
                                                        name="tac_gia" type="text" id="example-text-input"
                                                        placeholder="Tác giải văm bản">
                                                    @error('tac_gia')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-12 "
                                                style="display: flex !important;flex-direction: column;">

                                                <label for="example-text-input" class="form-label">Nội dung <span
                                                        class="text text-danger">*</span></label>
                                                <textarea name="noi_dung" id="content" cols="30" rows="5" placeholder="Ghi chú"
                                                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ old('noi_dung') }}</textarea>
                                                @error('noi_dung')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12 "
                                                style="display: flex !important;flex-direction: column;">

                                                <label for="example-text-input" class="form-label">Trạng thái <span
                                                        class="text text-danger">*</span></label>
                                                <select name="status" id="status-select"
                                                    class="form-control ">
                                                    <option value="">Chọn trạng thái</option>
                                                    <option value="active">Hoạt động</option>
                                                    <option value="unactive" selected>Không hoạt động</option>
                                                </select>
                                                
                                            </div>
                                            <div class="col-lg-12 mt-3 "
                                                style="display: flex !important;flex-direction: column;">

                                                <label for="example-text-input" class="form-label">Ghi chú <span
                                                        class="text text-danger">*</span></label>
                                                <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                                                    style="border-radius: 5px;border:1px solid var(--bs-input-border); padding:10px">{{ old('ghi_chu') }}</textarea>
                                                {{-- @error('ghi_chu')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('#agency_code-select').change(function() {
                var selectedValue = $(this).val();
                // alert(selectedValue);
                $('#ma-phong-select').find('option').remove().end().append(
                    '<option value="">Chọn mã phòng</option>').val('');
                $('#muc-luc-select').find('option').remove().end().append(
                    '<option value="">Mục lục</option>').val('');
                $('#hop_so-select').find('option').remove().end().append('<option value="">Hộp số</option>')
                    .val('');
                $('#ho_so_so-select').find('option').remove().end().append(
                    '<option value="">Hồ sơ số</option>').val('');
                if (selectedValue) {
                    var url = "{{ route('phong-by-config_id') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: selectedValue
                        },
                        success: function(response) {

                            if (response.status === 'success') {
                                var selectElement = $('#ma-phong-select');
                                selectElement.find('option').remove();
                                selectElement.append('<option value="">Chọn mã phông</option>');
                                response.data.forEach(function(item) {
                                    selectElement.append('<option value="' + item
                                        .ma_phong.id +
                                        '">' + item.ma_phong.ten_phong + '</option>'
                                        );
                                });
                                selectElement.val('{{ old('ma_phong') }}');
                                $('#ma-phong-select').change(function() {
                                    var selectedMaPhongValue = $(this).val();
                                    $('#muc-luc-select').find('option').remove().end()
                                        .append('<option value="">Mục lục</option>')
                                        .val('');
                                    $('#hop_so-select').find('option').remove().end()
                                        .append('<option value="">Hộp số</option>').val(
                                            '');
                                    $('#ho_so_so-select').find('option').remove().end()
                                        .append('<option value="">Hồ sơ số</option>')
                                        .val('');
                                    if (selectedMaPhongValue) {
                                        var url = "{{ route('mucluc-by-phong_id') }}";
                                        $.ajax({
                                            url: url,
                                            type: 'GET',
                                            data: {
                                                id: selectedValue,
                                                phongId: selectedMaPhongValue
                                            },
                                            success: function(response) {

                                                if (response.status ===
                                                    'success') {
                                                    // console.log(response.data);
                                                    var selectElement = $(
                                                        '#muc-luc-select'
                                                        );
                                                    selectElement.find(
                                                            'option')
                                                        .remove();
                                                    selectElement.append(
                                                        '<option value="">Mục lục</option>'
                                                        );
                                                    response.data.forEach(
                                                        function(item) {
                                                            selectElement
                                                                .append(
                                                                    '<option value="' +
                                                                    item
                                                                    .ma_muc_luc
                                                                    .id +
                                                                    '">' +
                                                                    item
                                                                    .ma_muc_luc
                                                                    .ten_mucluc +
                                                                    '</option>'
                                                                    );
                                                        });

                                                    $('#muc-luc-select')
                                                        .change(function() {
                                                            var selectedMucLucValue =
                                                                $(this)
                                                                .val();
                                                            $('#hop_so-select')
                                                                .find(
                                                                    'option'
                                                                    )
                                                                .remove()
                                                                .end()
                                                                .append(
                                                                    '<option value="">Hộp số</option>'
                                                                    )
                                                                .val(
                                                                '');
                                                            $('#ho_so_so-select')
                                                                .find(
                                                                    'option'
                                                                    )
                                                                .remove()
                                                                .end()
                                                                .append(
                                                                    '<option value="">Hồ sơ số</option>'
                                                                    )
                                                                .val(
                                                                '');
                                                            if (
                                                                selectedMucLucValue) {
                                                                var url =
                                                                    "{{ route('hopso-by-mucluc') }}";
                                                                $.ajax({
                                                                    url: url,
                                                                    type: 'GET',
                                                                    data: {
                                                                        id: selectedValue,
                                                                        phongId: selectedMaPhongValue,
                                                                        mucluc: selectedMucLucValue
                                                                    },
                                                                    success: function(
                                                                        response
                                                                        ) {

                                                                        if (response
                                                                            .status ===
                                                                            'success'
                                                                            ) {
                                                                            var selectElement =
                                                                                $(
                                                                                    '#hop_so-select');
                                                                            selectElement
                                                                                .find(
                                                                                    'option'
                                                                                    )
                                                                                .remove();
                                                                            selectElement
                                                                                .append(
                                                                                    '<option value="">Hộp số</option>'
                                                                                    );
                                                                            response
                                                                                .data
                                                                                .forEach(
                                                                                    function(
                                                                                        item
                                                                                        ) {
                                                                                        selectElement
                                                                                            .append(
                                                                                                '<option value="' +
                                                                                                item
                                                                                                .hop_so +
                                                                                                '">' +
                                                                                                item
                                                                                                .hop_so +
                                                                                                '</option>'
                                                                                                );
                                                                                    }
                                                                                    );

                                                                            $('#hop_so-select')
                                                                                .change(
                                                                                    function() {
                                                                                        var selectedHopSoValue =
                                                                                            $(
                                                                                                this)
                                                                                            .val();
                                                                                        $('#ho_so_so-select')
                                                                                            .find(
                                                                                                'option'
                                                                                                )
                                                                                            .remove()
                                                                                            .end()
                                                                                            .append(
                                                                                                '<option value="">Hồ sơ số</option>'
                                                                                                )
                                                                                            .val(
                                                                                                ''
                                                                                                );
                                                                                        if (
                                                                                            selectedMucLucValue) {
                                                                                            var url =
                                                                                                "{{ route('hososo-by-hopso') }}";
                                                                                            $.ajax({
                                                                                                url: url,
                                                                                                type: 'GET',
                                                                                                data: {
                                                                                                    id: selectedValue,
                                                                                                    phongId: selectedMaPhongValue,
                                                                                                    mucluc: selectedMucLucValue,
                                                                                                    hopso: selectedHopSoValue
                                                                                                },
                                                                                                success: function(
                                                                                                    response
                                                                                                    ) {
                                                                                                    console
                                                                                                        .log(
                                                                                                            response
                                                                                                            .datass
                                                                                                            );
                                                                                                    if (response
                                                                                                        .status ===
                                                                                                        'success'
                                                                                                        ) {
                                                                                                        var selectElement =
                                                                                                            $(
                                                                                                                '#ho_so_so-select');
                                                                                                        selectElement
                                                                                                            .find(
                                                                                                                'option'
                                                                                                                )
                                                                                                            .remove();
                                                                                                        selectElement
                                                                                                            .append(
                                                                                                                '<option value="">Hồ sơ số</option>'
                                                                                                                );
                                                                                                        response
                                                                                                            .data
                                                                                                            .forEach(
                                                                                                                function(
                                                                                                                    item
                                                                                                                    ) {
                                                                                                                    selectElement
                                                                                                                        .append(
                                                                                                                            '<option value="' +
                                                                                                                            item
                                                                                                                            .ho_so_so +
                                                                                                                            '">' +
                                                                                                                            item
                                                                                                                            .ho_so_so +
                                                                                                                            '</option>'
                                                                                                                            );
                                                                                                                }
                                                                                                                );
                                                                                                    }

                                                                                                },
                                                                                                error: function(
                                                                                                    xhr,
                                                                                                    status,
                                                                                                    error
                                                                                                    ) {
                                                                                                    console
                                                                                                        .error(
                                                                                                            error
                                                                                                            );
                                                                                                }
                                                                                            });
                                                                                        }
                                                                                    }
                                                                                    );
                                                                        }

                                                                    },
                                                                    error: function(
                                                                        xhr,
                                                                        status,
                                                                        error
                                                                        ) {
                                                                        console
                                                                            .error(
                                                                                error
                                                                                );
                                                                    }
                                                                });
                                                            }
                                                        });
                                                }

                                            },
                                            error: function(xhr, status,
                                            error) {
                                                console.error(error);
                                            }
                                        });
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            // $('#ma-phong-select').change(function() {
            //     var selectedMaPhongValue = $(this).val();
            //     alert(selectedMaPhongValue);
            //     if (selectedMaPhongValue) {
            //         // Thực hiện hành động mà bạn muốn khi chọn mã phòng
            //         console.log("Mã phòng được chọn: " + selectedMaPhongValue);
            //         // Bạn có thể thêm các hành động khác ở đây
            //     }
            // });
        });
    </script>

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
        });
    </script>

    <script>
        function previewPDF(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('pdf-preview-container');
            const pdfPreview = document.getElementById('pdf-preview');

            if (file && file.type === 'application/pdf') {
                const fileURL = URL.createObjectURL(file);
                pdfPreview.src = fileURL;
                previewContainer.style.display = 'block'; // Hiện khung xem trước
            } else {
                previewContainer.style.display = 'none'; // Ẩn khung nếu không phải là PDF
            }
        }
    </script>
@endsection
