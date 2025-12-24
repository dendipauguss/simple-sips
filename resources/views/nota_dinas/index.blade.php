@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card">
                        <div class="card-body mt-1">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="dataTables">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 7%">Tanggal</th>
                                            <th style="width: 8%">Sanksi</th>
                                            <th style="width: 9%">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($nota_dinas as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_nota_dinas)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>
                                                    @foreach ($row->pengenaan_sp as $sp)
                                                        <a href="{{ route('pengenaan-sp.show', $sp->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $sp->no_surat }}</a>
                                                    @endforeach
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <div class="input-group">
                                                        <a href="{{ route('laporan.pdf', $row->id) }}"
                                                            class="btn btn-sm text-decoration-none" target="_blank"
                                                            title="Lihat Laporan"><i class="psi-eye fs-4 text-info"></i></a>

                                                        <button class="btn btn-sm upload-btn" data-id="{{ $row->id }}"
                                                            data-bs-toggle="modal" data-bs-target="#modalStatus"
                                                            data-status="{{ $row->status_persetujuan }}"
                                                            data-catatan="{{ $row->catatan }}" title="Validasi Ketua Tim">

                                                            <i
                                                                class="fs-4 {{ $row->status_persetujuan == 'setuju' ? 'psi-yes text-success' : ($row->status_persetujuan == 'dikembalikan' ? 'psi-close text-danger' : 'psi-danger text-warning') }}"></i>
                                                        </button>
                                                    </div>
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
                <input type="hidden" name="laporan_id" id="laporan_id">

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
                                    <input id="setuju" class="form-check-input bg-success" type="radio" name="status"
                                        value="setuju" {{ auth()->user()->role != 'ketua_tim' ? 'disabled' : '' }}>
                                    <label for="setuju" class="form-check-label">Setuju</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input id="dikembalikan" class="form-check-input bg-danger" type="radio"
                                        name="status" value="dikembalikan"
                                        {{ auth()->user()->role != 'ketua_tim' ? 'disabled' : '' }}>
                                    <label for="dikembalikan" class="form-check-label">Kembalikan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col col-form-label">Tambah Catatan (Opsional)</label>
                            <div class="col-sm-9 pt-3">

                                <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control"
                                    {{ auth()->user()->role != 'ketua_tim' ? 'readonly' : '' }}></textarea>

                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role == 'ketua_tim')
                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.upload-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('laporan_id').value = this.dataset.id;
                    document.getElementById('catatan').value = this.dataset.catatan;
                    if (this.dataset.status == 'setuju') {
                        document.getElementById('setuju').checked = true;
                    } else if (this.dataset.status == 'dikembalikan') {
                        document.getElementById('dikembalikan').checked = true;
                    }
                });
            });
        });
    </script>
@endsection
