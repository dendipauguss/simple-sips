@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <div class="me-auto">
                                <h3 class="h4 m-0">Selamat datang {{ auth()->user()->nama }}</h3>
                            </div>
                        </div>

                        <!-- Network - Area Chart -->
                        <div class="card-body py-0" style="height: 250px; max-height: 275px">

                        </div>
                        <!-- END : Network - Area Chart -->\
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
