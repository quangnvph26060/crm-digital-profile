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
                        class="form-select {{ $errors->has('config_id ') ? 'is-invalid' : '' }}"
                        name="config_id" id="agency_code-select">
                        <option value="">Chọn mã cơ quan</option>
                        @foreach ($macoquan as $item)
                            <option value="{{ $item->id }}"
                                {{(isset($profile) ?  $profile->config_id :  old('config_id') == $item->id) == $item->id ? 'selected' : '' }}>
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
                        class="form-select {{ $errors->has('ma_muc_luc') ? 'is-invalid' : '' }}"
                        name="ma_muc_luc" id="agency_code-select">
                        <option value="">Chọn mã mục lục</option>
                        @foreach ($mamucluc as $item)
                            <option value="{{ $item->id }}"
                                {{(isset($profile) ?  $profile->ma_muc_luc :  old('ma_muc_luc') == $item->id) ? 'selected' : '' }}>
                                {{ $item->ten_mucluc }}
                            </option>
                        @endforeach
                    </select>
                    @error('ma_muc_luc')
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
                    <input value="{{isset($profile) ?  $profile->hop_so : old('hop_so') }}"
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
                    <input value="{{ isset($profile) ?  $profile->ho_so_so : old('ho_so_so') }}"
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
                    <input value="{{isset($profile) ?  $profile->thbq :  old('thbq') }}"
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
                    <input value="{{ isset($profile) ?  date('Y-m-d', strtotime($profile->ngay_bat_dau)) : old('ngay_bat_dau') }}"
                        class="form-control {{ $errors->has('ngay_bat_dau') ? 'is-invalid' : '' }}"
                        name="ngay_bat_dau" type="date" id="date_start-text-input">
                    @error('ngay_bat_dau')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class=" col-lg-6 mb-3">
                    <label for="date_end-text-input" class="form-label">Ngày kết thúc
                        <span class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  date('Y-m-d', strtotime($profile->ngay_ket_thuc)) : old('ngay_ket_thuc') }}"
                        class="form-control {{ $errors->has('ngay_ket_thuc') ? 'is-invalid' : '' }}"
                        name="ngay_ket_thuc" type="date" id="date_end-text-input">
                    @error('ngay_ket_thuc')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-3">
                    <label for="example-text-input" class="form-label"> demo quang<span
                            class="text text-danger">*</span></label>
                    <input value="{{ isset($profile) ?  $profile->demo_quang : old('demo_quang')   }}"
                        class="form-control {{ $errors->has('thbq') ? 'is-invalid' : '' }}"
                        name="demo_quang" type="text" id="example-text-input"
                        placeholder="THBQ">
                    @error('thbq')
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
                    style="border-radius: 5px;border:1px solid var(--bs-input-border);">{{isset($profile) ?  $profile->ghi_chu: old('ghi_chu') }}</textarea>
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