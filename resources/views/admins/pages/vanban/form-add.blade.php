
<div class="row">
    <div class="col-lg-12">
        @include('globals.alert')
    </div>
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="agency_code-select" class="form-label">Mã Cơ Quan <span
                            class="text text-danger">*</span></label>
                    <select
                        class="form-select {{ $errors->has('ma_coquan') ? 'is-invalid' : '' }}"
                        name="ma_coquan" id="agency_code-select">
                        <option value="">Chọn mã cơ quan</option>
                        @foreach ($macoquan as $item)
                            <option value="{{ $item->id }}"
                                {{ isset($profile) ? ($profile->config_id == $item->id ? 'selected' : '') : (old('ma_coquan') == $item->id ? 'selected' : '') }} >
                                {{ $item->agency_name }} -
                                {{ $item->agency_code }}</option>
                        @endforeach
                    </select>
                    @error('ma_coquan')
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
                    @error('ma_phong')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-4 mb-3">
                    <label for="agency_code-select" class="form-label">Mã mục lục <span
                            class="text text-danger">*</span></label>
                    <select
                        class="form-select {{ $errors->has('ma_mucluc') ? 'is-invalid' : '' }}"
                        name="ma_mucluc" id="agency_code-select">
                        <option value="">Chọn mã mục lục</option>
                        @foreach ($mamucluc as $item)
                            <option value="{{ $item->id }}"
                                {{ isset($profile) ? ($profile->ma_muc_luc == $item->id ? 'selected' : '') : (old('ma_mucluc') == $item->id ? 'selected' : '') }}>
                                {{ $item->ten_mucluc }}
                            </option>
                        @endforeach
                    </select>
                    @error('ma_mucluc')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <label for="example-text-input" class="form-label">Hộp số<span
                            class="text text-danger">*</span></label>
                    <input value="{{   isset($profile) ?  $profile->hop_so : old('hop_so') }}"
                        class="form-control {{ $errors->has('hop_so') ? 'is-invalid' : '' }}"
                        name="hop_so" type="text" id="example-text-input"
                        placeholder="Hộp số">
                    @error('hop_so')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-3">
                    <label for="example-text-input" class="form-label">Hồ sơ số<span
                            class="text text-danger">*</span></label>
                    <input value="{{    isset($profile) ?  $profile->ho_so_so : old('ho_so_so') }}"
                        class="form-control {{ $errors->has('ho_so_so') ? 'is-invalid' : '' }}"
                        name="ho_so_so" type="text" id="example-text-input"
                        placeholder="Hồ sơ số">
                    @error('ho_so_so')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-3">
                    <label for="example-text-input" class="form-label">Số tờ <span
                            class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  $profile->so_to : old('so_to') }}"
                        class="form-control {{ $errors->has('so_to') ? 'is-invalid' : '' }}"
                        name="so_to" type="text" id="example-text-input"
                        placeholder="số tờ">
                    @error('so_to')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-3">
                    <label for="example-text-input" class="form-label"> THBQ <span
                            class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  $profile->thbq : old('thbq')   }}"
                        class="form-control {{ $errors->has('thbq') ? 'is-invalid' : '' }}"
                        name="thbq" type="text" id="example-text-input"
                        placeholder="THBQ">
                    @error('thbq')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
  <div class="col-lg-3">
                    <label for="example-text-input" class="form-label"> demo quang<span
                            class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  $profile->demo_quang: old('demo_quang')   }}"
                        class="form-control {{ $errors->has('thbq') ? 'is-invalid' : '' }}"
                        name="thbq" type="text" id="example-text-input"
                        placeholder="THBQ">
                    @error('thbq')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="example-text-input" class="form-label">Tiêu đề hồ sơ <span
                        class="text text-danger">*</span></label>
                <input value="{{ isset($profile) ?  $profile->tieu_de_ho_so : old('tieu_de_ho_so') }}"
                    class="form-control {{ $errors->has('tieu_de_ho_so') ? 'is-invalid' : '' }}"
                    name="tieu_de_ho_so" type="text" id="example-text-input"
                    placeholder="Tiêu đề hồ sơ ">
                @error('tieu_de_ho_so')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label for="date_start-text-input" class="form-label">Ngày bắt đầu
                        <span class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  date('Y-m-d', strtotime($profile->ngay_bat_dau)) : old('date_start') }}"
                        class="form-control {{ $errors->has('date_start') ? 'is-invalid' : '' }}"
                        name="date_start" type="date" id="date_start-text-input">
                    @error('date_start')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class=" col-lg-6 mb-3">
                    <label for="date_end-text-input" class="form-label">Ngày kết thúc
                        <span class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  date('Y-m-d', strtotime($profile->ngay_ket_thuc)) :  old('date_end') }}"
                        class="form-control {{ $errors->has('date_end') ? 'is-invalid' : '' }}"
                        name="date_end" type="date" id="date_end-text-input">
                    @error('date_end')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 "
                style="display: flex !important;flex-direction: column;">

                <p>
                    Ghi chú <span class="text text-danger">*</span>
                </p>
                <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{isset($profile) ?   $profile->ghi_chu : ""}}</textarea>
                @error('ghi_chu')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
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

<div class="mb-3">
            <label for="example-text-input" class="form-label">Sao chep<span
                    class="text text-danger">*</span></label>
            <input value="{{ isset($vanban) ? $vanban->sao_chep: old('sao_chep') }}"
                class="form-control {{ $errors->has('sao_chep') ? 'is-invalid' : '' }}" name="sao_chep" type="text"
                id="example-text-input" placeholder="Số và ký hiệu văn bản">
            @error('sao_chep')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="example-text-input" class="form-label">Ngày tháng văn bản <span
                        class="text text-danger">*</span></label>
                <input value="{{ isset($vanban) ? $vanban->time_vb : old('time_vb') }}"
                    class="form-control {{ $errors->has('time_vb') ? 'is-invalid' : '' }}" name="time_vb" type="date"
                    id="example-text-input">
                @error('time_vb')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="example-text-input" class="form-label">Tờ số <span class="text text-danger">*</span></label>
                <input value="{{ isset($vanban) ? $vanban->to_so : old('to_so') }}"
                    class="form-control {{ $errors->has('to_so') ? 'is-invalid' : '' }}" name="to_so" type="text"
                    id="example-text-input" placeholder="Tờ số : 01-02">
                @error('to_so')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Tác giả văn bản <span
                        class="text text-danger">*</span></label>
                <input value="{{ isset($vanban) ? $vanban->tac_gia : old('tac_gia') }}"
                    class="form-control {{ $errors->has('tac_gia') ? 'is-invalid' : '' }}" name="tac_gia" type="text"
                    id="example-text-input" placeholder="Tác giả văn bản">
                @error('tac_gia')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-lg-12" style="display: flex !important;flex-direction: column;">
            <label for="example-text-input" class="form-label">Nội dung <span class="text text-danger">*</span></label>
            <textarea name="noi_dung" id="content" cols="30" rows="5" placeholder="Ghi chú"
                style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{ isset($vanban) ? $vanban->noi_dung : old('noi_dung') }}</textarea>
            @error('noi_dung')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-12 mt-3" style="display: flex !important;flex-direction: column;">
            <label for="example-text-input" class="form-label">Trạng thái <span
                    class="text text-danger">*</span></label>
            <select name="status" id="status-select" class="form-control">
                <option value="">Chọn trạng thái</option>
                <option value="active" {{ (isset($vanban) && $vanban->status == 'active') ? 'selected' : '' }}>Hoạt động
                </option>
                <option value="unactive" {{ (isset($vanban) && $vanban->status == 'unactive') ? 'selected' : '' }}>Không
                    hoạt động</option>
            </select>
        </div>
        <div class="col-lg-12 mt-3" style="display: flex !important;flex-direction: column;">
            <label for="example-text-input" class="form-label">Ghi chú <span class="text text-danger">*</span></label>
            <textarea name="ghi_chu" id="" cols="30" rows="5" placeholder="Ghi chú"
                style="border-radius: 5px;border:1px solid var(--bs-input-border); padding:10px">{{ isset($vanban) ? $vanban->ghi_chu : old('ghi_chu') }}</textarea>
        </div>
<div>
        <div class="row">
            <div class="mb-3 mt-3">
                <label for="example-text-input" class="form-label">Đường dẫn <span class="text-danger">*</span></label>
                <input value="{{ old('duong_dan') }}"
                    class="form-control  {{ $errors->has('duong_dan') ? 'is-invalid' : '' }}" name="duong_dan"
                    type="file" id="example-text-input" placeholder="Đường dẫn" accept="application/pdf"
                    onchange="previewPDF(event)">
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
    </div>

