@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        {{-- <div class="card-header d-flex align-items-center border-0">
                            <a href="{{ url('pengenaan-sp/create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
                        </div> --}}
                        <div class="card-body mt-1">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">No Surat</th>
                                            <th class="text-dark text-center">Tanggal Surat</th>
                                            <th class="text-dark text-center">Jenis Pelaku Usaha</th>
                                            <th class="text-dark text-center">Perusahaan</th>
                                            {{-- <th class="text-dark text-center">Jenis Pelanggaran</th> --}}
                                            {{-- <th class="text-dark text-center">Kategori SP</th> --}}
                                            {{-- <th class="text-dark text-center">Detail Pelanggaran</th> --}}
                                            {{-- <th class="text-dark text-center">Jangka Waktu Hari</th> --}}
                                            <th class="text-dark text-center">Tanggal Jatuh Tempo</th>
                                            {{-- <th class="text-dark text-center">Bukti Perbaikan</th> --}}
                                            {{-- <th class="text-dark text-center">Tanggapan Atas Perbaikan</th> --}}
                                            <th class="text-dark text-center" style="width: 15%;">Status</th>
                                            <th class="text-dark text-center">Aksi</th>
                                            <th class="text-dark text-center">PIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengenaan_sp as $sp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('pengenaan-sp.show', $sp->id) }}"
                                                        class="text-decoration-none">
                                                        {{ $sp->no_surat }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $sp->tanggal_mulai }}</td>

                                                <td class="text-center">{{ $sp->pelaku_usaha->jenis_pelaku_usaha->nama }}
                                                </td>
                                                <td class="text-center">{{ $sp->pelaku_usaha->nama }}</td>
                                                {{-- <td>
                                                    <strong>{{ $sp->jenis_pelanggaran->nama }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ $sp->kategori_sp->nama }}</strong>
                                                </td>
                                                <td>{{ $sp->detail_pelanggaran }}</td>
                                                <td>{{ \Carbon\Carbon::parse($sp->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($sp->tanggal_selesai)) }}
                                                </td> --}}
                                                <td>{{ \Carbon\Carbon::parse($sp->tanggal_selesai)->translatedFormat('l, d F Y') }}
                                                </td>
                                                {{-- <td class="text-center">
                                                    {{ $sp->tanggapan }}
                                                    @if (!empty($sp->files))
                                                        @foreach ($sp->files as $file)
                                                            <a href="{{ asset('storage/' . $file->url_path) }}"
                                                                target="_blank" class="text-decoration-none">
                                                                <span>{{ $file->original_name }}</span>
                                                            </a>
                                                            <br>
                                                        @endforeach
                                                    @else
                                                        <span>Belum ada dokumen</span>
                                                    @endif
                                                    <br>
                                                    <button class="btn btn-sm btn-primary upload-btn mt-1"
                                                        data-id="{{ $sp->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalUpload">
                                                        Upload Bukti
                                                    </button>
                                                </td> --}}
                                                <td class="text-center">
                                                    <span id="status-penindakan-{{ $sp->id }}"
                                                        class="badge {{ $sp->status_surat == 'belum_ditanggapi' ? 'bg-danger' : 'bg-success' }}">{{ ucwords(str_replace('_', ' ', $sp->status_surat)) }}</span>

                                                    {{-- 
                                                    <form action="{{ route('penindakan.updateStatus', $sp->id) }}"
                                                        method="POST" style="margin-top:6px;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="badge bg-primary border-0">Ganti Status</button>
                                                    </form> --}}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        {{-- <a href="{{ route('sk.create', $sp->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none"
                                                            title="Tindak Lanjut">
                                                            Tindak Lanjut <i class="psi-paper"></i>
                                                        </a> --}}
                                                        @if (auth()->user()->id == $sp->user->id)
                                                            <a href="{{ route('pengenaan-sp.edit', $sp->id) }}"
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
                                                        @else
                                                            <div class="badge bg-warning">
                                                                <span class="fs-3">
                                                                    <i class="psi-security-settings"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    {{ $sp->user->nama }}
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
    {{-- Modal Upload Files --}}
    <div class="modal fade" id="modalUpload" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('penindakan/upload-file') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="penindakan_id" id="penindakan_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Pendukung</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="file" name="lampiran[]" multiple class="form-control" required>
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
            const el = $("#status-penindakan-" + id);

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
            const inputId = document.getElementById("penindakan_id");

            document.querySelectorAll(".upload-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    inputId.value = this.dataset.id;
                });
            });
        });
    </script>
@endsection
