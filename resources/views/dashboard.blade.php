@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status Pengenaan</h5>
                            <!-- Pie Chart -->
                            <canvas id="_dm-pieChart" width="464" height="463"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"
                                data-status='@json($status_data)'></canvas>
                            <!-- END : Pie Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status </h5>
                            <!-- Pie Chart -->
                            <canvas id="_dm-lineChart" width="464" height="463"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"></canvas>
                            <!-- END : Pie Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pie chart</h5>
                            <!-- Pie Chart -->
                            <canvas id="_dm-barChart" width="464" height="463"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"></canvas>
                            <!-- END : Pie Chart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
