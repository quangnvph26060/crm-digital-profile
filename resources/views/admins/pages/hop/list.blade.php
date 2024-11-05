@extends('admins.layouts.index')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12 d-flex justify-content-between mt-3 mb-3">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
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
                                    {{-- <div class="col-lg-3">

                                    <div class="form-group">
                                        <label for="">Tên cơ quan và Mã cơ quan </label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên cơ quan và mã cơ quan" type="text" class="form-control">
                                    </div>
                                </div> --}}

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Cơ quan</label>
                                            <select class="form-select" name="coquan" id="coquan">
                                                <option value="">Chọn cơ quan</option>
                                                @foreach ($coquan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($inputs['coquan']) ? ($inputs['coquan'] == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->agency_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Phông</label>
                                            <select class="form-select" name="phong" id="phong">
                                                <option value="">Chọn phông</option>
                                                @foreach ($coquan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($inputs['coquan']) ? ($inputs['coquan'] == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->agency_name }}</option>
                                                @endforeach



                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Mục Lục</label>
                                            <select class="form-select" name="muc_luc" id="muc_luc">
                                                <option value="">Chọn cơ mục lục</option>
                                                @foreach ($coquan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($inputs['coquan']) ? ($inputs['coquan'] == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->agency_name }}</option>
                                                @endforeach



                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" style="opacity: 0">1</label> <br>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm
                                                kiếm</button>
                                            <a href="{{ url()->current() }}" class="btn btn-danger"><i
                                                    class="fas fa-history"></i> Tải lại</a>
                                            <a class="btn btn-success" href="{{ route('admin.hop.add') }}">
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
                                                <th>Cơ quan</th>
                                                <th>Phông</th>
                                                <th>Mục lục</th>
                                                <th>Hộp số</th>
                                                <th>Hành động</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($hopso as $key => $item)
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ $item->maCoQuan->agency_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->maPhong->ten_phong }}
                                                    </td>
                                                    <td>
                                                        {{ $item->maMucLuc->ten_mucluc }}
                                                    </td>
                                                    <td>
                                                        {{ $item->hop_so }}
                                                    </td>
                                                    <td class="d-flex gap-1">
                                                        <a href="{{ route('admin.hop.edit', ['id' => $item->id]) }}"
                                                            class="btn btn-warning main-action">
                                                            <img src="{{ asset('svg/detail.svg') }}" alt="SVG Image">

                                                        </a>
                                                        <form method="post"
                                                            action="{{ route('admin.hop.delete', ['id' => $item->id]) }}"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">

                                                            </button>
                                                        </form>
                                                        <a href="{{ route('admin.index', ['coquan' => $item->coquan_id , 'phong'=>$item->phong_id, 'muc_luc'=> $item->mucluc_id], '') }}"
                                                            class="btn btn-primary  main-action">
                                                            <img src="{{ asset('svg/edit.svg') }}" alt="SVG Image">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $hopso->links() }}
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
<style scoped>
    .main-action{
height: 32px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function getSelectedValues() {
            var selectedCoQuan = $('#coquan').val();
            var selectedPhong = $('#phong').val();
            var selectedMucLuc = $('#muc_luc').val();

            return {
                coquan: selectedCoQuan,
                phong: selectedPhong,
                muc_luc: selectedMucLuc
            };
        }
        var selectedValues = getSelectedValues();
        function searchPhong(selectedCoQuan) {
            var url = "{{ route('admin.profile.searchPhong') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    coquan: selectedCoQuan
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var data = response.data;
                        var selectElement = document.getElementById('phong');

                        selectElement.innerHTML = '';

                        Object.keys(data).forEach(function(key) {
                            var option = document.createElement('option');
                            option.value = data[key];
                            option.text = key;
                            if (data[key] == params.phong) {
                                option.selected = true;
                            }
                            selectElement.add(option);
                        });

                        selectElement.disabled = false;
                        var selectedPhong = $('#phong').val();
                        searchMucLuc(selectedPhong)
                        // var selectedValues = getSelectedValues();
                        // sendAjaxRequest(selectedValues);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi AJAX:', error);
                }
            });
        }
        if (selectedValues.coquan && selectedValues.phong) {
            // var url = new URL(window.location.href);
            // var params = new URLSearchParams(url.search);
            // var phong = params.get('phong');
            // var coquan = params.get('coquan');
            searchPhong(selectedValues.coquan)
            searchMucLuc(selectedValues.phong)
        }
        $('#coquan').on('change', function() {
            var selectedCoQuan = $('#coquan').val();
            searchPhong(selectedCoQuan);
        });
        $('#phong').on('change', function() {
            var selectedMucLuc = $('#phong').val();
            searchMucLuc(selectedMucLuc)
        });

        function searchMucLuc(selectedMucLuc) {
            var url = "{{ route('admin.profile.searchMucLuc') }}"
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    coquan: selectedMucLuc
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var data = response.data;
                        var selectElement = document.getElementById('muc_luc');

                        selectElement.innerHTML = '';

                        Object.keys(data).forEach(function(key) {
                            var option = document.createElement('option');
                            option.value = data[key];
                            option.text = key;
                            if (data[key] == params.muc_luc) {
                                option.selected = true;
                            }
                            selectElement.add(option);
                        });

                        selectElement.disabled = false;


                        var selectedValues = getSelectedValues();

                        sendAjaxRequest(selectedValues);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi AJAX:', error);
                }
            });
        }

        function getUrlParams(url) {
            var params = {};
            var urlParts = url.split("?");

            if (urlParts.length > 1) {
                var queryString = urlParts[1];
                var paramArray = queryString.split("&");

                paramArray.forEach(function(param) {
                    var keyValue = param.split("=");
                    params[keyValue[0]] = keyValue[1];
                });
            }

            return params;
        }
        var currentUrl = window.location.href;


        var params = getUrlParams(currentUrl);

    });
</script>
