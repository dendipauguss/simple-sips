@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between border-0">
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
                                <button class="btn btn-sm btn-primary">Generate</button>
                            </form>
                        </div>
                        <div class="card-body mt-1">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="dataTables">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Catatan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($laporan as $row)
                                            <tr>
                                                <td>{{ DateTime::createFromFormat('!m', $row->bulan)->format('F') }}</td>
                                                <td>{{ $row->tahun }}</td>
                                                <td>{{ $row->catatan ?? '-' }}</td>
                                                <td>
                                                    @if ($row->status_disetujui)
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @else
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('laporan.show', $row->id) }}"
                                                        class="fs-1 text-decoration-none"><i
                                                            class="psi-eye-visible"></i></a>

                                                    <form action="{{ route('laporan.approve', $row->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @if ($row->status_disetujui)
                                                            <button class="fs-2 text-danger bg-transparent border-0">
                                                                <i class="psi-close"></i>
                                                            </button>
                                                        @else
                                                            <button class="fs-2 text-success bg-transparent border-0">
                                                                <i class="psi-yes"></i>
                                                            </button>
                                                        @endif
                                                    </form>
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
