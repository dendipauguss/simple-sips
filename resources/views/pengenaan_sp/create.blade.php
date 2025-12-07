@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-8 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <!-- Horizontal Form -->
                            <form action="{{ url('pengenaan-sp') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                    <div class="col-sm">
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="perusahaan_id" class="col-sm-2 col-form-label">Perihal</label>
                                    <div class="col-sm-10">
                                        <select name="perihal_id" id="perihal_id"
                                            class="form-select @error('perihal_id') is-invalid @enderror">
                                            @foreach ($perihal as $per)
                                                <option value="{{ $per->id }}">{{ $per->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('perihal')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jenis_perusahaan" class="col-sm-2 col-form-label">Jenis Perusahaan</label>
                                    <div class="col-sm-10">
                                        <select name="jenis_perusahaan" id="jenis_perusahaan" class="form-select">
                                            @foreach ($jenis_perusahaan as $jp)
                                                <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="perusahaan_id" class="col-sm-2 col-form-label">Perusahaan</label>
                                    <div class="col-sm-10">
                                        <select name="perusahaan_id" id="perusahaan_id" class="form-select">
                                            <option value="">-- Pilih Jenis Perusahaan Terlebih Dahulu --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="sanksi_id" class="col-sm-2 col-form-label">Bentuk Sanksi</label>
                                    <div class="col-sm-10">
                                        <select name="sanksi_id" id="sanksi_id" class="form-select">
                                            <option value="">-- Pilih Bentuk Sanksi --</option>
                                            @foreach ($sanksi as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="perintah_id" class="col-sm-2 col-form-label">Perintah Sanksi</label>
                                    <div class="col-sm-10">
                                        <div id="checkbox_perintah_sanksi" class="mt-2">
                                        </div>
                                        <div class="mt-1 d-flex">
                                            <label for="perintah_lainnya"
                                                class="me-1 col-form-label col-form-label-sm">Lainnya : </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="perintah_lainnya" id="perintah_lainnya"
                                                    placeholder="Perintah lainnya ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" placeholder="Keterangan" name="deskripsi" rows="10"></textarea>
                                    </div>
                                </div> --}}

                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ url('penindakan') }}" class="btn btn-sm btn-light"> ⬅ Kembali</a>
                            </form>
                            <!-- END : Horizontal Form -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        const perintahSanksiData = {!! json_encode(
            collect($sanksi)->mapWithKeys(function ($s) use ($perintah_sanksi) {
                    return [
                        $s->id => collect($perintah_sanksi)->where('sanksi_id', $s->id)->values()->all(),
                    ];
                })->toArray(),
        ) !!};
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mulai = document.getElementById('tanggal_mulai');
            const selesai = document.getElementById('tanggal_selesai');

            // Hari ini
            let today = new Date();
            let startDate = today.toISOString().split('T')[0];

            // Tambah 1 bulan dari hari ini
            let endDate = new Date(today);
            endDate.setMonth(endDate.getMonth() + 1);

            // Format sebagai yyyy-mm-dd
            endDate = endDate.toISOString().split('T')[0];

            // Set ke input
            mulai.value = startDate;
            selesai.value = endDate;

            const sanksiSelect = document.getElementById("sanksi_id");
            const checkboxContainer = document.getElementById("checkbox_perintah_sanksi");

            const selectedValues = <?= json_encode($perintah_sanksi_terpilih ?? []) ?>;
            // misal: [10, 12] → dari database

            function updateCheckbox() {
                const selectedId = sanksiSelect.value;

                checkboxContainer.innerHTML = "";

                const list = perintahSanksiData[selectedId] || [];

                if (list.length === 0) {
                    checkboxContainer.innerHTML = "<p class='text-muted'>Tidak ada perintah sanksi.</p>";
                    return;
                }

                list.forEach(item => {
                    const wrapper = document.createElement("div");
                    wrapper.classList.add("form-check");

                    const input = document.createElement("input");
                    input.type = "checkbox";
                    input.name = "perintah_id[]";
                    input.value = item.id;
                    input.classList.add("form-check-input");

                    // tandai yang sudah dipilih sebelumnya
                    if (selectedValues.includes(item.id)) {
                        input.checked = true;
                    }

                    const label = document.createElement("label");
                    label.classList.add("form-check-label");
                    label.textContent = item.nama;

                    wrapper.appendChild(input);
                    wrapper.appendChild(label);

                    checkboxContainer.appendChild(wrapper);
                });
            }

            sanksiSelect.addEventListener("change", updateCheckbox);

            // init ketika load page (biar edit form jalan)
            updateCheckbox();

        });

        $(document).ready(function() {

            // Aktifkan Select2
            $('.select2').select2({
                theme: "classic"
            });

            $('#jenis_perusahaan').on('change', function() {
                let jenisID = $(this).val();

                $.ajax({
                    url: `/get-perusahaan/${jenisID}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let perusahaanSelect = $('#perusahaan_id');

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

        });
    </script>
@endsection
