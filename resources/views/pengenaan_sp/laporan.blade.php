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
                                        class="btn btn-sm btn-danger">Export PDF</a>
                                </div>
                            </div>

                        </div>


                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">Periode</th>
                                            <th class="text-dark text-center">Nama Perusahaan</th>
                                            <th class="text-dark text-center">Sanksi</th>
                                            <th class="text-dark text-center">Keterangan</th>
                                            <th class="text-dark text-center" style="width: 15%;">Status</th>
                                            @if (auth()->user()->role == 'admin')
                                                <th class="text-dark text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengenaan_sp as $p)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <td class="text-center">{{ $p->tanggal_mulai }} s/d
                                                    {{ $p->tanggal_selesai }}
                                                </td>
                                                <td class="text-center">{{ $p->pelaku_usaha->nama }}</td>
                                                <td>
                                                    {{ $p->sanksi->nama }}
                                                </td>
                                                <td>{{ $p->detail_pelanggaran }}</td>
                                                <td class="text-center">

                                                    <span
                                                        class="badge {{ $p->status_surat == 'belum' ? 'bg-danger' : ($p->status_surat == 'selesai' ? 'bg-success' : 'bg-warning text-dark') }}">{{ Str::ucfirst($p->status_surat) }}</span>
                                                </td>
                                                @if (auth()->user()->role == 'admin')
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('pengenaan-sp.show', $p->id) }}"
                                                                class="badge bg-info me-1 text-decoration-none"
                                                                title="Detail">
                                                                Detail <i class="psi-paper"></i>
                                                            </a>
                                                            <a href="{{ route('pengenaan-sp.edit', $p->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); document.getElementById('delete-{{ $p->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $p->id }}"
                                                                action="{{ route('pengenaan-sp.destroy', $p->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
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
