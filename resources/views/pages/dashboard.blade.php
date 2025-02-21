@extends('layouts.master')

@section('datefilter')
@include('pages.list-filter',['functionName'=>'getStatisticsForDashBoard'])
@endsection


@section('title')
{{ __('dashboard.Dashboard') }}
@endsection

@section('content')

    <div class="dashboard-mt" id="searchable">
        <div id="row1">
        @include('pages.ajax-dashboard')
    </div>
    <div class="chartsection">
        @if(!$flag && count($result['monthlySales'])>0)
            <div style="width: 80%; margin: auto;">
    <canvas id="monthlySalesChart"></canvas>
</div>    
@endif
    </div>
    <div id="row2">
        @include('pages.ajax-dashboard-latest')
    </div>
    </div>


@endsection
