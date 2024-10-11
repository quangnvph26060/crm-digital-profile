<table id="tech-companies-1" class="table table-striped">
    <thead>
        <tr>
            <th style="text-align: center">STT</th>
            <th style="text-align: center">Ngày chi</th>
            <th data-priority="2">Khách hàng</th>
            <th data-priority="2">Nội dung phiếu chi</th>
            <th data-priority="3">Số tiền (VND)</th>
            <th data-priority="7" style="text-align: center">Hành động</th> <!-- Cột Hành động -->
        </tr>
    </thead>
    <tbody style="text-align: center">
        @php
            $start = ($paymentslips->currentPage() - 1) * $paymentslips->perPage() + 1;
        @endphp
        @foreach ($paymentslips as $key => $paymentslip)
            <tr>
                <td>{{ $key + $start }}</td>
                <td>{{ \Carbon\Carbon::parse($paymentslip->created_at)->format('H:i:s d/m/Y') }}</td>
                <td style="text-align: left;">
                    <a href="#" class="client-name"
                        data-id="{{ $paymentslip->client->id }}">{{ $paymentslip->client->name }}</a>
                </td>
                <td style="text-align: left;">{{ $paymentslip->note }}</td>
                <td style="text-align: left;">{{ number_format($paymentslip->amount) }}</td>
                <td> <!-- Thêm nút xuất PDF -->
                    <a href="{{ route('admin.paymentslip.export_pdf', ['id' => $paymentslip->id]) }}"
                        class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Xuất PDF
                    </a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-url="{{ route('admin.paymentslip.delete', ['id' => $paymentslip->id]) }}">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
            <td style="text-align: left; font-weight: bold;">{{ number_format($totalAmount) }}</td>
            <td></td> <!-- Ô trống cho cột Hành động -->
        </tr>
    </tbody>
</table>
