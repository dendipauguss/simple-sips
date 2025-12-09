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
                                    <input type="text" name="no_surat" class="form-control"
                                        value="{{ $no_surat_template }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bentuk Sanksi</label>
                                    <select name="sanksi_id" id="sanksi_id" class="form-select">
                                        <option value="">-- Pilih Bentuk Sanksi --</option>
                                        @foreach ($sanksi as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Surat</label>
                                    <input type="date" name="tanggal_mulai" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Jatuh Tempo</label>
                                    <input type="date" name="tanggal_selesai" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelaku Usaha</label>
                                    <select name="jenis_pelaku_usaha_id" class="form-select" id="jenis_pelaku_usaha_id">
                                        @foreach ($jenis_pelaku_usaha as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Perusahaan</label>
                                    <select name="pelaku_usaha_id" id="pelaku_usaha_id" class="form-select">
                                        <option value="">-- Pilih Jenis Pelaku Usaha Terlebih Dahulu --</option>
                                    </select>
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
                                    <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select">
                                        @foreach ($jenis_pelanggaran as $j)
                                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori SP</label>
                                    <select name="kategori_sp_id" id="kategori_sp_id" class="form-select">
                                        <option value="">-- Pilih Jenis Pelanggaran Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Detail Pelanggaran</label>
                                    <textarea name="detail_pelanggaran" class="form-control" style="height: 100px"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Dokumen</label>
                                    <input type="file" name="lampiran[]" id="lampiran" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
            </form>
            <div class="col-xl-3 mb-3 mb-xl-0">
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
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {

            // Aktifkan Select2
            $('.select2').select2({
                theme: "bootstrap-5"
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
                            `<option value="">-- Pilih Perusahaan --</option>`);

                        // Isi ulang dengan data baru
                        $.each(data, function(index, item) {
                            perusahaanSelect.append(
                                `<option value="${item.id}">${item.nama}</option>`
                            );
                        });

                        // Refresh select2 setelah update
                        perusahaanSelect.trigger('change.select2');
                    }
                });
            });

            $('#jenis_pelanggaran_id').on('change', function() {
                let jenisID = $(this).val();

                $.ajax({
                    url: `/get-kategori-sp/${jenisID}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let perusahaanSelect = $('#kategori_sp_id');

                        // Kosongkan select perusahaan
                        perusahaanSelect.empty();
                        perusahaanSelect.append(
                            `<option value="">-- Pilih Kategori SP --</option>`);

                        // Isi ulang dengan data baru
                        $.each(data, function(index, item) {
                            perusahaanSelect.append(
                                `<option value="${item.id}">${item.nama}</option>`
                            );
                        });

                        // Refresh select2 setelah update
                        perusahaanSelect.trigger('change.select2');
                    }
                });
            });

        });
    </script>
@endsection
