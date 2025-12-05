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
                            <form action="{{ url('pengaturan/perintah-sanksi') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Bentuk Sanksi</label>
                                    <div class="col-sm-10">
                                        <select name="sanksi_id" id="sanksi_id" class="form-select">
                                            @foreach ($sanksi as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Perintah Sanksi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ url('pengaturan/perintah-sanksi') }}" class="btn btn-sm btn-light"> ⬅
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
