<div class="card">
    <div class="card-header">
        <h4 class="card-title">Thông tin khách hàng</h4>
    </div>
    <div class="card-body p-4">
        <!-- Tìm kiếm khách hàng -->
        <div class="form-group position-relative">
            <label for="search">Tìm kiếm khách hàng:</label>
            <div class="search-container">
                <input type="text" id="search" class="form-control"
                    placeholder="Nhập tên, số điện thoại, hoặc email khách hàng...">
                <span id="open-add-modal" class="search-icon">
                    <i class="fas fa-plus"></i>
                </span>
            </div>
        </div>

        <!-- Kết quả tìm kiếm -->
        <ul id="results" class="list-group mt-2" style="display: none;">
            <li class="no-results" style="display: none;">Không có kết quả phù hợp</li>
        </ul>

        <!-- Thông tin khách hàng -->
        <div class="form-group mt-3">
            <label class="customer-label">Tên khách hàng:</label>
            <div id="customer-info-name"></div>
        </div>

        <div class="form-group">
            <label class="customer-label">Số điện thoại:</label>
            <div id="customer-info-phone"></div>
        </div>

        <div class="form-group">
            <label class="customer-label">Địa chỉ:</label>
            <div id="customer-info-address"></div>
        </div>

        <div class="form-group">
            <label class="customer-label">Email:</label>
            <div id="customer-info-email"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Thêm khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-client-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div id="name-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div id="email-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                        <div id="phone-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Tên công ty</label>
                        <input type="text" class="form-control" id="company_name" name="company_name">
                        <div id="company_name-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="field" class="form-label">Ngành nghề</label>
                        <input type="text" class="form-control" id="field" name="field">
                        <div id="field-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tax_number" class="form-label">Số thuế</label>
                        <input type="text" class="form-control" id="tax_number" name="tax_number">
                        <div id="tax_number-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address">
                        <div id="address-error" class="invalid-feedback"></div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button> --}}
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-group {
        position: relative;
    }

    .search-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    #search {
        padding-right: 40px;
        /* Đảm bảo có đủ không gian cho dấu cộng */
        flex: 1;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        /* Khoảng cách từ bên phải của ô tìm kiếm */
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        /* Kích thước của dấu cộng */
        color: #007bff;
        /* Màu của dấu cộng */
        cursor: pointer;
        z-index: 1;
        /* Đảm bảo dấu cộng nằm trên ô tìm kiếm */
    }

    .search-container .form-control {
        padding-right: 40px;
        /* Căn chỉnh khoảng cách cho dấu cộng */
    }
</style>
