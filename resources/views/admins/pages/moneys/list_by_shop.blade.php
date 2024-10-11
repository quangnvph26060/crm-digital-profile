@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Yêu cầu nạp tiền của bạn</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Ngày nạp</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Tên người nạp</label>
                                        <input value="{{isset($inputs['name']) ? $inputs['name'] : ''}}" autocomplete="off" name="name" placeholder="Tên, mã nhân viên" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="" style="opacity: 0">1</label><br>
                                        <button class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <button class="btn btn-success waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-plus"></i> Nạp tiền</button>
                                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fas fa-history"></i> Tải lại</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{route('admin.money.put-money')}}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Thông tin nạp tiền</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Email cần nạp <span class="text text-danger">*</span></label>
                                            <input required name="email" type="email" value="{{old('email')}}" class="form-control">
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="">Số tiền cần nạp <span class="text text-danger">*</span></label>
                                            <input required type="text" name="money" data-type='currency' class="form-control">
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="">Ghi chú</label>
                                            <textarea name="note" class="form-control" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button> --}}
                                        <button type="submit" name="submit" value="save" class="btn btn-primary">Xác nhận lưu</button>
                                        <button type="submit" name="submit" value="save-and-accept" class="btn btn-success">Xác nhận lưu & Duyệt</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-example-modal-center" id="bill" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('globals.alert')
                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Hóa đơn</th>
                                            <th data-priority="1">Shop</th>
                                            <th>Người tạo</th>
                                            <th data-priority="2">Số tiền</th>
                                            <th>Số dư</th>
                                            <th data-priority="3">Ngày nạp</th>
                                            <th>Ngày duyệt</th>
                                            <th data-priority="6">Trạng thái</th>
                                            <th data-priority="7">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listPutMoney as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    @if($item->image != '')
                                                        <img style="cursor: pointer" class="bill" data-bs-toggle="modal" data-bs-target="#bill" width="50px" src='{{asset("uploads/bills/$item->image")}}' alt="">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.user.shop.list', ['name' => $item->shop->full_name])}}">{{$item->shop->full_name}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.user.shop.list', ['name' => $item->shop->full_name])}}">{{($item->user_id != '' && !empty($item->user)) ? $item->user->full_name : ''}}</a>
                                                </td>
                                                <td align="right">
                                                    <b>{{number_format($item->money)}} vnđ</b>
                                                </td>
                                                <td align="right">
                                                    <b>{{number_format($item->shop->balance)}} vnđ</b>
                                                </td>
                                                <td>{{$item->created_at->format('d/m/Y')}}</td>
                                                <td>
                                                    @if ($item->date_accept != '')
                                                    {{date('d/m/Y', strtotime($item->date_accept))}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->status)
                                                        <span class="badge bg-success">Đã duyệt</span>
                                                    @else
                                                        <span class="badge bg-danger">Chưa duyệt</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.money.accept', ['id' => $item->id])}}" class="confirm btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Duyệt">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="{{route('admin.money.reject', ['id' => $item->id])}}" class="confirm btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Từ chối">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                    <a href="{{route('admin.money.delete', ['id' => $item->id])}}" class="confirm btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Xóa">
                                                        <i class="fas fa-trash"></i>
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

@section('scripts')
    <script>
        $(function() {
            $('.bill').click(function() {
                var src = $(this).attr('src');
                $('#bill img').attr('src', src);
            })
        })
    </script>
@endsection