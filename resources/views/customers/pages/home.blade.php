@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Biểu đồ tổng quan tháng {{$month}}/{{$year}}</h4>
        </div>
    </div>
    <div class="col-lg-12">
        <form method="GET">
            <div class="row">
                <div class="col-lg-2 form-group">
                    <select name="month" id="" class="form-control">
                        @for ($i = 1; $i < 13; $i++)
                            <option @if($i == $month){{'selected'}}@endif value="{{$i}}">Tháng {{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-2 form-group">
                    <select name="year" id="" class="form-control">
                        @for ($y = 2023; $y <= date('Y'); $y++)
                            <option @if($y == $year){{'selected'}}@endif value="{{$y}}">Năm {{$y}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-2 form-group">
                    <button type="submit" class="btn btn-success">Lọc</button>
                </div>
            </div>
        </form>
        <div id="chart-container">

        </div>
    </div>
</div>
<style>
    #chart-container {
        position: relative;
        height: 500px;
        margin: auto;
        width: 100%;
        overflow: hidden;
    }
</style>
@endsection

@section('scripts')
<script src="https://fastly.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
<script>
    var dom = document.getElementById('chart-container');
    var range_day = [];
    var series = [];
    @foreach ($range_day as $dateItem)
        range_day.push("{{$dateItem->format('d/m/Y')}}")
    @endforeach
    @foreach ($series as $seriItem)
        series.push({
            name: "{{$seriItem['name']}}",
            type: "bar",
            data: JSON.parse("{{json_encode($seriItem['data'])}}")
        })
    @endforeach
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
            type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
            type: 'category',
            data: range_day,
            axisTick: {
                alignWithLabel: true
            }
            }
        ],
        yAxis: [
            {
            type: 'value'
            }
        ],
        series: series
    };


    if (option && typeof option === 'object') {
    myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
@endsection
