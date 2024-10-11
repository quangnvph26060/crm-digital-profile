@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Thông tin khách hàng</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<br>
<div class="row">
    <div class="col-lg-12">
        @include('globals.alert')
        <p>
            <a class="btn btn-primary" href="{{ route('customer.create') }}">Thêm mới</a>
        </p>
        <div class="card card-h-100">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Lĩnh vực</th>
                            <th>Website</th>
                            <th>Fanpage</th>
                            <th>Nội dung tư vấn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $item)
                            @php
                                $data = json_decode($item->content, true);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $data["info"]["name"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["phone"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["email"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["position"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["website"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["fanpage"] }}
                                </td>
                                <td>
                                    {{ $data["info"]["content"] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
