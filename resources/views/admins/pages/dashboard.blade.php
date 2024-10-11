@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <form method="GET">
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <input name="date" class="form-control" type="date" value="{{$date}}">
                        </div>
                        <div class="col-lg-2 form-group">
                            <button type="submit" class="btn btn-success">Lọc</button>
                        </div>
                    </div>
                </form>
                <div id="chart-container">

                </div>
            </div>
        </div><!-- end row-->
    </div>
    <!-- container-fluid -->
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
    var user = [];
    var data = [];
    @foreach ($xAxis as $name)
        user.push("{{$name}}")
    @endforeach
    @foreach ($yAxis as $percent)
        data.push("{{$percent}}")
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
                data: user,
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
        series: [
            {
                data: data,
                type: 'bar',
                showBackground: true,
                backgroundStyle: {
                    color: 'rgba(180, 180, 180, 0.2)'
                }
            }
        ]
    };


    if (option && typeof option === 'object') {
    myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
@endsection
