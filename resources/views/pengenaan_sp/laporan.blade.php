@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <form class="row row-cols-md-auto g-3 align-items-center"
                                action="{{ url('pengenaan-sp/laporan') }}" method="GET">
                                <div class="col-12">
                                    <label for="tanggal_mulai" class="visually-hidden">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="start"
                                        value="{{ request('start') }}">
                                </div>
                                <div class="col-12">
                                    <label for="tanggal_selesai" class="visually-hidden">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="end"
                                        value="{{ request('end') }}">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ url('pengenaan-sp/laporan') }}" class="btn btn-sm btn-light">Reset</a>
                                </div>
                            </form>

                            <div class="row row-cols-md-auto">
                                <div class="input-group ms-2">
                                    <a href="{{ route('pengenaan-sp.export.excel', request()->all()) }}"
                                        class="btn btn-sm btn-success">Export Excel</a>
                                    <a href="{{ route('pengenaan-sp.export.pdf', request()->all()) }}"
                                        class="btn btn-sm btn-danger" target="_blank">Export PDF</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">Tanggal Jatuh Tempo</th>
                                            <th class="text-dark text-center">Kategori</th>
                                            <th class="text-dark text-center">Perusahaan</th>
                                            <th class="text-dark text-center">Sanksi</th>
                                            <th class="text-dark text-center">Pelanggaran</th>
                                            <th class="text-dark text-center">Tanggapan</th>
                                            <th class="text-dark text-center" style="width: 15%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengenaan_sp as $p)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($p->tanggal_selesai)->translatedFormat('l, d F Y') }}
                                                </td>
                                                <td class="text-center">{{ $p->pelaku_usaha->jenis_pelaku_usaha->nama }}
                                                </td>
                                                <td class="text-center">{{ $p->pelaku_usaha->nama }}</td>
                                                <td>
                                                    {{ $p->sanksi->nama }}
                                                </td>
                                                <td class="text-center">{{ $p->jenis_pelanggaran->nama }}
                                                </td>
                                                <td>{{ $p->tanggapan }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $p->status_surat == 'belum_ditanggapi' ? 'bg-danger' : 'bg-success' }}">{{ ucwords(str_replace('_', ' ', $p->status_surat)) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
