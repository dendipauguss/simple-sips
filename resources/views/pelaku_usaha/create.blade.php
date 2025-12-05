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
                            <form action="{{ url('perusahaan') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Jenis Perusahaan</label>
                                    <div class="col-sm-10">
                                        <select name="jenis_id" id="jenis_id">
                                            @foreach ($jenis_perusahaan as $jp)
                                                <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat Perusahaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="alamat" name="alamat">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <button onclick="window.history.back()" class="btn btn-sm btn-light"> ⬅ Kembali</button>
                            </form>
                            <!-- END : Horizontal Form -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
