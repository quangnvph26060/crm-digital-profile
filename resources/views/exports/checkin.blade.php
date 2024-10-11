<table id="tech-companies-1" class="table table-striped">
    <thead>
        <tr>
            <td colspan="7" style="text-align: center">
                GIỜ CHẤM CÔNG
            </td>
        </tr>
        @if ($date_start != "" && $date_to != "")
            <tr>
                <td colspan="7" style="text-align: center">
                    Từ ngày {{ date("d/m/Y", strtotime($date_start)) }} đến ngày {{ date("d/m/Y", strtotime($date_to)) }}
                </td>
            </tr>
        @endif
        <tr>
            <th>STT</th>
            <th>Ngày</th>
            <th>Thứ</th>
            <th>Nhân viên</th>
            <th>Vào</th>
            <th>Ra</th>
            <th>Tổng giờ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $item)
            @php
                $checkin = \Carbon\Carbon::parse($item->checkin);
                $diffMinute = $checkin->diffInMinutes($item->checkout);
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ date("d/m/Y", strtotime($item->checkin)) }}</td>
                <td>{{ getDayOfWeek(date("l", strtotime($item->checkin))) }}</td>
                <td>{{ !empty($item->user) ? $item->user->full_name : "" }}</td>
                <td>
                    <b>{{ date("H:i", strtotime($item->checkin)) }}</b>
                </td>
                <td style="color: red">
                    <b>{{ !empty($item->checkout) ? date("H:i", strtotime($item->checkout)) : ""}}</b>
                </td>
                <td>
                    @if(!empty($item->checkout))
                        {{ number_format($diffMinute/60, 2) }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
