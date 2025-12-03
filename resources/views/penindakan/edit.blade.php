@extends('layouts.app')

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">

            <div class="row">
                <div class="col-xl-8 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">

                            <!-- Horizontal Form -->
                            <form action="{{ url('penindakan/' . $penindakan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- PERIODE --}}
                                <div class="row mb-3">
                                    <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                    <div class="col-sm">
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                                            value="{{ $penindakan->tanggal_mulai }}">
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                            class="form-control" value="{{ $penindakan->tanggal_selesai }}">
                                    </div>
                                </div>

                                {{-- PERUSAHAAN --}}
                                <div class="row mb-3">
                                    <label for="perusahaan_id" class="col-sm-2 col-form-label">Perusahaan</label>
                                    <div class="col-sm-10">
                                        <select name="perusahaan_id" id="perusahaan_id" class="form-select">
                                            @foreach ($perusahaan as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ $p->id == $penindakan->perusahaan_id ? 'selected' : '' }}>
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- SANKSI --}}
                                <div class="row mb-3">
                                    <label for="sanksi_id" class="col-sm-2 col-form-label">Bentuk Sanksi</label>
                                    <div class="col-sm-10">
                                        <select name="sanksi_id" id="sanksi_id" class="form-select">
                                            <option value="">-- Pilih Bentuk Sanksi --</option>
                                            @foreach ($sanksi as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ $s->id == $penindakan->sanksi_id ? 'selected' : '' }}>
                                                    {{ $s->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- PERINTAH SANKSI --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Perintah Sanksi</label>
                                    <div class="col-sm-10">

                                        <div id="checkbox_perintah_sanksi" class="mt-2"></div>

                                        <div class="mt-1 d-flex">
                                            <label for="perintah_lainnya"
                                                class="me-1 col-form-label col-form-label-sm">Lainnya :</label>

                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="perintah_lainnya" id="perintah_lainnya"
                                                    value="{{ $penindakan->perintah_lainnya }}"
                                                    placeholder="Perintah lainnya ...">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- DESKRIPSI --}}
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" placeholder="Keterangan" name="deskripsi" rows="10">{{ $penindakan->deskripsi }}</textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                <a href="{{ url('penindakan') }}" class="btn btn-sm btn-light">⬅ Kembali</a>

                            </form>
                            <!-- END : Horizontal Form -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Data perintah berdasarkan sanksi --}}
    <script>
        const perintahSanksiData = {!! json_encode(
            collect($sanksi)->mapWithKeys(function ($s) use ($perintah_sanksi) {
                    return [
                        $s->id => collect($perintah_sanksi)->where('sanksi_id', $s->id)->values()->all(),
                    ];
                })->toArray(),
        ) !!};

        // Perintah yang sudah dipilih (ID Array)
        const selectedValues = {!! json_encode($perintah_terpilih) !!};
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const sanksiSelect = document.getElementById("sanksi_id");
            const checkboxContainer = document.getElementById("checkbox_perintah_sanksi");

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

                    // Centang otomatis
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

            // Trigger ketika edit pertama dibuka
            updateCheckbox();

            // Ketika sanksi berubah
            sanksiSelect.addEventListener("change", updateCheckbox);
        });
    </script>
@endsection
