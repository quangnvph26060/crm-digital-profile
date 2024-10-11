<div class="table-rep-plugin">
    <div class="table-responsive mb-0" data-pattern="priority-columns">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dự án</th>
                    <th>Mô tả</th>
                    <th data-priority="1">Từ khóa</th>
                    <th>Ngày hết hạn</th>
                    <th data-priority="3">Url bài viết</th>
                    <th style="center" data-priority="1">Trao đổi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($missions as $date => $missionGroup)
                    @if (count($missionGroup->where('status', 2)) > 0)
                        <tr style="background: #ccc">
                            <td colspan="7" align="center">
                                <b>
                                    {{ date("d/m/Y", strtotime($date)) }}
                                </b>
                            </td>
                        </tr>
                        @foreach ($missionGroup->where('status', 2) as $key => $missionItem)
                                @if (!is_null($missionItem->deadline_edit) && strtotime($missionItem->deadline_edit) < strtotime(date("Y-m-d")))
                                    <tr
                                        style="color: #fff; background: red"
                                    >
                                @else
                                    <tr>
                                @endif
                                <td align="center">{{ $key + 1 }}</td>
                                <td>
                                    {{!empty($missionItem->project) ? $missionItem->project->name : "" }}
                                </td>
                                <td style="width: 30%">
                                    {{ !empty($missionItem->project) ? $missionItem->project->description : "" }}
                                </td>
                                <td>{{ $missionItem->keyword }}</td>
                                <td>
                                    {{ !is_null($missionItem->deadline_edit) ? date("d/m/Y", strtotime($missionItem->deadline_edit)) : "" }}
                                </td>
                                <td>
                                    <a href="{{ $missionItem->url }}" target="_blank">
                                        Xem ngay
                                    </a>
                                </td>
                                <td align="center">
                                    <form action="{{route('customer.mission.update', ['id' => $missionItem->id, 'status' => 4])}}" method="POST">
                                        @csrf
                                        <button class="btn btn-success">
                                            Xác nhận đã sửa
                                        </button>
                                    </form>
                                    <button onclick="openModel({{$missionItem->id}}, '{{$missionItem->keyword}}')" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">
                                        Trao đổi
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>
