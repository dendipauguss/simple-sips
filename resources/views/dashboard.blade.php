@extends('layouts.app')
@section('content')
    <div class="content__header content__boxed rounded-0">
        <div class="content__wrap">
            <div class="row justify-content-between">
                <div class="col-xl-12">
                    {{-- <div class="card mb-1">
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
                    </div> --}}

                    <div class="card mb-2 text-white text-center bg-transparent shadow-none">
                        {{-- <div class="col-sm-3 ms-auto card text-dark text-center mb-2">
                            <form action="" method="get" id="filter_tahun">
                                <select name="tahun" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahun_list as $t)
                                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                            {{ $t }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div> --}}
                        <div class="ms-auto">
                            <form action="" method="GET" id="filter_tahun">
                                <div class="btn-group">
                                    <button name="tahun" value=""
                                        class="btn btn-outline-light {{ request('tahun') == '' ? 'active' : '' }}">Semua
                                        Tahun</button>
                                    @foreach ($tahun_list as $t)
                                        <button name="tahun" value="{{ $t }}"
                                            class="btn btn-outline-light {{ request('tahun') == $t ? 'active' : '' }}"
                                            type="submit">{{ $t }}</button>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-2 text-white text-center bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Trend Pengenaan Sanksi Tiap Bulan</h5>
                            <!-- Stacked chart -->
                            <div style="height: 300px;">
                                <canvas id="sanksi_per_bulan_chart" data-stack='@json($sanksi_per_periode)'></canvas>
                            </div>
                            <!-- END : Stacked chart -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card mb-2 text-center text-white bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Persentase Kategori Pelaku Usaha Penerima Sanksi</h5>
                            <div class="row gap-1 justify-content-evenly">
                                @foreach ($top_jenis_pelaku as $i => $item)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 px-1">
                                        <div class="card bg-transparent shadow-none">
                                            <div class="card-body p-2 text-center d-flex flex-column align-items-center">
                                                <div style="width: 170px; height: 170px;">
                                                    <canvas class="donut-mini" id="donut-{{ $i }}"
                                                        data-persen="{{ $item->persen }}" data-nama="{{ $item->nama }}">
                                                    </canvas>
                                                </div>
                                                {{-- <div class="badge bg-success d-flex justify-content-between mb-1">
                                                    <span>Sudah Ditanggapi</span>
                                                    <span class="text-dark">{{ $item->sudah_ditanggapi }}</span>
                                                </div>
                                                <div class="badge bg-danger d-flex justify-content-between mb-1">
                                                    <span>Belum Ditanggapi</span>
                                                    <span class="text-dark">{{ $item->belum_ditanggapi }}</span>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-2 text-center text-white bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Total Sanksi Per Bentuk Sanksi</h5>
                            <!-- Status Chart -->
                            <div style="height: 300px;">
                                <canvas id="sanksi_per_bentuk_chart" data-labels='@json($sanksi_per_bentuk->pluck('kode_surat'))'
                                    data-values='@json($sanksi_per_bentuk->pluck('pengenaan_sp_count'))'>></canvas>
                            </div>
                            <!-- END : Status Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-2 text-center text-white bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Total Sanksi Per Pelanggaran</h5>
                            <!-- Status Chart -->
                            <div style="height: 300px;">
                                <canvas id="sanksi_per_pelanggaran_chart" data-labels='@json($sanksi_per_pelanggaran->pluck('nama'))'
                                    data-values='@json($sanksi_per_pelanggaran->pluck('pengenaan_sp_count'))'>></canvas>
                            </div>
                            <!-- END : Status Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-2 text-center text-white bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Top 10 Perusahaan Penerima Sanksi</h5>
                            <div style="height: 300px">
                                <canvas id="top_pelaku_chart" data-labels='@json($top_pelaku->pluck('nama'))'
                                    data-sudah='@json($top_pelaku->pluck('sudah_ditanggapi'))' data-total='@json($top_pelaku->pluck('total_sanksi'))'>
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-2 text-center text-white bg-transparent shadow-lg border-info">
                        <div class="card-body">
                            <h5 class="card-title">Kategori Pelaku Usaha Penerima Sanksi</h5>
                            <div style="height: 300px">
                                <canvas id="top_jenis_pelaku_chart" data-labels='@json($top_jenis_pelaku_bar->pluck('nama'))'
                                    data-sudah='@json($top_jenis_pelaku_bar->pluck('sudah_ditanggapi'))' data-total='@json($top_jenis_pelaku_bar->pluck('total_sanksi'))'>
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
