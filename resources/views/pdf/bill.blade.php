<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BÁO GIÁ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffffff;
            font-family: DejaVu Sans, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
            /* margin-left: 30; */
            margin-right: 30;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            /* Reduced gap */
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 10px;
        }

        .header-table .logo {
            width: 30%;
            text-align: left;
        }

        .header-table .company-info {
            width: 70%;
            text-align: left;
        }

        /* Ẩn viền bảng */
        .header-table,
        .header-table tr,
        .header-table td {
            border: none;
        }

        .company-info p {
            margin: 2px 0;
            font-size: 12px;
        }

        .company-info p strong {
            color: #0d47a1;
            display: block;
            font-size: 14px;
        }

        h2 {
            font-size: 20px;
            color: #0d47a1;
            text-transform: uppercase;
            margin: 20px 0;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .info-table td {
            padding: 2px 0;
            /* Reduced padding to decrease row height */
            font-size: 12px;
            vertical-align: top;
            border: none;
        }

        .info-table td:first-child {
            width: 120px;
            /* Adjust this value as needed */
            white-space: nowrap;
            /* Prevents the text from wrapping */
        }

        .info-table strong {
            color: #0d47a1;
            display: block;
        }


        .separator {
            height: 2px;
            background-color: #0d47a1;
            margin-top: 10px;
            margin-bottom: 10px
        }

        .table-detail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        .table-detail th,
        .table-detail td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .table-detail th {
            background-color: #0d47a1;
            color: #ffffff;
            text-align: center;
        }

        .total-section {
            text-align: right;
            font-size: 12px;
            color: #0d47a1;
            margin-top: 10px;
            /* font-weight: bold; */
            margin-bottom: 10px;
        }

        .payment-info ul {
            font-style: italic;
            list-style-type: disc;
            padding-left: 20px;
            margin-top: 10px;
            font-size: 12px;
            color: #000;
            text-align: left;
        }

        .payment-info ul li {
            margin-bottom: 10px;
            font-style: italic;
        }

        .payment-info strong {
            color: #0d47a1;
        }

        .signature-box {
            display: inline-block;
            width: 300px;
            padding: 20px;
            text-align: center;
            color: #333;
            margin-top: 20px;
            float: right;
        }

        .signature-box p {
            margin: 10px 0;
            font-size: 12px;
        }

        .content {
            padding: 30px;
            padding-top: 10px;
            margin-top: -30px;
            /* Optional: adjust if you need more control */
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 200px;">
                </td>
                <td class="company-info">
                    <p><strong>CÔNG TY CP CÔNG NGHỆ VÀ TRUYỀN THÔNG SGO VIỆT NAM</strong></p>
                    <p>Địa chỉ: Tầng 12 Tòa nhà Licogi 13, số 164 Khuất Duy Tiến, P.Nhân Chính, Q.Thanh Xuân, TP. Hà
                        Nội</p>
                    <p>Điện thoại: 0246.29.27.089 - 0912.399.322 – 0981.185.620</p>
                    <p>Website: sgomedia.vn / info@sgomedia.vn</p>
                </td>
            </tr>
        </table>

        <div class="content">
            <h2>BÁO GIÁ DỊCH VỤ</h2>
            <p style="margin-top: -15px; font-size: 12px;"><i>(Số:
                    {{ Carbon\Carbon::now()->format('m') }}.{{ Carbon\Carbon::now()->format('Y') }}.{{ $invoice_number }})</i>
            </p>

            <div class="separator"></div>

            <table class="info-table">
                <tr>
                    <td><strong>Tên khách hàng:</strong></td>
                    <td>{{$client_name}}</td>
                </tr>
                <tr>
                    <td><strong>Tên đơn vị:</strong></td>
                    <td>{{$client_company ?? ''}}</td>
                </tr>
                <tr>
                    <td><strong>Địa chỉ:</strong></td>
                    <td>{{$client_address}}</td>
                </tr>
                <tr>
                    <td><strong>Mã số thuế:</strong></td>
                    <td>{{$client_tax_number ?? ''}}</td>
                </tr>
                <tr>
                    <td><strong>Điện thoại:</strong></td>
                    <td>{{$client_phone}}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{$client_email}}</td>
                </tr>
            </table>

            <table class="table-detail">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên hàng hóa, dịch vụ</th>
                        <th>ĐVT</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td style="text-align: center">{{ $index + 1 }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td style="text-align: center">{{ $item['unit'] }}</td>
                            <td style="text-align: center">{{ $item['quantity'] }}</td>
                            <td style="text-align: right">{{ number_format($item['unit_price'], 0, ',', '.') }}</td>
                            <td style="text-align: right">
                                {{ number_format($item['quantity'] * $item['unit_price'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <p><strong>Cộng tiền hàng hóa, dịch vụ:</strong> {{ number_format($subtotal, 0, ',', '.') }}</p>
                <p>Thuế GTGT ({{ $tax }}%): {{ number_format($tax_money, 0, ',', '.') }}
                </p>
                <p><strong>Tổng tiền thanh toán:</strong> {{ number_format($total, 0, ',', '.') }}</p>
            </div>

            <div class="payment-info">
                <ul>
                    <li>Báo giá đã bao gồm VAT</li>
                    <li>Thanh toán: Tiền mặt / Chuyển khoản:
                        <ul>
                            <li><strong>KH lấy hóa đơn:</strong> Công Ty Cp Công Nghệ Và Truyền Thông Sgo Việt Nam –
                                19134495685011 – Techcombank</li>
                            <li><strong>KH không lấy hóa đơn:</strong> Nguyễn Khắc Thuật – Ngân hàng PGBank –
                                1201238777999</li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="signature-box">
                <p>Hà Nội, ngày {{ Carbon\Carbon::now()->format('d') }} tháng {{ Carbon\Carbon::now()->format('m') }}
                    năm {{ Carbon\Carbon::now()->format('Y') }}</p>
                <p><strong>ĐƠN VỊ BÁO GIÁ</strong></p>
                <br><br>
                <p><strong>CÔNG TY SGO VIỆT NAM</strong></p>
            </div>
        </div>
    </div>
</body>

</html>
