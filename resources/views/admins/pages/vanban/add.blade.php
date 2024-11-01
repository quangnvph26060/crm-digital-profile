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
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="example-text-input" class="form-label">Đường dẫn <span class="text-danger">*</span></label>
                                                <input value="{{ old('duong_dan') }}"
                                                    class="form-control  {{ $errors->has('duong_dan') ? 'is-invalid' : '' }}" name="duong_dan" type="file"
                                                    id="example-text-input" placeholder="Đường dẫn" accept="application/pdf" onchange="previewPDF(event)">
                                                @error('duong_dan')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3" id="pdf-preview-container" style="display:none;">
                                                <label class="form-label">Xem trước PDF:</label>
                                                <iframe id="pdf-preview" style="width: 100%; height: 850px;" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <div class="col-lg-12 mb-3">
                                                    <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('config_id') ? 'is-invalid' : '' }} select2"
                                                        name="ma_co_quan" id="agency_code-select">
                                                        <option value="">Chọn mã cơ quan</option>
                                                        @foreach ($macoquan as $item)
                                                        <option value="{{ $item->id }}" {{ (isset($vanban) && $vanban->ma_co_quan == $item->id) ? 'selected'
                                                            : '' }}>
                                                            {{ $item->agency_name }} - {{ $item->agency_code }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('config_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label for="ma-phong-select" class="form-label">Mã phông <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select ma_phong {{ $errors->has('ma_phong') ? 'is-invalid' : '' }} select2"
                                                        name="ma_phong" id="ma-phong-select">
                                                        <option value="">Chọn mã phông</option>
                                                        {{-- Thêm các tùy chọn cho mã phông nếu có --}}
                                                    </select>
                                                    @error('ma_phong')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label for="muc-luc-select" class="form-label">Mã mục lục <span
                                                            class="text text-danger">*</span></label>
                                                    <select
                                                        class="form-select {{ $errors->has('ma_mucluc') ? 'is-invalid' : '' }} select2"
                                                        name="ma_mucluc" id="muc-luc-select">
                                                        <option value="">Chọn mã mục lục</option>
                                                        {{-- Thêm các tùy chọn cho mã mục lục nếu có --}}
                                                    </select>
                                                    @error('ma_mucluc')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-6">
                                                    <label for="hop_so" class="form-label">Hộp số <span
                                                            class="text-danger">*</span></label>
                                                    <select name="hop_so" id="hop_so-select"
                                                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }} select2">
                                                        <option value="">Chọn hộp số</option>
                                                        {{-- Thêm các tùy chọn cho hộp số nếu có --}}
                                                    </select>
                                                    @error('hop_so')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="ho_so_so" class="form-label">Hồ sơ số <span
                                                            class="text-danger">*</span></label>
                                                    <select name="ho_so_so" id="ho_so_so-select"
                                                        class="form-control {{ $errors->has('ho_so_so') ? 'is-invalid' : '' }} select2">
                                                        <option value="">Chọn hồ sơ số</option>
                                                        {{-- Thêm các tùy chọn cho hồ sơ số nếu có --}}
                                                    </select>
                                                    @error('ho_so_so')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="mb-3">
                                                    <label for="so_va_ki_hieu_van_ban" class="form-label">Số và ký hiệu văn bản<span
                                                            class="text text-danger">*</span></label>
                                                    <input value="{{ isset($vanban) ? $vanban->so_va_ki_hieu_van_ban : old('so_va_ki_hieu_van_ban') }}"
                                                        class="form-control {{ $errors->has('so_va_ki_hieu_van_ban') ? 'is-invalid' : '' }}" name="so_va_ki_hieu_van_ban" type="text"
                                                        id="so_va_ki_hieu_van_ban" placeholder="Số và ký hiệu văn bản">
                                                    @error('so_va_ki_hieu_van_ban')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- @include('admins/pages/vanban/form-add') --}}
                                            @php
                                                use Illuminate\Support\Facades\Blade;

                                                $template = $template_form_vanban->template_form ?? null;

                                                if (!empty($template)) {
                                                    $compiled = Blade::compileString($template);
                                                    eval('?>'.$compiled);
                                                } else {
                                                 
                                                    echo "";
                                                }
                                            @endphp
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Xác nhận</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>

    var $jq = jQuery.noConflict();
    $jq(document).ready(function() {
        console.log("Kích hoạt Select2");
        $jq('.select2').select2({
            width: '100%',
            // allowClear: true
        });
    });
</script>
<script>
    $jq(document).ready(function() {
            $jq('#agency_code-select').change(function() {
                var selectedValue = $jq(this).val();
                // alert(selectedValue);
                $jq('#ma-phong-select').find('option').remove().end().append(
                    '<option value="">Chọn mã phông</option>').val('');
                $jq('#muc-luc-select').find('option').remove().end().append(
                    '<option value="">Mục lục</option>').val('');
                $jq('#hop_so-select').find('option').remove().end().append('<option value="">Hộp số</option>')
                    .val('');
                $jq('#ho_so_so-select').find('option').remove().end().append(
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
                                var selectElement = $jq('#ma-phong-select');
                                selectElement.find('option').remove();
                                selectElement.append('<option value="">Chọn mã phông</option>');
                                response.data.forEach(function(item) {
                                    selectElement.append('<option value="' + item
                                        .ma_phong.id +
                                        '">' + item.ma_phong.ten_phong + '</option>'
                                        );
                                });
                                selectElement.val('{{ old('ma_phong') }}');
                                $jq('#ma-phong-select').change(function() {
                                    var selectedMaPhongValue = $jq(this).val();
                                    $jq('#muc-luc-select').find('option').remove().end()
                                        .append('<option value="">Mục lục</option>')
                                        .val('');
                                    $jq('#hop_so-select').find('option').remove().end()
                                        .append('<option value="">Hộp số</option>').val(
                                            '');
                                    $jq('#ho_so_so-select').find('option').remove().end()
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
                                                    var selectElement = $jq(
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

                                                    $jq('#muc-luc-select')
                                                        .change(function() {
                                                            var selectedMucLucValue =
                                                                $jq(this)
                                                                .val();
                                                            $jq('#hop_so-select')
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
                                                            $jq('#ho_so_so-select')
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
                                                                                $jq(
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

                                                                            $jq('#hop_so-select')
                                                                                .change(
                                                                                    function() {
                                                                                        var selectedHopSoValue =
                                                                                            $jq(
                                                                                                this)
                                                                                            .val();
                                                                                        $jq('#ho_so_so-select')
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
                                                                                                            $jq(
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

            // $jq('#ma-phong-select').change(function() {
            //     var selectedMaPhongValue = $jq(this).val();
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
