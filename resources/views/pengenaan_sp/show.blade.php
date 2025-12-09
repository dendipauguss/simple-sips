@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-7 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <a href="{{ route('pengenaan-sp.index') }}" class="btn btn-sm btn-dark"> ⬅ Kembali</a>
                        </div>
                        <div class="card-body py-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">No Surat</strong>
                                    <span>:
                                        {{ $sp->no_surat }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Tanggal Surat</strong>
                                    <span>: {{ $sp->tanggal_mulai }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Bulan</strong>
                                    <span>:
                                        {{ \Carbon\Carbon::parse($sp->tanggal_mulai)->translatedFormat('F') }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Jenis Pelaku Usaha</strong>
                                    <span>: {{ $sp->pelaku_usaha->jenis_pelaku_usaha->nama }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Perusahaan</strong>
                                    <span>: {{ $sp->pelaku_usaha->nama }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Jenis Pelanggaran</strong>
                                    <span>: {{ $sp->jenis_pelanggaran->nama }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Kategori SP</strong>
                                    <span>: {{ $sp->kategori_sp->nama }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Detail Pelanggaran</strong>
                                    <span>: {{ $sp->detail_pelanggaran }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Jangka Waktu Hari</strong>
                                    <span>:
                                        {{ \Carbon\Carbon::parse($sp->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($sp->tanggal_selesai)) }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Tanggal Jatuh Tempo</strong>
                                    <span>:
                                        {{ \Carbon\Carbon::parse($sp->tanggal_selesai)->translatedFormat('l, d F Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-3" style="width: 150px;">Tanggapan Atas Perbaikan</strong>
                                    <span>: </span>
                                    <div class="col ms-1">
                                        {{ !empty($sp->tanggapan) ? $sp->tanggapan : 'Belum ada tanggapan' }}
                                        <br>
                                        @if (!empty($sp->files))
                                            @foreach ($sp->files as $file)
                                                @if ($file->tipe == 'bebas')
                                                    <a href="{{ asset('storage/' . $file->url_path) }}" target="_blank"
                                                        class="text-decoration-none">
                                                        <span>{{ $file->original_name }}</span>
                                                    </a>
                                                    <br>
                                                @endif
                                            @endforeach
                                        @else
                                            <span>Belum ada dokumen</span>
                                        @endif
                                    </div>
                                    <div class="col ms-1">
                                        <button class="btn btn-sm btn-primary upload-btn mt-1"
                                            data-id="{{ $sp->id }}" data-bs-toggle="modal"
                                            data-bs-target="#modalUpload">
                                            Isi Tanggapan dan Upload Dokumen
                                        </button>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Status</strong>
                                    <span>:
                                        <span
                                            class="badge {{ $sp->status_surat == 'belum_direspon' ? 'bg-danger' : 'bg-success' }}">
                                            {{ ucwords(str_replace('_', ' ', $sp->status_surat)) }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl">
                    <div class="card h-100">
                        <div class="card-body py-4">
                            <iframe src="{{ asset($sp->file->url_path) }}" frameborder="0" width="100%"
                                height="600px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Upload Files --}}
    <div class="modal fade" id="modalUpload" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('pengenaan-sp.upload-dokumen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pengenaan_sp_id" id="pengenaan_sp_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tanggapan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="tanggapan" class="form-label">Tanggapan Atas Perbaikan</label>
                            <textarea name="tanggapan" class="form-control" required></textarea>
                        </div>
                        <div class="row mb-2">
                            <label for="lampiran" class="form-label">Dokumen Pendukung</label>
                            <input type="file" name="lampiran[]" multiple class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateStatusBadge(id, status) {
            const el = $("#status-pengenaan-sp-" + id);

            el.removeClass("bg-danger bg-warning text-dark bg-success");

            if (status === "belum") {
                el.addClass("badge bg-danger");
            } else if (status === "pending") {
                el.addClass("badge bg-warning text-dark");
            } else {
                el.addClass("badge bg-success");
            }

            el.text(status.charAt(0).toUpperCase() + status.slice(1));
        }

        $('.update-status').on('change', function() {
            const id = $(this).data('id');
            const tipe = $(this).data('type');
            const status = $(this).is(':checked') ? 'sudah' : 'belum';

            $.ajax({
                url: '/penindakan/perintah/status/' + id,
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status,
                    tipe: tipe
                },
                success: function(res) {
                    if (res.success) {
                        showAjaxToast(res.message);
                        updateStatusBadge(res.penindakan_id, res.status_baru);
                    }
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("modalUpload");
            const inputId = document.getElementById("pengenaan_sp_id");

            document.querySelectorAll(".upload-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    inputId.value = this.dataset.id;
                });
            });
        });
    </script>
@endsection
