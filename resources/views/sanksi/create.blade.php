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
                            <form action="{{ url('pengaturan/sanksi') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Bentuk Sanksi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kode_surat" class="col-sm-2 col-form-label">Kode Surat</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('kode_surat') is-invalid @enderror"
                                            id="kode_surat" name="kode_surat">
                                        @error('kode_surat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ url('pengaturan/sanksi') }}" class="btn btn-sm btn-light"> ⬅ Kembali</a>
                            </form>
                            <!-- END : Horizontal Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
