@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <!-- Horizontal Form -->
                            <form
                                action="{{ isset($kategori_sp) ? url('pengaturan/kategori-sp', $kategori_sp->id) : url('pengaturan/kategori-sp') }}"
                                method="POST">
                                @csrf
                                @isset($kategori_sp)
                                    @method('PUT')
                                @endisset
                                <div class="row mb-3">
                                    <label for="jenis_pelanggaran" class="col-sm-2 col-form-label">Jenis Pelanggaran</label>
                                    <div class="col-sm-10">
                                        <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select">
                                            @php
                                                $selected = old(
                                                    'jenis_pelanggaran_id',
                                                    isset($kategori_sp) ? $kategori_sp->jenis_pelanggaran_id : null,
                                                );
                                            @endphp
                                            @foreach ($jenis_pelanggaran as $jp)
                                                <option value="{{ $jp->id }}"
                                                    {{ $selected == $jp->id ? 'selected' : '' }}>{{ $jp->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Kategori Sanksi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama"
                                            value="{{ isset($kategori_sp) ? old('nama', $kategori_sp->nama) : old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                @if (isset($kategori_sp))
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                @endif
                                <a href="{{ url('pengaturan/kategori-sp') }}" class="btn btn-sm btn-light"> ⬅
                                    Kembali</a>
                            </form>
                            <!-- END : Horizontal Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
