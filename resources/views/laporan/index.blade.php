@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card">
                        {{-- <div class="card-header d-flex justify-content-between border-0">
                            <form action="{{ route('laporan.generate') }}" method="GET" class="d-flex gap-2">
                                <select name="bulan" class="form-control form-control-sm" required>
                                    <option value="">Bulan</option>
                                    @foreach (range(1, 12) as $b)
                                        <option value="{{ $b }}">
                                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}</option>
                                    @endforeach
                                </select>
                                <select name="tahun" class="form-control form-control-sm" required>
                                    @foreach (range(date('Y'), date('Y') - 5) as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary" value="laporan" name="aksi">Generate</button>
                                <button class="btn btn-sm btn-primary" value="filter" name="aksi">Filter</button>
                            </form>
                        </div> --}}
                        <div class="card-body mt-1">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="dataTables">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 7%">Tahun</th>
                                            <th style="width: 7%">Bulan</th>
                                            <th style="width: 8%">Status</th>
                                            <th style="width: 8%">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($laporan as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->tahun == 0 ? 'Semua' : $row->tahun }}
                                                </td>
                                                <td>{{ $row->bulan ? DateTime::createFromFormat('!m', $row->bulan)->format('F') : 'Semua' }}
                                                </td>
                                                {{-- <td>
                                                    @if (!empty($row->catatan))
                                                        {{ $row->catatan }}
                                                    @else
                                                        <form action="{{ route('laporan.isi-catatan', $row->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="input-group">
                                                                <input type="text" name="catatan" id="catatan"
                                                                    class="form-control">
                                                                <button class="btn btn-primary"
                                                                    type="submit">Simpan</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @if ($row->status_disetujui)
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @else
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('laporan.pdf', $row->id) }}"
                                                        class="fs-2 text-decoration-none" target="_blank"><i
                                                            class="psi-eye-visible"></i></a>
                                                    @if (auth()->user()->role == 'ketua_tim' || auth()->user()->role == 'admin')
                                                        <button class="btn btn-sm btn-primary upload-btn mt-1"
                                                            data-id="{{ $row->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalStatus">
                                                            Upload Bukti
                                                        </button>
                                                        <form action="{{ route('laporan.approve', $row->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @if ($row->status_disetujui)
                                                                <button class="fs-2 text-danger bg-transparent border-0">
                                                                    <i class="psi-close"></i>
                                                                </button>
                                                                <input type="checkbox" name="" id="">ut
                                                            @else
                                                                <button class="fs-2 text-success bg-transparent border-0">
                                                                    <i class="psi-yes"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    @endif
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
    {{-- Modal Status --}}
    <div class="modal fade" id="modalStatus" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('laporan.approve') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="penindakan_id" id="penindakan_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Persetujuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col col-form-label">Status Laporan</label>
                            <div class="col-sm-9 pt-3">
                                <div class="form-check form-check-inline">
                                    <input id="disetujui" class="form-check-input bg-success" type="radio" name="status"
                                        value="1">
                                    <label for="disetujui" class="form-check-label">Setuju</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input id="belum_disetujui" class="form-check-input bg-warning" type="radio"
                                        name="status" value="0">
                                    <label for="belum_disetujui" class="form-check-label">Kembalikan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col col-form-label">Tambah Catatan (Opsional)</label>
                            <div class="col-sm-9 pt-3">
                                <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Upload</button>
                </div>
        </div>
        </form>
    </div>
@endsection
