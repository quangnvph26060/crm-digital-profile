<table id="tech-companies-1" class="table table-bordered">
    <thead>
        <tr>
            <td style="border: 1px solid #000;text-align:center" rowspan="3">TT</td>
            <td style="border: 1px solid #000;text-align:center" rowspan="3">Họ và tên</td>
            <td style="text-align: center; border: 1px solid #000;" colspan="{{ count($period) }}">Ngày trong tháng (Từ ngày {{ date("d/m/Y", strtotime($date_start)) }} đến ngày {{ date("d/m/Y", strtotime($date_to)) }})</td>
            <td style="border: 1px solid #000;text-align:center;width: 200px" rowspan="3">Tổng cộng ngày công</td>
            <td style="border: 1px solid #000;text-align:center;width: 200px" rowspan="3">Tiền lương </td>
        </tr>
        <tr>
            @foreach ($period as $item)
                <td style="border: 1px solid #000;text-align:center">{{ $item->format("d") }}</td>
            @endforeach
        </tr>
        <tr>
            @foreach ($period as $item)
                <td style="border: 1px solid #000;text-align:center">{{ getDayOfWeek(date("l", strtotime($item))) }}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $totalAllDayWork = 0;
            $dataOverview = [];
        @endphp
        @foreach ($users as $key => $item)
            @php
                $totalDayWork = 0;
            @endphp
            <tr>
                <td style="border: 1px solid #000;text-align:center">{{ $key + 1 }}</td>
                <td style="border: 1px solid #000; width: 200px">{{ $item->full_name }}</td>
                @foreach ($period as $dateItem)
                    @php
                        if (empty($dataOverview[$dateItem->format("Y-m-d")])) {
                            $dataOverview[$dateItem->format("Y-m-d")] = 0;
                        }
                        $attendance = $item->attendances->whereBetween("checkin", [$dateItem->format("Y-m-d") . ' 00:00:00', $dateItem->format("Y-m-d") . ' 23:59:59'])->first();
                        if (!is_null($attendance)) {
                            $checkin = \Carbon\Carbon::parse($attendance['checkin']);
                            $diffMinute = $checkin->diffInMinutes($attendance['checkout']);
                            $dateCheckin = date("Y-m-d", strtotime($attendance['checkin']));
                        } else {
                            $diffMinute = 0;
                            $dateCheckin = "";
                        }

                    @endphp
                    <td style="border: 1px solid #000;text-align:center">
                        @if(strtotime($dateItem->format("Y-m-d")) == strtotime($dateCheckin))
                            @if($attendance['checkout'] != '' && $diffMinute/60 <= 4 )
                                @php
                                    $totalDayWork += 0.5;
                                    $totalAllDayWork += 0.5;
                                    $dataOverview[$dateCheckin] += 0.5;
                                @endphp
                                x/2
                            @elseif($attendance['checkout'] != '')
                                x
                                @php
                                    $totalDayWork += 1;
                                    $totalAllDayWork += 1;
                                    $dataOverview[$dateCheckin] += 1;
                                @endphp
                            @endif
                        @endif
                    </td>
                @endforeach
                <td style="border: 1px solid #000;text-align:center">
                    {{ $totalDayWork }}
                </td>
                <td style="border: 1px solid #000;text-align:center">
                    @php
                        $result_salary = $item->salary/26
                    @endphp
                        {{  number_format($result_salary * $totalDayWork, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #000;text-align:center" colspan="2">Tổng số</td>
            @foreach ($dataOverview as $number)
                <td style="border: 1px solid rgb(117, 97, 97);text-align:center">{{ $number }}</td>
            @endforeach
                <td style="border: 1px solid #000;text-align:center">{{ $totalAllDayWork }}</td>
        </tr>
    </tbody>
</table>

<style>
    table tr td {
        border: 1px solid #000;
    }
</style>
