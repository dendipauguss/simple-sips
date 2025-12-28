@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            @php $jumlah = !empty(old('no_surat')) ? count(old('no_surat')) : 1;  @endphp
            <form action="{{ route('pengenaan-sp.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row sticky-top mb-2">
                    <div class="col-xl-12 mb-xl-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="input-group justify-content-end">
                                    <a href="{{ route('pengenaan-sp.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 mb-3 mb-xl-0">
                        <div class="card sticky-top">
                            <div class="card-body">
                                <!-- NOTA DINAS Form -->
                                <div class="mb-3">
                                    <label class="form-label">Dasar Pengenaan Sanksi</label>
                                    <select name="dasar_pengenaan_sanksi_id"
                                        class="form-select @error('dasar_pengenaan_sanksi_id') is-invalid @enderror dasar-pengenaan-sanksi">
                                        <option value="" disabled selected>-- Pilih Dasar Pengenaan Sanksi --</option>
                                        @foreach ($dasar_pengenaan_sanksi as $dps)
                                            <option value="{{ $dps->id }}"
                                                {{ old('dasar_pengenaan_sanksi_id') == $dps->id ? 'selected' : '' }}>
                                                {{ $dps->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dasar_pengenaan_sanksi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Nota Dinas</label>
                                    <input type="text" class="form-control @error('no_nota_dinas') is-invalid @enderror"
                                        name="no_nota_dinas" value="{{ old('no_nota_dinas') }}">
                                    @error('no_nota_dinas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Nota Dinas</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_nota_dinas') is-invalid @enderror"
                                        name="tanggal_nota_dinas" value="{{ old('tanggal_nota_dinas') }}">
                                    @error('tanggal_nota_dinas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Dokumen Nota Dinas</label>
                                    <input type="file" name="nota_dinas_file" class="form-control">
                                </div>
                                <!-- END : NOTA DINAS Form -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 mb-3 mb-xl-0">
                        <div id="data-container">
                            @for ($i = 0; $i < $jumlah; $i++)
                                <div class="card h-100 data-item mb-2">
                                    <div class="card-body">
                                        <!-- PENGENAAN SANKSI Form -->
                                        <div class="mb-3">
                                            <label class="form-label">No. Surat</label>
                                            <input type="text"
                                                class="form-control @error('no_surat') is-invalid @enderror"
                                                name="no_surat[]" id="no_surat" value="{{ old("no_surat.$i") }}">
                                            @error("no_surat.$i")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bentuk Sanksi</label>
                                            <select name="sanksi_id[]"
                                                class="form-select @error("sanksi_id.$i") is-invalid @enderror"
                                                data-index="{{ $i }}">
                                                <option value="" disabled selected>-- Pilih Bentuk Sanksi --</option>
                                                @foreach ($sanksi as $s)
                                                    <option value="{{ $s->id }}"
                                                        {{ old("sanksi_id.$i") == $s->id ? 'selected' : '' }}>
                                                        {{ $s->kode_surat }}
                                                        -
                                                        {{ $s->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sanksi_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Surat</label>
                                            <input type="date" name="tanggal_mulai[]"
                                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                value="{{ old("tanggal_mulai.$i") }}">
                                            @error('tanggal_mulai')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Jatuh Tempo</label>
                                            <input type="date" name="tanggal_selesai[]"
                                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                value="{{ old("tanggal_selesai.$i") }}">
                                            @error('tanggal_selesai')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pelaku Usaha</label>
                                            <select name="jenis_pelaku_usaha_id[]"
                                                class="form-select @error("jenis_pelaku_usaha_id.$i") is-invalid @enderror jenis-pelaku-usaha"
                                                data-index="{{ $i }}">
                                                @foreach ($jenis_pelaku_usaha as $p)
                                                    <option value="{{ $p->id }}"
                                                        {{ old("jenis_pelaku_usaha_id.$i") == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis_pelaku_usaha_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Perusahaan</label>
                                            <select name="pelaku_usaha_id[]"
                                                class="form-select select2 @error("pelaku_usaha_id.$i") is-invalid @enderror pelaku-usaha"
                                                data-index="{{ $i }}">
                                                <option>-- Pilih Jenis Pelaku Usaha Terlebih Dahulu --</option>
                                            </select>
                                            @error("pelaku_usaha_id.$i")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pelanggaran</label>
                                            <select name="jenis_pelanggaran_id[]"
                                                class="form-select @error("jenis_pelanggaran_id.$i") is-invalid @enderror jenis-pelanggaran"
                                                data-index="{{ $i }}">
                                                @foreach ($jenis_pelanggaran as $j)
                                                    <option value="{{ $j->id }}"
                                                        {{ old("jenis_pelanggaran_id.$i") == $j->id ? 'selected' : '' }}>
                                                        {{ $j->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis_pelanggaran_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Kategori Sanksi</label>
                                            <select name="kategori_sp_id[]"
                                                class="form-select @error("kategori_sp_id.$i") is-invalid @enderror kategori-sp"
                                                data-index="{{ $i }}">
                                                <option>-- Pilih Jenis Pelanggaran Terlebih Dahulu
                                                    --</option>
                                            </select>
                                            @error('kategori_sp_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Detail Pelanggaran</label>
                                            <textarea name="detail_pelanggaran[]" class="form-control" style="height: 100px">{{ old("detail_pelanggaran.$i") }}</textarea>
                                        </div>
                                        <!-- END : PENGENAAN SANKSI Form -->

                                        <div class="mb-3">
                                            <label for="lampiran" class="form-label">Dokumen</label>
                                            <input type="file" name="lampiran[{{ $i }}][]" id="lampiran"
                                                class="form-control">
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                                            + Tambah Pengenaan Sanksi
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">
                                            <i class="psi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 mb-3 mb-xl-0">
                        <div class="card h-100">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p>Untuk Format Nomor Surat seperti contoh ini :</p>
                            <strong>UD.02.01/001/BAPPEBTI/SP/1/2025</strong><br>
                            <span>Jika nomor surat selain SP (ditulis ulang), sisakan untuk bulan dan tahun jangan
                                ditulis
                                ulang <b>(/1/2025)</b></span><br>
                            <strong>UD.02.01/001/BAPPEBTI/SK</strong>
                        </div>
                    </div>
                </div>
            </div> --}}
            </form>
        </div>
    </div>

    <script>
        const oldPelakuUsahaId = @json(old('pelaku_usaha_id', []));
        const oldKategoriSanksiId = @json(old('kategori_sp_id', []));

        $(document).ready(function() {

            $(document).on('change', '.jenis-pelaku-usaha', function() {
                let row = $(this).closest('.data-item');
                let perusahaan = row.find('.pelaku-usaha');

                perusahaan.html('<option>Loading...</option>');

                $.get(`/get-pelaku-usaha/${this.value}`, function(data) {
                    let html = '<option value="">-- Pilih Perusahaan --</option>';
                    data.forEach(v => {
                        html += `<option value="${v.id}">${v.nama}</option>`;
                    });
                    perusahaan.html(html);
                });
            });


            let jenisOld = $('.jenis-pelaku-usaha').val();

            if (jenisOld) {
                $('.jenis-pelaku-usaha').trigger('change');
            }

            $(document).on('change', '.jenis-pelanggaran', function() {

                let jenisID = $(this).val();
                let row = $(this).closest('.data-item');
                let kategoriSelect = row.find('.kategori-sp');

                kategoriSelect.html('<option>Loading...</option>');

                $.get(`/get-kategori-sp/${jenisID}`, function(data) {

                    let html = '<option value="">-- Pilih Kategori Sanksi --</option>';

                    data.forEach(item => {
                        html += `<option value="${item.id}">${item.nama}</option>`;
                    });

                    kategoriSelect.html(html);
                });
            });

            let pelanggaranOld = $('.jenis-pelanggaran').val();

            if (pelanggaranOld) {
                $('.jenis-pelanggaran').trigger('change');
            }

            $(document).on('change', '.dasar-pengenaan-sanksi', function() {

                let dasarID = $(this).val();

                // ambil semua jenis pelanggaran di semua row SP
                let jenisPelanggaranSelect = $('.jenis-pelanggaran');

                jenisPelanggaranSelect.html('<option value="">Loading...</option>');

                $.get(`/get-jenis-pelanggaran/${dasarID}`, function(data) {

                    let html = '<option value="">-- Pilih Jenis Pelanggaran --</option>';

                    data.forEach(item => {
                        html += `<option value="${item.id}">${item.nama}</option>`;
                    });

                    jenisPelanggaranSelect.html(html);
                });
            });

            let dasarPengenaanSanksiOld = $('.dasar-pengenaan-sanksi').val();

            if (dasarPengenaanSanksiOld) {
                $('.dasar-pengenaan-sanksi').trigger('change');
            }
        });

        function addRow() {

            // destroy select2 yang SUDAH aktif saja
            $('.select2').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });

            let container = document.getElementById('data-container');
            let first = container.querySelector('.data-item');
            let clone = first.cloneNode(true);

            // reset semua input
            clone.querySelectorAll('input, textarea').forEach(el => el.value = '');

            // reset semua select
            clone.querySelectorAll('select').forEach(el => {
                el.selectedIndex = 0;
            });

            // reset dependent dropdown
            clone.querySelector('.pelaku-usaha').innerHTML =
                '<option value="">-- Pilih Jenis Pelaku Usaha --</option>';

            clone.querySelector('.kategori-sp').innerHTML =
                '<option value="">-- Pilih Jenis Pelanggaran --</option>';

            container.appendChild(clone);

            // re-init select2 setelah append
            $('.select2').select2({
                width: '100%'
            });
        }

        function removeRow(btn) {
            let items = document.querySelectorAll('.data-item');
            if (items.length > 1) {
                btn.closest('.data-item').remove();
            } else {
                alert('Minimal 1 data');
            }
        }
    </script>
@endsection
