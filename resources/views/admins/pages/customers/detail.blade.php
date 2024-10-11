@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Chi tiết khách hàng - {{ $customer['info']['name'] }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                @foreach ($customer as $index => $customerItems)
                    <div class="card">
                        <div class="card-header">
                            <b>{{ $title_section[$index] }}</b>
                        </div>
                        <div class="card-body">
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($customerItems as $key => $infoItem)
                                <div class="row">
                                    <div class="col-lg-4">
                                        {{ ++$stt }}. {{ $config[$index][$key] }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ $infoItem }}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @php
                        $stt = 0;
                    @endphp
                @endforeach
                {{-- @if ($customer["info"])
                    <div class="card">
                        <div class="card-header">
                            <b>A. THÔNG TIN LIÊN HỆ</b>
                        </div>
                        <div class="card-body">
                            @php
                                $info_stt = 0;
                            @endphp
                            @foreach ($customer["info"] as $key => $infoItem)
                                <div class="row">
                                    <div class="col-lg-4">
                                        {{ ++$info_stt }}. {{ $config["info"][$key] }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ $infoItem }}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
                @if ($customer["overview"])
                    <div class="card">
                        <div class="card-header">
                            <b>B. TỔNG QUAN DỰ ÁN - MỤC TIÊU</b>
                        </div>
                        <div class="card-body">
                            @php
                                $overview_stt = 0;
                            @endphp
                            @foreach ($customer["overview"] as $key => $infoItem)
                                <div class="row">
                                    <div class="col-lg-4">
                                        {{ ++$overview_stt }}. {{ $config["overview"][$key] }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ $infoItem }}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif --}}
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection

