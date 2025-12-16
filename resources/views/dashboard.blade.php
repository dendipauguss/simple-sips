@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status Tanggapan Terhadap Sanksi</h5>
                            <!-- Status Chart -->
                            <canvas id="_dm-pieChart" width="464" height="463"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"
                                data-status='@json($pie_data)'></canvas>
                            <!-- END : Status Chart -->
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Pelanggaran</h5>
                            <!-- Bar Chart -->
                            <canvas id="_dm-barChart" width="464" height="215"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"
                                data-labels='@json($labels)' data-sudah='@json($sudah)'
                                data-belum='@json($belum)'></canvas>
                            <!-- END : Bar Chart -->
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">By Kategori</h5>
                            <div class="row mb-1 justify-content-start">
                                <div class="col-sm-3 ms-0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showAllLabel">
                                        <label class="form-check-label">
                                            Tampilkan semua label
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4 ms-0">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="stackedMode">
                                        <label class="form-check-label">Tampilan Stacked/Menumpuk</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <select id="groupBy" class="form-select form-select-sm mb-2">
                                    <option value="jenis_pelanggaran">Jenis Pelanggaran</option>
                                    <option value="sanksi">Sanksi</option>
                                    <option value="jenis_pelaku_usaha">Jenis Pelaku Usaha</option>
                                    <option value="pelaku_usaha">Pelaku Usaha</option>
                                    <option value="kategori_sp">Kategori Sanksi</option>
                                </select>
                            </div>
                            <div id="chartLoading" class="position-absolute top-50 start-50 translate-middle d-none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <!-- Bar Chart -->
                            <canvas id="_dm-barChart-1" width="464" height="215"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"
                                data-labels='@json($labels)' data-sudah='@json($sudah)'
                                data-belum='@json($belum)'></canvas>
                            <!-- END : Bar Chart -->
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status </h5>
                            <!-- Pie Chart -->
                            <canvas id="_dm-lineChart" width="464" height="463"
                                style="display: block; box-sizing: border-box; height: 370.4px; width: 371.2px;"></canvas>
                            <!-- END : Pie Chart -->
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    @endsection
