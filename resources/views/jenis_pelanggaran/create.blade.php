@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            @php $jumlah = !empty(old('nama')) ? count(old('nama')) : 1;  @endphp
            <form action="{{ url('pengaturan/jenis-pelanggaran') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-12 mb-3 mb-xl-0">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" class="btn btn-success me-1" onclick="addRow()">Tambah
                                    lagi</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-sm btn-light"> ⬅ Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3" id="dataContainer">
                    @for ($i = 0; $i < $jumlah; $i++)
                        <div class="col mt-1 data-item" style="flex: 1 1 300px;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-2">
                                            <label for="nama" class="col col-form-label">Nama Jenis Pelanggaran</label>
                                            <input type="text"
                                                class="form-control @error("nama.$i") is-invalid @enderror" id="nama"
                                                name="nama[]" value="{{ old('nama.' . $i) }}" autofocus>
                                            @error("nama.$i")
                                                <div class="invalid-feedback"> {{ str_replace(':number', $i + 1, $message) }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row text-end">
                                        <button type="button" class="btn btn-danger btn-remove"
                                            onclick="removeRow(this)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </form>
        </div>
    </div>
    <script>
        function addRow() {
            let container = document.getElementById("dataContainer");
            let firstRow = document.querySelector(".data-item");
            let newRow = firstRow.cloneNode(true); // Clone seluruh elemen

            // Kosongkan input baru
            newRow.querySelectorAll("input").forEach(input => input.value = "");

            container.appendChild(newRow);
        }

        function removeRow(button) {
            let row = button.closest(".data-item");

            if (document.querySelectorAll(".data-item").length > 1) {
                row.remove();
            } else {
                alert("Minimal harus ada satu data.");
            }
        }
    </script>
@endsection
