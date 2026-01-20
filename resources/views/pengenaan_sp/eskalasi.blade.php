@extends('layouts.app')

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">

            <a href="{{ route('pengenaan-sp.index') }}" class="btn btn-sm btn-light mb-3">
                ⬅ Kembali
            </a>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Detail Pengenaan Sanksi</h5>

                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Perusahaan</th>
                            <td>{{ $sp->pelaku_usaha->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pelanggaran</th>
                            <td>{{ $sp->jenis_pelanggaran->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sanksi Aktif</th>
                            <td>
                                {{ $eskalasiAktif->sanksi->nama }}
                                (SP {{ $eskalasiAktif->level }})
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Surat</th>
                            <td>
                                {{ \Carbon\Carbon::parse($eskalasiAktif->tanggal_mulai)->translatedFormat('l, d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Jatuh Tempo</th>
                            <td>
                                {{ \Carbon\Carbon::parse($eskalasiAktif->tanggal_selesai)->translatedFormat('l, d F Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Riwayat Eskalasi Sanksi</h5>

                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">Level</th>
                                <th>No Surat</th>
                                <th>Periode</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sp->eskalasi as $e)
                                <tr>
                                    <td class="text-center">SP {{ $e->level }}</td>
                                    <td>{{ $e->no_surat }}</td>
                                    <td>
                                        {{ $e->tanggal_mulai }} <br>
                                        s/d {{ $e->tanggal_selesai }}
                                    </td>
                                    <td>
                                        @if ($e->is_denda)
                                            Rp {{ number_format($e->nominal_denda) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $e->status === 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($e->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach ($e->files as $file)
                                            <a href="{{ $file->url_path }}" target="_blank"
                                                class="d-block text-decoration-none">
                                                📄 {{ $file->original_name ?? 'Dokumen' }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="data-item">
                        <h5 class="mb-3">Tambah Eskalasi Baru</h5>

                        <form method="POST" action="{{ route('pengenaan-sp.eskalasi.store', $sp->id) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="level" value="{{ $nextLevel }}">

                            <div class="mb-3">
                                <label>No Surat</label>
                                <input type="text" name="no_surat" class="form-control" required
                                    value="{{ old('no_surat') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Surat</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required
                                        value="{{ $sp->tanggal_mulai }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Jatuh Tempo</label>
                                    <input type="date" name="tanggal_selesai" class="form-control" required
                                        value="{{ old('tanggal_selesai') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bentuk Sanksi</label>
                                <select name="sanksi_id" class="form-select sanksi-id">
                                    @foreach ($sanksi as $s)
                                        <option value="{{ $s->id }}" data-kode="{{ $s->kode_surat }}"
                                            {{ old('sanksi_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Checkbox Denda --}}
                            <div class="form-check form-check-inline mb-3 is-denda">
                                <label class="form-check-label">Termasuk Denda</label>
                                <input type="hidden" name="is_denda" value="0">
                                <input class="form-check-input" type="checkbox" name="is_denda" value="1"
                                    {{ old('is_denda') ? 'checked' : '' }}>
                            </div>

                            {{-- Nominal Denda --}}
                            <div class="mb-3 nominal-denda">
                                <label class="form-label">Nominal Denda</label>
                                <input type="number" name="nominal_denda"
                                    class="form-control @error('nominal_denda') is-invalid @enderror"
                                    value="{{ old('nominal_denda') }}">
                                @error('nominal_denda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Dokumen Eskalasi</label>
                                <input type="file" name="dokumen" class="form-control" required>
                            </div>

                            <button class="btn btn-warning">
                                Simpan Eskalasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            function handleSanksi(row) {
                let select = row.find('.sanksi-id');
                let selected = select.find('option:selected');
                let kode = selected.data('kode');

                let isDendaWrapper = row.find('.is-denda');
                let checkbox = isDendaWrapper.find('input[type="checkbox"]');
                let hidden = isDendaWrapper.find('input[type="hidden"]');
                let nominalWrapper = row.find('.nominal-denda');

                if (kode === 'DA') {
                    // Denda Administratif murni
                    isDendaWrapper.hide();
                    checkbox.prop('checked', true);
                    hidden.val(1);
                    nominalWrapper.show();
                } else {
                    // Sanksi lain
                    isDendaWrapper.show();

                    if (checkbox.is(':checked')) {
                        hidden.val(1);
                        nominalWrapper.show();
                    } else {
                        hidden.val(0);
                        nominalWrapper.hide();
                        nominalWrapper.find('input').val('');
                    }
                }
            }

            // onchange sanksi
            $(document).on('change', '.sanksi-id', function() {
                handleSanksi($(this).closest('.data-item'));
            });

            // onchange is_denda
            $(document).on('change', '.is-denda input[type="checkbox"]', function() {
                handleSanksi($(this).closest('.data-item'));
            });

            // init (edit / eskalasi)
            $('.data-item').each(function() {
                handleSanksi($(this));
            });
        });
    </script>
@endsection
