@extends('admins.layouts.index')
@section('title', $title)
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
                        <form action="{{ route('admin.vanban.update', ['id' => $vanban->id]) }}" method="POST"
                            enctype="multipart/form-data">
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
                                                        class="form-control {{ $errors->has('ho_so_so') ? 'is-invalid' : '' }} select2" >
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
                                                    <label for="example-text-input" class="form-label">Số và ký hiệu văn bản<span
                                                            class="so_va_ki_hieu_van_ban">*</span></label>
                                                    <input value="{{ isset($vanban) ? $vanban->so_va_ki_hieu_van_ban : old('so_va_ki_hieu_van_ban') }}"
                                                        class="form-control {{ $errors->has('so_va_ki_hieu_van_ban') ? 'is-invalid' : '' }}" name="so_va_ki_hieu_van_ban" type="text"
                                                        id="so_va_ki_hieu_van_ban" placeholder="Số và ký hiệu văn bản">
                                                    @error('so_va_ki_hieu_van_ban')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @php
                                            use Illuminate\Support\Facades\Blade;

                                            $template = $template_form_vanban->template_form;

                                            $compiled = Blade::compileString($template);

                                            eval('?>'.$compiled);
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
            </div>
        </div>


    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>

    var $jq = jQuery.noConflict();
    $jq(document).ready(function() {

        $jq('.select2').select2({
            width: '100%',
            // allowClear: true
        });
    });
</script>
<script>
    $jq(document).ready(function() {
    // Sự kiện thay đổi cho Agency Code (thẻ cha)
    $jq('#agency_code-select').on('change', function() {
        var selectedValue = $jq(this).val();
        loadMaPhong(selectedValue, null); // Khi chọn lại thẻ cha, reset các giá trị con
    });

    // Hàm load Ma Phong khi có Agency Code
    function loadMaPhong(selectedValue, selectedMaPhong) {
        var selectElementMaPhong = $jq('#ma-phong-select');
        var selectElementMucLuc = $jq('#muc-luc-select');
        var selectElementHopSo = $jq('#hop_so-select');
        var selectElementHoSoSo = $jq('#ho_so_so-select');

        // Reset tất cả các select box
        selectElementMaPhong.find('option').remove().append('<option value="">Chọn mã phòng</option>');
        selectElementMucLuc.find('option').remove().append('<option value="">Mục lục</option>');
        selectElementHopSo.find('option').remove().append('<option value="">Hộp số</option>');
        selectElementHoSoSo.find('option').remove().append('<option value="">Hồ sơ số</option>');

        if (selectedValue) {
            var url = "{{ route('phong-by-config_id') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue
                },
                success: function(response) {
                    console.log(response.data);
                    if (response.status === 'success') {
                        selectElementMaPhong.append('<option value="">Chọn mã phòng</option>');
                        selectElementMucLuc.append('<option value="">Mục lục</option>');
                        selectElementHopSo.append('<option value="">Hộp số</option>');
                        selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
                        response.data.forEach(function(item) {
                            var isSelected = item.ma_phong.id == selectedMaPhong ? 'selected' : '';
                            selectElementMaPhong.append('<option value="' + item.ma_phong.id + '" ' + isSelected + '>' + item.ma_phong.ten_phong + '</option>');
                        });

                        // Gắn sự kiện change cho Ma Phong sau khi đổ dữ liệu
                        selectElementMaPhong.off('change').on('change', function() {
                            var selectedMaPhong = $jq(this).val();
                            loadMucLuc(selectedValue, selectedMaPhong, null); // Reset Mục Lục khi thay đổi Ma Phong
                        });

                        // Nếu có giá trị sẵn, gọi loadMucLuc
                        if (selectedMaPhong) {
                            loadMucLuc(selectedValue, selectedMaPhong, `{{ $vanban->ma_mucluc }}`);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }else{
            selectElementMaPhong.append('<option value="">Chọn mã phòng</option>');
            selectElementMucLuc.append('<option value="">Mục lục</option>');
            selectElementHopSo.append('<option value="">Hộp số</option>');
            selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
        }
    }

    // Hàm load Muc Luc khi có Ma Phong
    function loadMucLuc(selectedValue, selectedMaPhong, selectedMucLuc) {
        var selectElementMucLuc = $jq('#muc-luc-select');
        var selectElementHopSo = $jq('#hop_so-select');
        var selectElementHoSoSo = $jq('#ho_so_so-select');

        // Reset tất cả các select box con
        selectElementMucLuc.find('option').remove().append('<option value="">Mục lục</option>');
        selectElementHopSo.find('option').remove().append('<option value="">Hộp số</option>');
        selectElementHoSoSo.find('option').remove().append('<option value="">Hồ sơ số</option>');

        if (selectedMaPhong) {
            var url = "{{ route('mucluc-by-phong_id') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue,
                    phongId: selectedMaPhong
                },
                success: function(response) {
                    if (response.status === 'success') {

                        selectElementMucLuc.append('<option value="">Mục lục</option>');
                        selectElementHopSo.append('<option value="">Hộp số</option>');
                        selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
                        response.data.forEach(function(item) {
                            var isSelected = item.ma_muc_luc.id == selectedMucLuc ? 'selected' : '';
                            selectElementMucLuc.append('<option value="' + item.ma_muc_luc.id + '" ' + isSelected + '>' + item.ma_muc_luc.ten_mucluc + '</option>');
                        });

                        // Gắn sự kiện change cho Muc Luc sau khi đổ dữ liệu
                        selectElementMucLuc.off('change').on('change', function() {
                            var selectedMucLuc = $jq(this).val();
                            loadHopSo(selectedValue, selectedMaPhong, selectedMucLuc, null); // Reset Hộp Số khi thay đổi Mục Lục
                        });

                        // Nếu có giá trị sẵn, gọi loadHopSo
                        if (selectedMucLuc) {
                            loadHopSo(selectedValue, selectedMaPhong, selectedMucLuc, `{{ $vanban->hop_so }}`);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }else{

            selectElementMucLuc.append('<option value="">Mục lục</option>');
            selectElementHopSo.append('<option value="">Hộp số</option>');
            selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
        }
    }

    // Hàm load Hop So khi có Muc Luc
    function loadHopSo(selectedValue, selectedMaPhong, selectedMucLuc, selectedHopSo) {
        var selectElementHopSo = $jq('#hop_so-select');
        var selectElementHoSoSo = $jq('#ho_so_so-select');

        // Reset select box Ho So So
        selectElementHopSo.find('option').remove().append('<option value="">Hộp số</option>');
        selectElementHoSoSo.find('option').remove().append('<option value="">Hồ sơ số</option>');

        if (selectedMucLuc) {
            var url = "{{ route('hopso-by-mucluc') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue,
                    phongId: selectedMaPhong,
                    mucluc: selectedMucLuc
                },
                success: function(response) {
                    if (response.status === 'success') {

                        selectElementHopSo.append('<option value="">Hộp số</option>');
                        selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
                        response.data.forEach(function(item) {
                            var isSelected = item.hop_so == selectedHopSo ? 'selected' : '';
                            selectElementHopSo.append('<option value="' + item.hop_so + '" ' + isSelected + '>' + item.hop_so + '</option>');
                        });

                        // Gắn sự kiện change cho Hộp Số sau khi đổ dữ liệu
                        selectElementHopSo.off('change').on('change', function() {
                            var selectedHopSo = $jq(this).val();
                            loadHoSoSo(selectedValue, selectedMaPhong, selectedMucLuc, selectedHopSo, null); // Reset Hồ Sơ Số khi thay đổi Hộp Số
                        });

                        // Nếu có giá trị sẵn, gọi loadHoSoSo
                        if (selectedHopSo) {
                            loadHoSoSo(selectedValue, selectedMaPhong, selectedMucLuc, selectedHopSo, `{{ $vanban->ho_so_so }}`);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        else{

            selectElementHopSo.append('<option value="">Hộp số</option>');
            selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
        }
    }

    // Hàm load Ho So So khi có Hop So
    function loadHoSoSo(selectedValue, selectedMaPhong, selectedMucLuc, selectedHopSo, selectedHoSoSo) {
        var selectElementHoSoSo = $jq('#ho_so_so-select');

        selectElementHoSoSo.find('option').remove().append('<option value="">Hồ sơ số</option>');
        if (selectedHopSo) {
            var url = "{{ route('hososo-by-hopso') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: selectedValue,
                    phongId: selectedMaPhong,
                    mucluc: selectedMucLuc,
                    hopso: selectedHopSo
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var selectElementHoSoSo = $jq('#ho_so_so-select');
                        selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
                        response.data.forEach(function(item) {
                            var isSelected = item.ho_so_so == selectedHoSoSo ? 'selected' : '';
                            selectElementHoSoSo.append('<option value="' + item.ho_so_so + '" ' + isSelected + '>' + item.ho_so_so + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }else{
             selectElementHoSoSo.append('<option value="">Hồ sơ số</option>');
        }
    }

    // Khi trang được load lần đầu, tự động gọi loadMaPhong nếu đã có sẵn giá trị
    var initialConfigId = $jq('#agency_code-select').val();
    var initialMaPhong = `{{ $vanban->ma_phong }}`; // Giá trị mã phòng có sẵn

    if (initialConfigId) {
        loadMaPhong(initialConfigId, initialMaPhong); // Load mã phòng ban đầu
    }
});



</script>



<script>
    CKEDITOR.replace('content', {
  toolbar: [
      { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
      { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
      { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ] },
      { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
      '/',
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', '-', 'Subscript', 'Superscript', '-', 'Strike', 'RemoveFormat' ] },
      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
      { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
      { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
      '/',
      { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'tools', items: [ 'Maximize', 'ShowBlocks', '-' ] },
      { name: 'about', items: [ 'About' ] }
  ],
  extraPlugins: 'font,colorbutton,justify',
  fontSize_sizes: '11px;12px;13px;14px;15px;16px;18px;20px;22px;24px;26px;28px;30px;32px;34px;36px',
});
</script>

<script>
    function previewPDF(event) {
    const file = event.target.files[0];  // Lấy file được chọn từ input
    const previewContainer = document.getElementById('pdf-preview-container');
    const pdfPreview = document.getElementById('pdf-preview');

    if (file && file.type === 'application/pdf') {  // Kiểm tra nếu file là PDF
        const fileURL = URL.createObjectURL(file);  // Tạo URL tạm thời để xem trước
        pdfPreview.src = fileURL;  // Đổ đường dẫn vào iframe
        previewContainer.style.display = 'block';  // Hiển thị khung xem trước
    } else {
        previewContainer.style.display = 'none';  // Ẩn khung nếu không phải là PDF
    }
}

// Nếu có file PDF đã lưu từ trước (ví dụ: khi tải lại trang với file đã được lưu)
document.addEventListener("DOMContentLoaded", function() {
    const pdfPath = `{{ asset('storage/' . $vanban->duong_dan) }}`;

    const pdfPreview = document.getElementById('pdf-preview');
    const previewContainer = document.getElementById('pdf-preview-container');

    // Kiểm tra xem đường dẫn PDF có tồn tại không
    if (pdfPath) {
        pdfPreview.src = pdfPath;  // Đổ đường dẫn file PDF đã lưu vào iframe
        previewContainer.style.display = 'block';  // Hiển thị khung xem trước
    }
});
</script>
@endsection
