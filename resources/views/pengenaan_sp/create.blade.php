@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <form action="{{ route('pengenaan-sp.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col mb-3 mb-xl-0">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- Horizontal Form -->
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">No. Surat</label>
                                    <select name="no_surat" id="no_surat"
                                        class="form-select @error('no_surat') is-invalid @enderror">
                                        <option value="UD.02.01">UD.02.01</option>
                                        <option value="UD.01.00">UD.01.00</option>
                                    </select>
                                    {{-- <input type="text" name="no_surat" class="form-control"
                                        value="{{ $no_surat_template }}"> --}}
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bentuk Sanksi</label>
                                    <select name="sanksi_id" id="sanksi_id"
                                        class="form-select @error('sanksi_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Bentuk Sanksi --</option>
                                        @foreach ($sanksi as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('sanksi_id') == $s->id ? 'selected' : '' }}>{{ $s->kode_surat }} -
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
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Jatuh Tempo</label>
                                    <input type="date" name="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelaku Usaha</label>
                                    <select name="jenis_pelaku_usaha_id"
                                        class="form-select @error('jenis_pelaku_usaha_id') is-invalid @enderror"
                                        id="jenis_pelaku_usaha_id">
                                        @foreach ($jenis_pelaku_usaha as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('jenis_pelaku_usaha_id') == $p->id ? 'selected' : '' }}>
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
                                    <select name="pelaku_usaha_id" id="pelaku_usaha_id"
                                        class="form-select select2 @error('pelaku_usaha_id') is-invalid @enderror">
                                        <option>-- Pilih Jenis Pelaku Usaha Terlebih Dahulu --</option>
                                    </select>
                                    @error('pelaku_usaha_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- END : Horizontal Form -->
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3 mb-xl-0">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelanggaran</label>
                                    <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id"
                                        class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror">
                                        @foreach ($jenis_pelanggaran as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jenis_pelanggaran_id') == $j->id ? 'selected' : '' }}>
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
                                    <select name="kategori_sp_id" id="kategori_sp_id"
                                        class="form-select @error('kategori_sp_id') is-invalid @enderror">
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
                                    <textarea name="detail_pelanggaran" class="form-control" style="height: 100px">{{ old('detail_pelanggaran') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Dokumen</label>
                                    <input type="file" name="lampiran[]" id="lampiran" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
            </form>
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
        </div>
    </div>
    </div>
    <script>
        const oldPelakuUsahaId = "{{ old('pelaku_usaha_id') }}";
        const oldKategoriSanksiId = "{{ old('kategori_sp_id') }}";

        $(document).ready(function() {
            // Aktifkan Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });

            $('#jenis_pelaku_usaha_id').on('change', function() {
                let jenisID = $(this).val();

                $.ajax({
                    url: `/get-pelaku-usaha/${jenisID}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let perusahaanSelect = $('#pelaku_usaha_id');

                        // Kosongkan select perusahaan
                        perusahaanSelect.empty();
                        perusahaanSelect.append(
                            `<option value="" disabled>-- Pilih Perusahaan --</option>`);

                        // Isi ulang dengan data baru
                        $.each(data, function(index, item) {
                            let selected = (oldPelakuUsahaId == item.id) ? 'selected' :
                                '';
                            perusahaanSelect.append(
                                `<option value="${item.id}" ${selected}>${item.nama}</option>`
                            );
                        });

                        // Refresh select2 setelah update
                        perusahaanSelect.trigger('change');
                    }
                });
            });

            let jenisOld = $('#jenis_pelaku_usaha_id').val();

            if (jenisOld) {
                $('#jenis_pelaku_usaha_id').trigger('change');
            }

            $('#jenis_pelanggaran_id').on('change', function() {
                let jenisID = $(this).val();

                $.ajax({
                    url: `/get-kategori-sp/${jenisID}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        kategoriSelect = $('#kategori_sp_id');

                        // Kosongkan select perusahaan
                        kategoriSelect.empty();
                        kategoriSelect.append(
                            `<option value="" disabled>-- Pilih Kategori Sanksi --</option>`
                        );

                        // Isi ulang dengan data baru
                        $.each(data, function(index, item) {
                            let selected = (oldKategoriSanksiId == item.id) ?
                                'selected' :
                                '';
                            kategoriSelect.append(
                                `<option value="${item.id}" ${selected}>${item.nama}</option>`
                            );
                        });

                        // Refresh select2 setelah update
                        kategoriSelect.trigger('change.select2');
                    }
                });
            });

            let pelanggaranOld = $('#jenis_pelanggaran_id').val();

            if (pelanggaranOld) {
                $('#jenis_pelanggaran_id').trigger('change');
            }
        });
    </script>
@endsection
