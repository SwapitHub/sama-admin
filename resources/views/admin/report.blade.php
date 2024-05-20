@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Reports
                                <small>Diamond Admin Panel</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('dashboard') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $users->options['chart_title'] }}</h5>
                        </div>
                        <div class="card-body sell-graph">
                            {{-- <canvas id="myGraph"></canvas> --}}
                            {!! $users->renderHtml() !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card report-employee">
                        <div class="card-header">
                            
                            <h6 class="mb-0"> {{ $users->options['chart_title'] }}</h6>
                        </div>
                        <div class="card-body p-0">
                            {!! $user_this_month->renderHtml() !!}
                        </div>
                    </div>
                </div> 
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $transaction->options['chart_title'] }}</h5>
                        </div>
                        <div class="card-body expense-chart">
                            {{-- <div class="chart-overflow" id="area-chart1"></div> --}}
                            {!! $transaction->renderHtml() !!}
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-6"> --}}
                    {{-- <div class="card">
                        <div class="card-header">
                            <h5> Sales / Purchase</h5>
                        </div>
                        <div class="card-body">
                            <div class="sales-chart"></div>
                            
                        </div>
                    </div> --}}
                {{-- </div> --}}
                <div class="col-sm-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $users_order->options['chart_title'] }}</h5>
                        </div>
                        <div class="card-body sell-graph">
                            {{-- <canvas id="myLineCharts1"></canvas> --}}
                            {!! $users_order->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    @push('scripts')
    {!! $users->renderChartJsLibrary() !!}
    {!! $users->renderJs() !!}
    {!! $transaction->renderJs() !!}
    {!! $user_this_month->renderJs() !!}
    {!! $users_order->renderJs() !!}
    @endpush
@endsection
