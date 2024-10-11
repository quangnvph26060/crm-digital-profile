<div class="table-rep-plugin">
    <div class="table-responsive mb-0" data-pattern="priority-columns">
        <table id="tech-companies-1" class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th data-priority="2">Họ tên</th>
                    <th data-priority="3">Email</th>
                    <th data-priority="3">Số điện thoại</th>
                    <th data-priority="6">Tên công ty</th>
                    <th>Mã số thuế</th>
                    <th>Nguồn</th>
                    <th style="text-align: center" data-priority="7">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $start = ($clients->currentPage() - 1) * $clients->perPage() + 1;
                @endphp
                @foreach ($clients as $key => $client)
                    <tr>
                        <td>{{ $key + $start }}</td>
                        <td style="text-align: left;">
                            <a href="#" class="client-name" data-id="{{ $client->id }}">{{ $client->name }}</a>
                        </td>
                        <td>{{ $client->email ?? 'Chưa có email' }} </td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->company_name ?? 'Chưa có tên công ty' }} </td>
                        <td>{{ $client->tax_number ?? 'Chưa có mã số thuế' }}</td>
                        <td>
                            @switch($client->source)
                                @case(0)
                                    Thêm thủ công
                                @break

                                @case(1)
                                    Link đăng ký miễn phí
                                @break

                                @default
                            @endswitch
                        </td>
                        <td style="text-align: center">
                            <a href="javascript:void(0)" data-id="{{ $client->id }}"
                                class="btn btn-warning open-edit-modal">Sửa</a>
                            <a href="#" data-url="{{ route('admin.client.delete', ['id' => $client->id]) }}"
                                class="btn btn-danger btn-delete">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
