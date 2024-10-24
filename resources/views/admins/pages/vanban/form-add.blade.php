<input value="{{ isset($vanban) ? $vanban->tac_gia : old('tac_gia') }}"
                    class="form-control {{ $errors->has('tac_gia') ? 'is-invalid' : '' }}" name="tac_gia" type="text"   id="example-text-input" placeholder="Tác giả văn bản">
<div class="col-lg-12 mt-4">
    <div>
        <button type="submit" class="btn btn-primary w-md">Xác nhận</button>
    </div>
</div>