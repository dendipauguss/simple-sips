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
                                                    @foreach ($row->pengenaan_sp->take(5) as $sp)
                                                        <a href="{{ route('pengenaan-sp.show', $sp->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $sp->no_surat }}
                                                        </a>
                                                    @endforeach

                                                    @if ($row->pengenaan_sp->count() > 5)
                                                        <small class="text-muted">
                                                            +{{ $row->pengenaan_sp->count() - 5 }} data lainnya
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('pengenaan-sp.show', $sp->id) }}"
                                                            class="badge bg-warning me-1 text-decoration-none"
                                                            title="Edit">
                                                            Edit <i class="psi-pencil"></i>
                                                        </a>
                                                        <a href="#" class="badge bg-danger text-decoration-none"
                                                            onclick="event.preventDefault(); document.getElementById('delete-{{ $sp->id }}').submit();">
                                                            Hapus <i class="psi-trash"></i>
                                                        </a>

                                                        <form id="delete-{{ $sp->id }}"
                                                            action="{{ route('pengenaan-sp.destroy', $sp->id) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
