@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <a href="{{ url('penindakan/create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
                        </div>

                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">Periode</th>
                                            <th class="text-dark text-center">Perihal</th>
                                            <th class="text-dark text-center">Nama Perusahaan</th>
                                            <th class="text-dark text-center">Sanksi</th>
                                            {{-- <th class="text-dark text-center">Keterangan</th> --}}
                                            <th class="text-dark text-center">Dokumen Pendukung</th>
                                            <th class="text-dark text-center" style="width: 15%;">Status</th>
                                            @if (auth()->user()->role == 'admin')
                                                <th class="text-dark text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penindakan as $p)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <td class="text-center">{{ $p->tanggal_mulai }} s/d
                                                    {{ $p->tanggal_selesai }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $p->perihal->nama }}
                                                </td>
                                                <td class="text-center">{{ $p->perusahaan->nama }}</td>
                                                <td>
                                                    <strong>{{ $p->sanksi->nama }}</strong>

                                                    <ul style="list-style:none; margin:0; padding-left:0;">
                                                        @foreach ($p->perintah as $pr)
                                                            <li>
                                                                <label class="d-flex justify-content-between">
                                                                    {{ $pr->nama }}
                                                                    <input type="checkbox" data-id="{{ $pr->pivot->id }}"
                                                                        data-type="bawaan"
                                                                        class="update-status form-check-input"
                                                                        {{ $pr->pivot->status == 'sudah' ? 'checked' : '' }}>
                                                                </label>
                                                            </li>
                                                        @endforeach

                                                        {{-- Perintah lainnya --}}
                                                        @if ($p->perintah_lainnya)
                                                            <li>
                                                                <label class="d-flex justify-content-between">
                                                                    {{ $p->perintah_lainnya }}
                                                                    <input type="checkbox" data-id="{{ $p->id }}"
                                                                        data-type="lainnya"
                                                                        class="update-status form-check-input"
                                                                        {{ $p->status_lainnya == 'sudah' ? 'checked' : '' }}>
                                                                </label>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                {{-- <td>{{ $p->deskripsi }}</td> --}}
                                                <td class="text-center">
                                                    @if (!empty($p->files))
                                                        @foreach ($p->files as $file)
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
                                                        data-id="{{ $p->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalUpload">
                                                        Upload Bukti
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <span id="status-penindakan-{{ $p->id }}"
                                                        class="badge {{ $p->status == 'belum' ? 'bg-danger' : ($p->status == 'pending' ? 'bg-warning text-dark' : 'bg-success') }}">{{ ucfirst($p->status) }}</span>

                                                    {{-- 
                                                    <form action="{{ route('penindakan.updateStatus', $p->id) }}"
                                                        method="POST" style="margin-top:6px;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="badge bg-primary border-0">Ganti Status</button>
                                                    </form> --}}
                                                </td>
                                                @if (auth()->user()->role == 'admin')
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('penindakan.show', $p->id) }}"
                                                                class="badge bg-info me-1 text-decoration-none"
                                                                title="Detail">
                                                                Detail <i class="psi-paper"></i>
                                                            </a>
                                                            <a href="{{ route('penindakan.edit', $p->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); document.getElementById('delete-{{ $p->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $p->id }}"
                                                                action="{{ route('penindakan.destroy', $p->id) }}"
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
