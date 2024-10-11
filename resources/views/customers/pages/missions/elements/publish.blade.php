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
                    <th style="text-align: center" data-priority="1">Trao đổi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($missions as $date => $missionGroup)
                    @if (count($missionGroup->where('status', 3)) > 0)
                        <tr style="background: #ccc">
                            <td colspan="7" align="center">
                                <b>
                                    {{ date("d/m/Y", strtotime($date)) }}
                                </b>
                            </td>
                        </tr>
                        @foreach ($missionGroup->where('status', 3) as $key => $missionItem)
                                @if (!is_null($missionItem->deadline_publish) && strtotime($missionItem->deadline_publish) < strtotime(date("Y-m-d")))
                                    <tr
                                        style="color: #fff; background: red"
                                    >
                                @else
                                    <tr>
                                @endif
                                <td align="center">{{ $key + 1 }}</td>
                                <td>
                                    {{ !empty($missionItem->project) ? $missionItem->project->name : "" }}
                                </td>
                                <td style="width: 30%">
                                    {{ !empty($missionItem->project) ? $missionItem->project->description : "" }}
                                </td>
                                <td>{{ $missionItem->keyword }}</td>
                                <td>
                                    {{ !is_null($missionItem->deadline_publish) ? date("d/m/Y", strtotime($missionItem->deadline_publish)) : "" }}
                                </td>
                                <td>
                                    @if (!empty($missionItem->url))
                                        <a href="{{ $missionItem->url }}" target="_blank">
                                            Xem bài viết
                                        </a>
                                    @endif
                                    @if (!empty($missionItem->url_publish))
                                        <a target="_blank" href="{{$missionItem->url_publish}}">
                                            Truy cập ngay
                                        </a>
                                    @else
                                        <form action="{{route('customer.mission.update', ['id' => $missionItem->id, 'status' => 5])}}" method="POST">
                                            @csrf
                                            <input required placeholder="Nhập link đã publish" name="url_publish" type="text" class="form-control"><br>
                                            <button class="btn btn-success">
                                                Xác nhận publish
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td align="center">
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
