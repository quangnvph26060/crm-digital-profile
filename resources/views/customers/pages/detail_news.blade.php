@extends('customers.layouts.index')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-lg-12">
        <div id="chart-container">
            <div class="row">
                <div class="col-lg-8">
                    <h3>
                        {{ $news->title }}
                    </h3>
                    <div>
                        {!! str_replace("\n", "<br>", $news->content) !!}
                    </div>
                </div>
            </div>
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
