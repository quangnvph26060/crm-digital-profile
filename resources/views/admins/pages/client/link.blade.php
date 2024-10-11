<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận Website Miễn Phí</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 4px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Đảm bảo tiêu đề luôn nằm trên một dòng và căn giữa */
        .form-container h2 {
            text-align: center;
            white-space: nowrap;
            /* Ngăn dòng chữ xuống dòng */
            overflow: hidden;
            /* Ngăn không cho văn bản vượt ra ngoài vùng hiển thị */
            text-overflow: ellipsis;
            /* Hiển thị dấu ba chấm nếu văn bản dài hơn vùng hiển thị */
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Nhận Website Miễn Phí</h2>
            <form id="add-client-form" action="{{ route('admin.client.storeByLink') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div id="name-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                    <div id="phone-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div id="email-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="field" class="form-label">Ngành nghề <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="field" name="field" required>
                    <div id="field-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="company_name" class="form-label">Tên công ty</label>
                    <input type="text" class="form-control" id="company_name" name="company_name">
                    <div id="company_name-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="tax_number" class="form-label">Mã số thuế</label>
                    <input type="text" class="form-control" id="tax_number" name="tax_number">
                    <div id="tax_number-error" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="address" name="address" required>
                    <div id="address-error" class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            $(document).ready(function() {
                toastr.success('{{ session('success') }}');
            });
        @endif
    </script>
</body>

</html>
