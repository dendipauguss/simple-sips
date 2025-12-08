@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-8 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <!-- Horizontal Form -->
                            <form action="{{ route('pengenaan-sp.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">No. SP</label>
                                    <input type="text" name="no_sp" class="form-control" value="{{ $no_sp_template }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal SP</label>
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
                                    <textarea name="detail_pelanggaran" class="form-control"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                            <!-- END : Horizontal Form -->
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
