@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-body">

                            <form action="{{ route('perusahaan.update', $perusahaan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Perusahaan</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ $perusahaan->nama }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" required>{{ $perusahaan->alamat }}</textarea>
                                </div>


                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
