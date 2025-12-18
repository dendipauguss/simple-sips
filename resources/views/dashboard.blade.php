@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row justify-content-center">
                <div class="col-xl-2">
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
                <div class="col-xl-8">
                    {{-- 
                        <div class="card mb-1">
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
                     --}}

                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Pengenaan Sanksi Tiap Bulan</h5>
                            <!-- Stacked chart -->
                            <div style="height: 300px;">
                                <canvas id="_dm-stackChart" data-stack='@json($sanksi_per_periode)'></canvas>
                            </div>
                            <!-- END : Stacked chart -->
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Top 5 Perusahaan Penerima Sanksi</h5>
                            <div class="row justify-content-between">
                                @foreach ($top_pelaku as $item)
                                    <div class="col d-flex">
                                        <div class="card bg-warning mb-3 mb-md-3 text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="h2 mb-0">{{ $item->total_sanksi }}</h5>
                                                        <strong class="mb-0">{{ $item->nama }}</strong>
                                                    </div>
                                                </div>
                                                <div class="d-block align-items-center ms-3">
                                                    <div class="badge bg-success me-1">
                                                        Sudah Ditanggapi
                                                        <span class="text-dark">{{ $item->sudah_ditanggapi }}</span>
                                                    </div>
                                                    <div class="badge bg-danger">
                                                        Belum Ditanggapi
                                                        <span class="text-dark">{{ $item->belum_ditanggapi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Top 5 Kategori Pelaku Usaha Penerima Sanksi</h5>
                            <div class="row justify-content-between">
                                @foreach ($top_jenis_pelaku as $item)
                                    <div class="col d-flex">
                                        <div class="card bg-warning mb-3 mb-md-3 text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="h2 mb-0">{{ $item->total_sanksi }}</h5>
                                                        <strong class="mb-0">{{ $item->nama }}</strong>
                                                    </div>
                                                </div>
                                                <div class="d-block align-items-center ms-3">
                                                    <div class="badge bg-success me-1">
                                                        Sudah Ditanggapi
                                                        <span class="text-dark">{{ $item->sudah_ditanggapi }}</span>
                                                    </div>
                                                    <div class="badge bg-danger">
                                                        Belum Ditanggapi
                                                        <span class="text-dark">{{ $item->belum_ditanggapi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2">
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
            </div>
        </div>
    </div>
@endsection
