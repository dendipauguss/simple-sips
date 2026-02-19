@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100 bg-primary border-info text-white">
                        <div class="card-header border-0">
                            <form method="GET" action="{{ route('pengenaan-sp.index') }}" id="filterForm">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <select name="bulan" class="form-select bg-primary border-info text-white">
                                            <option value="">Semua Bulan</option>
                                            @foreach ($bulanList as $b)
                                                <option value="{{ $b }}"
                                                    {{ request('bulan') == $b ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::createFromFormat('!m', $b)->translatedFormat('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="tahun" class="form-select bg-primary border-info text-white">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($tahunList as $t)
                                                <option value="{{ $t }}"
                                                    {{ request('tahun') == $t ? 'selected' : '' }}>
                                                    {{ $t }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="perusahaan_id" class="form-select select2">
                                            <option value="">Semua Perusahaan</option>
                                            @foreach ($perusahaan as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ request('perusahaan_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="status" class="form-select bg-primary border-info text-white">
                                            <option value="">Semua Status</option>
                                            <option value="sudah_ditanggapi"
                                                {{ request('status') == 'sudah_ditanggapi' ? 'selected' : '' }}>
                                                Sudah Ditanggapi
                                            </option>
                                            <option value="belum_ditanggapi"
                                                {{ request('status') == 'belum_ditanggapi' ? 'selected' : '' }}>
                                                Belum Ditanggapi
                                            </option>
                                        </select>
                                    </div>

                                    <div class="{{ auth()->user()->role == 'admin' ? 'col-md-3' : 'col-md-2' }} ms-auto">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-light">
                                                🔍 Filter
                                            </button>

                                            <button type="button" class="btn btn-info" onclick="generateLaporan()">
                                                📄 Generate
                                            </button>

                                            @if (auth()->user()->role == 'admin')
                                                <a href="{{ url('pengenaan-sp/import') }}" class="btn btn-success">+ Import
                                                    Excel</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- <div class="row row-cols-md-auto">
                                <div class="input-group ms-2">
                                    <a href="{{ route('laporan.generate', request()->all()) }}"
                                        class="btn btn-sm btn-danger" target="_blank">Generate Laporan</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body mt-1">
                            <div class="table-responsive">
                                <table class="table table-hover bg-primary text-white" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">No Surat</th>
                                            <th class="text-dark text-center">Tanggal Surat</th>
                                            <th class="text-dark text-center">Kategori Pelaku Usaha</th>
                                            <th class="text-dark text-center">Perusahaan</th>
                                            <th class="text-dark text-center">Kategori Pelanggaran</th>
                                            <th class="text-dark text-center">Bentuk Sanksi</th>
                                            <th class="text-dark text-center">Tanggal Jatuh Tempo Sanksi</th>
                                            <th class="text-dark text-center" style="width: 10%;">Status</th>
                                            @if (auth()->user()->role != 'ketua_tim')
                                                <th class="text-dark text-center">Aksi</th>
                                            @endif
                                            <th class="text-dark text-center">PIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            \Carbon\Carbon::setLocale('id');
                                        @endphp
                                        @foreach ($pengenaan_sp as $sp)
                                            @php
                                                $hariIni = now();
                                                $eskalasiAktif = $sp->eskalasi_aktif;
                                                $tglSelesai = \Carbon\Carbon::parse($eskalasiAktif->tanggal_selesai);
                                                $sisaHari = $hariIni->diffInDays($tglSelesai, false);
                                                $bolehEskalasi =
                                                    $eskalasiAktif &&
                                                    $hariIni->gt($eskalasiAktif->tanggal_selesai) &&
                                                    in_array($sp->status_surat, ['belum_ditanggapi']);
                                                $statusAktif = in_array($sp->status_surat, ['belum_ditanggapi']);
                                            @endphp

                                            <tr
                                                class="{{ $statusAktif && $sisaHari < 0
                                                    ? 'table-danger'
                                                    : ($statusAktif && $sisaHari >= 0 && $sisaHari <= 5
                                                        ? 'table-warning'
                                                        : '') }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ $sp->no_surat }}
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($eskalasiAktif->tanggal_mulai)->translatedFormat('d-m-Y') }}
                                                </td>
                                                <td class="text-center">{{ $sp->pelaku_usaha->jenis_pelaku_usaha->nama }}
                                                </td>
                                                <td class="text-center">{{ $sp->pelaku_usaha->nama }}</td>
                                                <td class="text-center">{{ $sp->jenis_pelanggaran->nama }}
                                                </td>

                                                <td>
                                                    @if ($eskalasiAktif)
                                                        {{ $eskalasiAktif->sanksi->nama }}
                                                        @if ($eskalasiAktif->sanksi->kode_surat === 'SP')
                                                            {{ $eskalasiAktif->level }}
                                                        @endif

                                                        @if ($eskalasiAktif->is_denda)
                                                            <br>
                                                            <small class="text-danger">
                                                                Denda: Rp
                                                                {{ number_format($eskalasiAktif->nominal_denda, 0, ',', '.') }}
                                                            </small>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($eskalasiAktif->tanggal_selesai)->translatedFormat('l, d F Y') }}
                                                    <br>
                                                    @if ($statusAktif)
                                                        @if ($sisaHari < 0)
                                                            <div class="text-danger" style="font-size: 11px;">
                                                                Terlambat
                                                                {{ $tglSelesai->longAbsoluteDiffForHumans(now()) }}
                                                            </div>
                                                        @elseif ($sisaHari <= 5)
                                                            <div class="text-warning" style="font-size: 11px;">
                                                                Jatuh tempo
                                                                {{ $tglSelesai->longAbsoluteDiffForHumans(now()) }}
                                                                lagi
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($sp->status_surat == 'pending')
                                                        <span id="status-penindakan-{{ $sp->id }}">-</span>
                                                    @else
                                                        <h5>
                                                            <span id="status-penindakan-{{ $sp->id }}"
                                                                class="badge {{ $sp->status_surat == 'belum_ditanggapi' ? 'bg-danger' : 'bg-success' }}">{{ ucwords(str_replace('_', ' ', $sp->status_surat)) }}</span>
                                                        </h5>
                                                    @endif

                                                </td>
                                                @if (auth()->user()->role != 'ketua_tim')
                                                    <td class="text-center">
                                                        @if (auth()->user()->id == $sp->user->id ||
                                                                \Carbon\Carbon::parse($sp->tanggal_mulai)->format('Y') == '2025' ||
                                                                \Carbon\Carbon::parse($sp->tanggal_mulai)->format('Y') == '2024' ||
                                                                \Carbon\Carbon::parse($sp->tanggal_mulai)->format('Y') == '2023')
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('pengenaan-sp.show', $sp->id) }}"
                                                                    class="btn btn-sm btn-info" title="Tanggapi">
                                                                    <i class="psi-pencil"></i>
                                                                </a>
                                                                {{-- @if ($bolehEskalasi)
                                                                    <a href="{{ route('pengenaan-sp.eskalasi', $sp->id) }}"
                                                                        class="badge bg-warning me-1 text-decoration-none"
                                                                        title="Eskalasi">
                                                                        ESKALASI <i class="psi-exclamation"></i>
                                                                    </a>
                                                                @else
                                                                    <a class="badge bg-gray me-1 text-decoration-none text-dark"
                                                                        disabled>
                                                                        ESKALASI <i class="psi-exclamation"></i>
                                                                    </a>
                                                                @endif --}}
                                                                <a href="{{ route('pengenaan-sp.eskalasi', $sp->id) }}"
                                                                    class="btn btn-sm btn-warning" title="Eskalasi">
                                                                    <i class="psi-up"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-danger"
                                                                    onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-{{ $sp->id }}').submit();"
                                                                    title="Hapus">
                                                                    <i class="psi-trash"></i>
                                                                </a>
                                                            </div>
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
                                                    </td>
                                                @endif
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

        function generateLaporan() {
            const form = document.getElementById('filterForm');

            form.querySelectorAll('select').forEach(el => {
                if (el.value === '') {
                    el.disabled = true;
                }
            });

            form.action = "{{ route('laporan.generate') }}";
            form.submit();
        }
    </script>
@endsection
