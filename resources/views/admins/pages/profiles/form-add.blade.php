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