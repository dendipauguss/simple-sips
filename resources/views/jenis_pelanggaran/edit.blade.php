@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-body">

                            <form action="{{ route('jenis-pelanggaran.update', $jenis_pelanggaran->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Jenis Pelanggaran</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ $jenis_pelanggaran->nama }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-light">⬅ Kembali</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
