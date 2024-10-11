@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Bảng chấm công</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<br>
<div class="row">
    <div class="col-lg-12">
        @include('globals.alert')
        <form method="GET">
            <div class="row">
                <div class="col-2">
                    <label for="">Từ ngày</label>
                    <input type="date" name="date_start" value="{{ isset($inputs['date_start']) ? $inputs['date_start'] : "" }}" class="form-control">
                </div>
                <div class="col-2">
                    <label for="">Đến ngày</label>
                    <input type="date" name="date_end" value="{{ isset($inputs['date_end']) ? $inputs['date_end'] : "" }}" class="form-control">
                </div>
                <div class="col-3">
                    <label for="" style="opacity: 0">sadsd</label> <br>
                    <button class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ url()->current() }}" class="btn btn-danger">Reload</a>
                </div>
            </div>
        </form>
        <br>
        <div class="card card-h-100">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày</th>
                            <th>Thứ</th>
                            <th>Vào</th>
                            <th>Ra</th>
                            <th>Mô tả</th>
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
                                <td>
                                    <b>{{ date("H:i", strtotime($item->checkin)) }}</b>
                                </td>
                                <td style="color: red">
                                    <b>{{ !empty($item->checkout) ? date("H:i", strtotime($item->checkout)) : ""}}</b>
                                </td>
                                <td style="width: 20%">
                                    <form id="noteForm-{{$item->user_id}}" action="{{ route('customer.attendance.update-note') }}" method="POST">
                                        @csrf
                                        <textarea class="main_note"  data-check-in="{{ $item->checkin }}" name="note" id="" cols="40" rows="3" placeholder="Chú thích...">{{$item->note}}</textarea>
                                        <input type="hidden" name="check_in" class="check-in-field" value="{{ $item->checkin }}">
                                    </form>
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
                {{ $logs->appends($inputs)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('textarea[name="note"]').forEach(function(textarea) {
            let timeout = null;
            textarea.addEventListener('input', function() {
                clearTimeout(timeout); 
                const form = this.closest('form');
                const checkInValue = this.getAttribute('data-check-in');
                timeout = setTimeout(function() {
                    console.log('Submitting form with note:', textarea.value);
                    console.log('Check-in time:', checkInValue);
                    form.submit();
                }, 2000); // 2s
            });
        });
    });
</script>
<style scoped>
    .main_note{
        border: 1px solid var(--bs-border-color);
    }
</style>