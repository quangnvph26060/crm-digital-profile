@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Danh sách khách hàng</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        @include('globals.alert')
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Khách hàng</th>
                                            <th>SĐT</th>
                                            <th>Email</th>
                                            <th>Nội dung tư vấn</th>
                                            <th>User</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $item)
                                            @php
                                                $data = json_decode($item->content, true);
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $data["info"]["name"] }}
                                                    </p>
                                                    @if (!empty($item->user_id))
                                                        @if(!empty($data["info"]["position"]))
                                                            <p>
                                                                Lĩnh vực: <b>{{ $data["info"]["position"] }}</b>
                                                            </p>
                                                        @endif
                                                        @if(!empty($data["info"]["website"]))
                                                            <p>
                                                                Website: <b>{{ $data["info"]["website"] }}</b>
                                                            </p>
                                                        @endif
                                                        @if(!empty($data["info"]["fanpage"]))
                                                            <p>
                                                                Fanpage: <b>{{ $data["info"]["fanpage"] }}</b>
                                                            </p>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $data["info"]["phone"] }}
                                                </td>
                                                <td>
                                                    {{ $data["info"]["email"] }}
                                                </td>
                                                <td style="width: 150px">
                                                    @if(!empty($data["info"]["content"]))
                                                        {{ $data["info"]["content"] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ !empty($item->user) ? $item->user->full_name : "" }}
                                                </td>
                                                <td>
                                                    @if (empty($item->user_id))
                                                    <a class="btn btn-success" href="{{ route('detail-customer', ['id' => $item->id]) }}">
                                                        Xem ngay
                                                    </a>
                                                    @endif
                                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger" href="{{ route('delete-customer', ['id' => $item->id]) }}" href="">
                                                        Xóa
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection

