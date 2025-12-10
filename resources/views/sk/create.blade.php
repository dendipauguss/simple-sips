@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">

            <div class="row">
                <div class="col mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <!-- Horizontal Form -->
                            <div class="mb-3">
                                <label class="form-label">No. Surat</label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $pengenaan_sp->no_surat }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bentuk Sanksi</label>
                                <select name="sanksi_id" id="sanksi_id" class="form-select" disabled>
                                    <option>{{ $pengenaan_sp->sanksi->nama }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal_mulai" class="form-control"
                                    value="{{ $pengenaan_sp->tanggal_mulai }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" name="tanggal_selesai" class="form-control"
                                    value="{{ $pengenaan_sp->tanggal_selesai }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Pelaku Usaha</label>
                                <select name="jenis_pelaku_usaha_id" class="form-select" id="jenis_pelaku_usaha_id"
                                    disabled>
                                    <option>{{ $pengenaan_sp->pelaku_usaha->jenis_pelaku_usaha->nama }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Perusahaan</label>
                                <select name="pelaku_usaha_id" id="pelaku_usaha_id" class="form-select" disabled>
                                    <option>{{ $pengenaan_sp->pelaku_usaha->nama }}</option>
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
                                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select" disabled>
                                    <option>{{ $pengenaan_sp->jenis_pelanggaran->nama }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori Sanksi</label>
                                <select name="kategori_sp_id" id="kategori_sp_id" class="form-select" disabled>
                                    <option value="">{{ $pengenaan_sp->kategori_sp->nama }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Detail Pelanggaran</label>
                                <textarea name="detail_pelanggaran" class="form-control" style="height: 100px" disabled>{{ $pengenaan_sp->detail_pelanggaran }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-3 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <form action="">
                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Dokumen</label>
                                    <input type="file" name="lampiran[]" id="lampiran" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
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
